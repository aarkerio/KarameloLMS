<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright 2006-2014, Chipotle Software(c)
*  @version 0.7
*  @package tests
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: app/Controller/QuizzesController.php

/**
 *  Include files
 */
App::uses('Sanitize', 'Utility');
  
class QuizzesController extends AppController {

/**
 *  Cake Helpers
 *  @var array
 *  @access public
 */
 public $helpers    = array('Ck', 'Paginator');  

/**
 *  Cake components
 *  @var array
 *  @access public
 */
 public $components = array('Edublog', 'Mailer');

/**
 *  Cake paginate
 *  @var array
 *  @access public
 */
 public $paginate = array(
                          'limit' => 25,
                          'order' => array('Quiz.title' => 'ASC')
                         );

/**
 *  Auth Component permisssions
 *  @access public
 *  @return void 
 */  
 public function beforeFilter() 
 {
   parent::beforeFilter();
   if ( $this->Auth->user() ):
       $this->Auth->allow(array('view', 'display', 'result', 'read'));
   endif;
 }

/**
 *  Auth Component permisssions
 *  @access public
 *  @return void 
 */
 public function display($username)
 {
  $this->Edublog->setUserId($username); # blogger elements
  $params = array('conditions' => array('Quiz.user_id'=> $this->Edublog->userId, 'Quiz.status'=>1));
  $this->set('data', $this->Quiz->find('all', $params));
 }
 
/**
 *  Display test and it questions
 *  @access public
 *  @param string  $username
 *  @param integer $quiz_id
 *  @param integer $vclassroom_id
 *  @return void 
 */ 
 public function view($username, $quiz_id, $vclassroom_id)
 {
  $this->Edublog->setUserId($username); # blogger elements
  $this->Edublog->checkPermissions($vclassroom_id, $quiz_id, 'Quiz', $this->Auth->user('id')); # set permissions
  $conditions = array('Quiz.id'=>$quiz_id);
  if ( $this->Edublog->userId != $this->Auth->user('id')):  # teacher can view test even if status = 0
      $conditions['Quiz.status'] = 1;
  endif;
  # get questions 
  $data = $this->Quiz->find('all', array('conditions'=>$conditions, 'contain' => array('Question'=>array('Answer'))));
  if ( !$data ):
      $this->msgFlash(__('Resource is not public'), '/blog/'.$username);
      return False;
  endif;

  $params = array('conditions'=>array('QuizVclassroom.test_id'=>$quiz_id, 'QuizVclassroom.vclassroom_id'=>$vclassroom_id),
                     'fields'    =>array('QuizVclassroom.vclassroom_id',  'QuizVclassroom.fdate',  'QuizVclassroom.sdate'),'recursive'=>0);
  $data['t'] = $this->Quiz->QuizVclassroom->find('first', $params); 
  $this->set('data',$data);
 }


/**
 *  Read -- preview tests before save
 *  @access public
 *  @return void
 */
 public function read() 
 {
  try {
  #debug($this->request->data);
  $this->Edublog->setUserId($this->request->data['Quiz']['blogger']); # blogger elements
  $this->Edublog->checkPermissions($this->request->data['Quiz']['vclassroom_id'], $this->request->data['Quiz']['test_id'], 'Quiz', $this->Auth->user('id')); # set permissions
  if ( $this->viewVars['permissions']['belongs'] != 1 or $this->viewVars['permissions']['already'] == 1  or $this->viewVars['permissions']['chkdate'] != 1 ):
      $this->redirect('/');
      return False;
  endif;
  $conditions = array('Quiz.id'=> $this->request->data['Quiz']['test_id']);
  if ( $this->Edublog->userId != $this->Auth->user('id')): # if teacher, show test even if is in draft status 
      $conditions['Quiz.status'] = 1;
  endif;
  $data = $this->Quiz->find('all', array('conditions'=>$conditions, 'contain' => array('Question'=>array('Answer'))));
  if ( !$data ):
      $this->msgFlash(__('Resource is not public'), '/blog/'.$username);
      return False;
  endif;
  $params = array('conditions'=>array('QuizVclassroom.test_id'=> $this->request->data['Quiz']['test_id'], 'QuizVclassroom.vclassroom_id'=> $this->request->data['Quiz']['vclassroom_id']),
           'fields' =>array('QuizVclassroom.vclassroom_id','QuizVclassroom.fdate','QuizVclassroom.sdate'),'recursive'=>0);
  $data['t'] = $this->Quiz->QuizVclassroom->find('first', $params);
  $this->set('data',$data);
  $this->set('answers',$this->request->data['Quiz']);
  }
  catch (Exception $e) 
  {
    echo "Caught my exception\n" . $e;
  }
 }

/**
 *  Save student answers and show results
 *  @access public
 *  @return void 
 */
 public function result()
 { 
  if ( !$this->Auth->user() or !isset($this->request->data['Quiz'])):
      $this->redirect('/');
      return False;
  endif; 

  try {
    #die(debug($this->request->data));
   
    $this->Edublog->setUserId($this->request->data['Quiz']['blogger']); # blogger elements
    $this->Edublog->checkPermissions($this->request->data['Quiz']['vclassroom_id'], $this->request->data['Quiz']['test_id'], 'Quiz', $this->Auth->user('id')); # set permissions
    if ( $this->viewVars['permissions']['belongs'] != 1 or $this->viewVars['permissions']['already'] == 1  or $this->viewVars['permissions']['chkdate'] != 1 ):
        $this->redirect('/');
        return False;
    endif;

    # Get all questions and answers if option multiple
    $params = array(
                    'conditions'=> array('Question.test_id'=>$this->request->data['Quiz']['test_id']), 
                    'fields'    => array('Quiz.title', 'Question.id',  'Question.type'),
                    'contain'   => array('Quiz', 'Answer')
                   );
    $quizs = $this->Quiz->Question->find('all',$params); #get all the questions
    #debug($this->request->data['Quiz']);
    #die(debug($quizs));
    # start building data for save in Result model
    $points  = (int) 0; # points sum only in multiple option question
    $this->request->data['Result']['user_id']        = (int) $this->Auth->user('id');
    $this->request->data['Result']['test_id']        = (int) $this->request->data['Quiz']['test_id']; 
    $this->request->data['Result']['vclassroom_id']  = (int) $this->request->data['Quiz']['vclassroom_id'];
    $open_question = (bool) False;    # False by default
    #die(debug($quizs));
    foreach($this->request->data['Quiz'] as $k => $t): # doing loop to answers
        if ( is_numeric($k) ):  # is numeric means this is an student answer, multiple option or openquestion, id est: $k = Question.id
            $this->request->data['Result']['question_id']  = (int) $k;
            # in this point I need to know if question is type 1 or 2
            $type = (int) $this->Quiz->Question->field('type', array('id'=>$k));
            if ( $type == 1 ): # multiple choice
                $res = $this->Quiz->Question->Answer->find('first', array('conditions' => array('Answer.id'=>$t)));
                #die(debug($res));
                if ( $res['Answer']['correct'] == 1):    # is the answer correct ?
	                $points += (int) $res['Question']['worth'];   # sum good points 
                    $this->request->data['Result']['correct'] = (int) 1; # teacher can change this later if he/she wants
	            endif;
                $this->request->data['Result']['answer']     = (string) '';
                $this->request->data['Result']['answer_id']  = (int) $t; #save student answer
            elseif (  $type == 2 ): # open question
                $this->request->data['Result']['answer']     = (string) $t;
                $this->request->data['Result']['answer_id']  = (string) 0; # just to pass validation, but in open question  answer_id doesn_t matter.
                $open_question = True; # there are open questions in this quizz test
            endif;
            $this->Quiz->Result->id = False;
            $this->Quiz->Result->create();
            #debug($this->request->data['Result']);
            if ( !$this->Quiz->Result->save($this->request->data) ):
                die(debug($this->Quiz->Result->validationErrors));
            endif;
        endif;
    endforeach;

    # After save student answers I create a new QuizsStudent row, in this way the teacher can know what examn has been scored
    $this->request->data['QuizStudent']['user_id']        = (int) $this->Auth->user('id');
    $this->request->data['QuizStudent']['test_id']        = (int) $this->request->data['Quiz']['test_id']; 
    $this->request->data['QuizStudent']['vclassroom_id']  = (int) $this->request->data['Quiz']['vclassroom_id'];
    $this->Quiz->QuizsStudent->save($this->request->data);
    # QuizsStudent stuff ENDS

    # Send email teacher(s) section STARTS
    $teachers = $this->Quiz->User->getTeachers($this->request->data['Quiz']['vclassroom_id']);
    # die(debug($teachers));
    $title = $this->Quiz->field('Quiz.title', array('Quiz.id'=>$this->request->data['Quiz']['test_id']));
    # Send email to teacher
    $sendArray = array(
             'subject' => __('Quiz Quiz answered'),
             'message' => __('Student').' '.$this->Auth->user('username').' '.__('has answered the kandie'). ': '.$title,
                    );
    $this->Mailer->sendMany($sendArray, $teachers);
    # Send email teacher(s) section  ENDS
    $maxpoints  = (int) $this->request->data['Quiz']['maxpoints'];
    $percentage = number_format( (($points / $maxpoints)*100), 2, '.', '');
    $this->request->data['Quiz']['results']     = $points;         
    $this->request->data['Quiz']['percentage']  = $percentage;     
    $this->set('data', $this->request->data['Quiz']);
    
    $params = array(
                    'conditions' => array('Question.test_id'=>$this->request->data['Result']['test_id']),
                    'fields'     => array('Question.question', 'Question.hint', 'Question.explanation', 'Question.type')
                   );
    $this->Quiz->Question->contain();
    $this->set('open_question', $open_question);
    $this->set('answers', $this->Quiz->Question->find('all', $params));
    $this->set('vclassroom_id', $this->request->data['Result']['vclassroom_id']);
  }
  catch (Exception $e) 
  {
      echo "Caught my exception\n" . $e;
  }   
 }

/**####   === ADMIN METHODS ====  ###**/

/** 
 * Get teacher's tests
 * @access public
 * @param integer $vclassroom_id
 * @return array empty or populated
 */ 
 public function admin_get($vclassroom_id)
 {      
   $this->layout = 'ajax';
   return $this->Quiz->getQuizs($this->Auth->user('id'), $vclassroom_id);
 }

/** 
 * Display Quiz tests
 * @access public
 * @return void
 */ 
 public function admin_listing()
 {   
   $this->layout    = 'admin';
  
   $this->paginate = array('conditions' => array('Quiz.user_id'=>$this->Auth->user('id')),
                           'fields'     => array('Quiz.id', 'Quiz.user_id', 'Quiz.title', 'Quiz.description', 'Quiz.status'),
                           'order'      => 'Quiz.title DESC',
                           'contain'    => False);
   $data = $this->paginate('Quiz');
   $this->set(compact('data'));
 }


/**
 *  Display preview test and it questions
 *  @access public
 *  @param integer $quiz_id
 *  @return void 
 */ 
 public function admin_view($quiz_id)
 {
 try {
     $this->layout    = 'popup';   
     $params = array('conditions' => array('Quiz.id'=>$quiz_id, 'Quiz.user_id'=>$this->Auth->user('id')), 
                     'contain'    => array('Question'=>array('Answer'))
                    );
     # get questions 
     $data = $this->Quiz->find('first', $params);
     $this->set('data',$data);
  }
  catch (Exception $e) 
  {
      echo "Caught my exception\n" . $e;
  }
 }

/**
 *  List all tests answered
 *  @access public
 *  @return void
 *  @param integer $vclassroom_id
 */
 public function admin_record($vclassroom_id)
 {
   $this->layout = 'admin';
   $data = $this->Quiz->testsAnswered($vclassroom_id);
   $this->set('vclassroom_id', $vclassroom_id);
   #die(debug($data));
   $this->set(compact('data'));
 }


/**
 * Quiz evaluated
 * @access public
 * @return void
 * @param integer $report_id
 */
 public function admin_share($report_id)
 {
   $data = $this->Quiz->getData($report_id); # Model call
   #die(debug($data));
   
   $this->Quiz->id  = (int) $report_id; 
      
   if ($this->Quiz->saveField('checked', 1)):
       # Email STARTS
       $email   = (string) $data['User']['email'];
       $subject = (string) $data['Vclassroom']['name'];
       $message = __('The teacher has called the file you sent'). ': '. $data['Quiz']['description']."\n";
       $this->Mailer->set('url', '/vclassrooms/show/'. $data['teacher_username'].'/'.$data['Quiz']['vclassroom_id']);
       $this->Mailer->set('message', $message);
       $this->Mailer->template = 'default';
       $this->Mailer->sendAs   = 'html'; 
       $this->Mailer->subject  = $subject;
       $this->Mailer->send($email);
       # Email ENDS   
       $this->msgFlash(__('Quiz graded'), $this->referer());
   endif;
  }


/**
 * Send result to 
 * @access public
 * @return void
 * @param integer $report_id
 */
 public function admin_compose($quiz_id, $user_id, $vclassroom_id)
 {
   $params = array('conditions' => array('Quiz.id'=>$quiz_id),
                   'fields'     => array('Quiz.title', 'Quiz.user_id'),
                   'contain'    => array('User'=>array('fields'=>array('User.username'))));

   $data   = $this->Quiz->find('first',$params);
      
   #die(debug($data));
   $points = $this->Quiz->getPoints($quiz_id, $user_id, $vclassroom_id);

   # Email STARTS
   $email  = $this->Quiz->User->field('email',array('User.id'=>$user_id));
   $message = 'In exam '.$data['Quiz']['title'].' '.__('you test score is').' ' .$points;
   $this->Mailer->set('url', '/vclassrooms/show/'. $data['User']['username'].'/'.$vclassroom_id);
   $this->Mailer->set('message', $message);
   $this->Mailer->subject  =  __('Your exam results');
   $this->Mailer->template = 'default';
   $this->Mailer->sendAs   = 'html'; 
   $this->Mailer->send($email);
   # Email ENDS
   
   $quizsStudentId = $this->Quiz->QuizsStudent->field('id',array('QuizStudent.user_id'=>$user_id,'QuizStudent.test_id'=>$quiz_id,'QuizStudent.vclassroom_id'=>$vclassroom_id));
   
   $this->Quiz->QuizsStudent->id = (int) $quizsStudentId;
   $this->Quiz->QuizsStudent->saveField('checked', 1);
   $this->msgFlash(__('The test score has been sent'), '/admin/tests/record/'.$vclassroom_id);
 }

/**
 * Link to vClassroom
 * @return void
 * @access public
 */ 
 public function admin_link2class() 
 {
  $this->layout    = 'admin';
  
  if ( !empty($this->request->data['QuizVclassroom']) ):
      $this->request->data['QuizVclassroom'] = Sanitize::clean($this->request->data['QuizVclassroom']);
      if ( $this->Quiz->QuizVclassroom->save($this->request->data['QuizVclassroom'])):
          if ( isset($this->request->data['QuizVclassroom']['popup']) ):   
              $url = '/admin/vclassrooms/dide/'.$this->request->data['QuizVclassroom']['vclassroom_id'];
          else:
              $url = '/admin/tests/vclassrooms/'.$this->request->data['QuizVclassroom']['test_id'];
          endif;
          $this->msgFlash(__('Quiz assigned'),$url);
      endif;
  endif;
 }

/**
 * Unlink to vClassroom
 * @access public
 * @return void
 */ 
 public function admin_unlink2class() 
 {
  $this->layout    = 'admin';

  if ( !empty($this->request->data['QuizVclassroom']) ):
      $this->request->data['QuizVclassroom'] = Sanitize::clean($this->request->data['QuizVclassroom']);

      if ( $this->Quiz->QuizVclassroom->delete($this->request->data['QuizVclassroom']['id'])):
           if (isset($this->request->data['QuizVclassroom']['popup'])):
               $return =  '/admin/vclassrooms/dide/'.$this->request->data['QuizVclassroom']['vclassroom_id'];
           else:
               $return =  '/admin/tests/vclassrooms/'.$this->request->data['QuizVclassroom']['test_id'];               
           endif;
           $this->msgFlash(__('Kandie unlinked'), $return);
      endif;
  endif;
 }
 
/**
 * Edit Quizz Quiz
 * @access public
 * @param mixed $quiz_id  integer or boolean
 * @return void
 */ 
 public function admin_edit($quiz_id=Null) 
 {
   $this->layout    = 'admin';
   
   if (!empty($this->request->data['Quiz'])):   # insert or update
       $this->request->data['Quiz']['user_id'] = (int) $this->Auth->user('id');    
       if ( $this->Quiz->save($this->request->data)):
       	   $this->msgFlash(__('Data saved'), '/admin/tests/listing');
       endif;
   elseif(intval($quiz_id) and $quiz_id != Null): # populate form 
	   $this->request->data = $this->Quiz->read(Null, $quiz_id);
   endif;
 }
 
/**
 * See student answers in admin area
 * @access public
 * @param integer $user_id
 * @param integer $quiz_id
 * @param integer $vclassroom_id
 * @return void
 */ 
 public function admin_see($user_id, $quiz_id, $vclassroom_id)
 { 
   $this->layout = 'popup';
   $this->set('data', $this->Quiz->getQuiz($user_id, $quiz_id, $vclassroom_id));
 }
 
/**
 * Change status published/draft
 * @access public
 * @param integer $quiz_id
 * @param integer $status
 * @return void
 */
 public function admin_change($quiz_id, $status)
 { 
   $news_status    = ($status == 0 ) ? 1 : 0;
   $this->Quiz->id = $quiz_id;
   if ($this->Quiz->saveField('status', $news_status)):
       $this->msgFlash(__('Status modified'), $this->referer());
   endif;
 }

/**
 * admin_questions
 * @access public
 * @param integer $quiz_id
 */ 
 public function admin_questions($quiz_id)
 {
  $this->layout    = 'admin';
  $params = array('conditions' => array('Quiz.user_id'=>$this->Auth->user('id'), 'Quiz.id'=>$quiz_id),
                  'fields'     => array('Quiz.id', 'Quiz.user_id', 'Quiz.title', 'Quiz.description'),
                  'recursive'  => 2
                  );
  $this->Quiz->unbindModel(array('belongsTo'=>array('User')));

  $data = $this->Quiz->find('first', $params);

  if ( isset( $this->params['requested']) ):  # called from QuestionController.php
      return $data;
  endif;

  $this->set('data', $data);
 }

/**
 * points change to correct or incorrect in open question
 * @access public
 * @param integer $result_id 
 * @param integer $sense correct or incorrect
 */
 public function admin_points($result_id, $sense)
 {
  $this->layout    = 'ajax';
  $this->Quiz->Result->id = $result_id;
  $new_correct     = $sense == 0 ? 1 : 0;
  $this->Quiz->Result->saveField('correct', $new_correct);
  $this->set('correct',  $new_correct);
  $this->render('admin_points', 'ajax');
 }

/**
 * delete Quiz 
 * @access public
 * @param integer $quiz_id
 * @return void 
 */
 public function admin_delete($quiz_id) 
 {
  if ( $this->Quiz->delete($quiz_id) ):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/tests/listing'); 
 }

/**
 * edit linked Kandie
 * @access public
 */
 public function admin_ekandie() 
 {
   $this->layout = 'ajax';
   $this->request->data = $this->Quiz->QuizVclassroom->read(Null, $this->request->data['QuizVclassroom']['id']);
   $this->render('admin_ekandie', 'ajax');
 }
/**
 * update linked Kandie
 * @access public
 */
 public function admin_update() 
 {
   $this->layout = 'ajax';
   if ( $this->Quiz->QuizVclassroom->save($this->request->data) ):
       $this->msgFlash(__('Data updated'), '/admin/vclassrooms/dide/'.$this->request->data['QuizVclassroom']['vclassroom_id']);
   endif;
 }

}

# ? > EOF
