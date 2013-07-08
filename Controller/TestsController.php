<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package tests
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: app/Controller/TestsController.php

/**
 *  Include files
 */
App::uses('Sanitize', 'Utility');
  
class TestsController extends AppController {

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
                          'order' => array('Test.title' => 'ASC')
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
  $params = array('conditions' => array('Test.user_id'=> $this->Edublog->userId, 'Test.status'=>1));
  $this->set('data', $this->Test->find('all', $params));
 }
 
/**
 *  Display test and it questions
 *  @access public
 *  @param string  $username
 *  @param integer $test_id
 *  @param integer $vclassroom_id
 *  @return void 
 */ 
 public function view($username, $test_id, $vclassroom_id)
 {
  $this->Edublog->setUserId($username); # blogger elements
  $this->Edublog->checkPermissions($vclassroom_id, $test_id, 'Test', $this->Auth->user('id')); # set permissions
  $conditions = array('Test.id'=>$test_id);
  if ( $this->Edublog->userId != $this->Auth->user('id')):  # teacher can view test even if status = 0
      $conditions['Test.status'] = 1;
  endif;
  # get questions 
  $data = $this->Test->find('first', array('conditions'=>$conditions, 
                                           'contain' => array('Question'=>array('Answer')))
                           );
  if ( !$data ):
      $this->msgFlash(__('Resource is not public'), '/blog/'.$username);
      return False;
  endif;

  $params = array('conditions'=> array('TestVclassroom.test_id'=>$test_id, 'TestVclassroom.vclassroom_id'=>$vclassroom_id),
                  'fields'    => array('TestVclassroom.vclassroom_id',  'TestVclassroom.fdate',  'TestVclassroom.sdate'),'recursive'=>0);
  $data['t']         = $this->Test->TestVclassroom->find('first', $params); 
  $data['maxpoints'] = $this->Test->maxPoints($test_id);
 
  $this->set('data',$data);
  if ( $data['Test']['type'] == 1):
      $this->render('view');
  else:
      $this->render('quiz');
  endif;
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
  $this->Edublog->setUserId($this->request->data['Test']['blogger']); # blogger elements
  $this->Edublog->checkPermissions($this->request->data['Test']['vclassroom_id'], $this->request->data['Test']['test_id'], 'Test', $this->Auth->user('id')); # set permissions
  if ( $this->viewVars['permissions']['belongs'] != 1 or $this->viewVars['permissions']['already'] == 1  or $this->viewVars['permissions']['chkdate'] != 1 ):
      $this->redirect('/');
      return False;
  endif;
  $conditions = array('Test.id'=> $this->request->data['Test']['test_id']);
  if ( $this->Edublog->userId != $this->Auth->user('id')): # if teacher, show test even if is in draft status 
      $conditions['Test.status'] = 1;
  endif;
  $data = $this->Test->find('all', array('conditions'=>$conditions, 'contain' => array('Question'=>array('Answer'))));
  if ( !$data ):
      $this->msgFlash(__('Resource is not public'), '/blog/'.$username);
      return False;
  endif;
  $params = array('conditions'=>array('TestVclassroom.test_id'=> $this->request->data['Test']['test_id'], 'TestVclassroom.vclassroom_id'=> $this->request->data['Test']['vclassroom_id']),
           'fields' =>array('TestVclassroom.vclassroom_id','TestVclassroom.fdate','TestVclassroom.sdate'),'recursive'=>0);
  $data['t'] = $this->Test->TestVclassroom->find('first', $params);
  $this->set('data',$data);
  $this->set('answers',$this->request->data['Test']);
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
  if ( !$this->Auth->user() or !isset($this->request->data['Test'])):
      $this->redirect('/');
      return False;
  endif; 

  try {
    #die(debug($this->request->data));
   
    $this->Edublog->setUserId($this->request->data['Test']['blogger']); # blogger elements
    $this->Edublog->checkPermissions($this->request->data['Test']['vclassroom_id'], $this->request->data['Test']['test_id'], 'Test', $this->Auth->user('id')); # set permissions
    if ( $this->viewVars['permissions']['belongs'] != 1 or $this->viewVars['permissions']['already'] == 1  or $this->viewVars['permissions']['chkdate'] != 1 ):
        $this->redirect('/');
        return False;
    endif;

    # Get all questions and answers if option multiple
    $params = array(
                    'conditions'=> array('Question.test_id'=>$this->request->data['Test']['test_id']), 
                    'fields'    => array('Test.title', 'Question.id',  'Question.type'),
                    'contain'   => array('Test', 'Answer')
                   );
    $tests = $this->Test->Question->find('all',$params); #get all the questions
    #debug($this->request->data['Test']);
    #die(debug($tests));
    # start building data for save in Result model
    $points  = (int) 0; # points sum only in multiple option question
    $this->request->data['Result']['user_id']        = (int) $this->Auth->user('id');
    $this->request->data['Result']['test_id']        = (int) $this->request->data['Test']['test_id']; 
    $this->request->data['Result']['vclassroom_id']  = (int) $this->request->data['Test']['vclassroom_id'];
    $open_question = (bool) False;    # False by default
    #die(debug($tests));
    foreach($this->request->data['Test'] as $k => $t): # doing loop to answers
        if ( is_numeric($k) ):  # is numeric means this is an student answer, multiple option or openquestion, id est: $k = Question.id
            $this->request->data['Result']['question_id']  = (int) $k;
            # in this point I need to know if question is type 1 or 2
            $type = (int) $this->Test->Question->field('type', array('id'=>$k));
            if ( $type == 1 ): # multiple choice
                $res = $this->Test->Question->Answer->find('first', array('conditions' => array('Answer.id'=>$t)));
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
            $this->Test->Result->id = False;
            $this->Test->Result->create();
            #debug($this->request->data['Result']);
            if ( !$this->Test->Result->save($this->request->data) ):
                die(debug($this->Test->Result->validationErrors));
            endif;
        endif;
    endforeach;

    # After save student answers I create a new TestsStudent row, in this way the teacher can know what examn has been scored
    $this->request->data['TestsStudent']['user_id']        = (int) $this->Auth->user('id');
    $this->request->data['TestsStudent']['test_id']        = (int) $this->request->data['Test']['test_id']; 
    $this->request->data['TestsStudent']['vclassroom_id']  = (int) $this->request->data['Test']['vclassroom_id'];
    $this->Test->TestsStudent->save($this->request->data);
    # TestsStudent stuff ENDS

    # Send email teacher(s) section STARTS
    $teachers = $this->Test->User->getTeachers($this->request->data['Test']['vclassroom_id']);
    # die(debug($teachers));
    $title = $this->Test->field('Test.title', array('Test.id'=>$this->request->data['Test']['test_id']));
    # Send email to teacher
    $sendArray = array(
             'subject' => __('Quiz Test answered'),
             'message' => __('Student').' '.$this->Auth->user('username').' '.__('has answered the kandie'). ': '.$title,
                    );
    $this->Mailer->sendMany($sendArray, $teachers);
    # Send email teacher(s) section  ENDS
    $maxpoints  = (int) $this->request->data['Test']['maxpoints'];
    $percentage = number_format( (($points / $maxpoints)*100), 2, '.', '');
    $this->request->data['Test']['results']     = $points;         
    $this->request->data['Test']['percentage']  = $percentage;     
    $this->set('data', $this->request->data['Test']);
    
    $params = array(
                    'conditions' => array('Question.test_id'=>$this->request->data['Result']['test_id']),
                    'fields'     => array('Question.question', 'Question.hint', 'Question.explanation', 'Question.type')
                   );
    $this->Test->Question->contain();
    $this->set('open_question', $open_question);
    $this->set('answers', $this->Test->Question->find('all', $params));
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
   return $this->Test->getTests($this->Auth->user('id'), $vclassroom_id);
 }

/** 
 * Display Quiz tests
 * @access public
 * @return void
 */ 
 public function admin_listing()
 {   
   $this->layout    = 'admin';
  
   $this->paginate = array('conditions' => array('Test.user_id'=>$this->Auth->user('id')),
                           'fields'     => array('Test.id', 'Test.user_id', 'Test.title', 'Test.description', 'Test.status', 'Test.type'),
                           'order'      => 'Test.title DESC',
                           'contain'    => False);
   $data = $this->paginate('Test');
   $this->set(compact('data'));
 }


/**
 *  Display preview test and it questions
 *  @access public
 *  @param integer $test_id
 *  @return void 
 */ 
 public function admin_view($test_id)
 {
 try {
     $this->layout    = 'popup';   
     $params = array('conditions' => array('Test.id'=>$test_id, 'Test.user_id'=>$this->Auth->user('id')), 
                     'contain'    => array('Question'=>array('Answer'))
                    );
     # get questions 
     $data = $this->Test->find('first', $params);
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
   $data = $this->Test->testsAnswered($vclassroom_id);
   $this->set('vclassroom_id', $vclassroom_id);
   #die(debug($data));
   $this->set(compact('data'));
 }


/**
 * Test evaluated
 * @access public
 * @return void
 * @param integer $report_id
 */
 public function admin_share($report_id)
 {
   $data = $this->Test->getData($report_id); # Model call
   #die(debug($data));
   
   $this->Test->id  = (int) $report_id; 
      
   if ($this->Test->saveField('checked', 1)):
       # Email STARTS
       $email   = (string) $data['User']['email'];
       $subject = (string) $data['Vclassroom']['name'];
       $message = __('The teacher has called the file you sent'). ': '. $data['Test']['description']."\n";
       $this->Mailer->set('url', '/vclassrooms/show/'. $data['teacher_username'].'/'.$data['Test']['vclassroom_id']);
       $this->Mailer->set('message', $message);
       $this->Mailer->template = 'default';
       $this->Mailer->sendAs   = 'html'; 
       $this->Mailer->subject  = $subject;
       $this->Mailer->send($email);
       # Email ENDS   
       $this->msgFlash(__('Test graded'), $this->referer());
   endif;
  }


/**
 * Send result to 
 * @access public
 * @return void
 * @param integer $report_id
 */
 public function admin_compose($test_id, $user_id, $vclassroom_id)
 {
   $params = array('conditions' => array('Test.id'=>$test_id),
                   'fields'     => array('Test.title', 'Test.user_id'),
                   'contain'    => array('User'=>array('fields'=>array('User.username'))));

   $data   = $this->Test->find('first',$params);
      
   #die(debug($data));
   $points = $this->Test->getPoints($test_id, $user_id, $vclassroom_id);

   # Email STARTS
   $email  = $this->Test->User->field('email',array('User.id'=>$user_id));
   $message = 'In exam '.$data['Test']['title'].' '.__('you test score is').' ' .$points;
   $this->Mailer->set('url', '/vclassrooms/show/'. $data['User']['username'].'/'.$vclassroom_id);
   $this->Mailer->set('message', $message);
   $this->Mailer->subject  =  __('Your exam results');
   $this->Mailer->template = 'default';
   $this->Mailer->sendAs   = 'html'; 
   $this->Mailer->send($email);
   # Email ENDS
   
   $testsStudentId = $this->Test->TestsStudent->field('id',array('TestsStudent.user_id'=>$user_id,'TestsStudent.test_id'=>$test_id,'TestsStudent.vclassroom_id'=>$vclassroom_id));
   
   $this->Test->TestsStudent->id = (int) $testsStudentId;
   $this->Test->TestsStudent->saveField('checked', 1);
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
  
  if ( !empty($this->request->data['TestVclassroom']) ):
      $this->request->data['TestVclassroom'] = Sanitize::clean($this->request->data['TestVclassroom']);
      if ( $this->Test->TestVclassroom->save($this->request->data['TestVclassroom'])):
          if ( isset($this->request->data['TestVclassroom']['popup']) ):   
              $url = '/admin/vclassrooms/dide/'.$this->request->data['TestVclassroom']['vclassroom_id'];
          else:
              $url = '/admin/tests/vclassrooms/'.$this->request->data['TestVclassroom']['test_id'];
          endif;
          $this->msgFlash(__('Test assigned'),$url);
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

  if ( !empty($this->request->data['TestVclassroom']) ):
      $this->request->data['TestVclassroom'] = Sanitize::clean($this->request->data['TestVclassroom']);

      if ( $this->Test->TestVclassroom->delete($this->request->data['TestVclassroom']['id'])):
           if (isset($this->request->data['TestVclassroom']['popup'])):
               $return =  '/admin/vclassrooms/dide/'.$this->request->data['TestVclassroom']['vclassroom_id'];
           else:
               $return =  '/admin/tests/vclassrooms/'.$this->request->data['TestVclassroom']['test_id'];               
           endif;
           $this->msgFlash(__('Kandie unlinked'), $return);
      endif;
  endif;
 }
 
/**
 * Edit Quizz Test
 * @access public
 * @param mixed $test_id  integer or boolean
 * @return void
 */ 
 public function admin_edit($test_id=Null) 
 {
   $this->layout    = 'admin';
   
   if (!empty($this->request->data['Test'])):   # insert or update
       $this->request->data['Test']['user_id'] = (int) $this->Auth->user('id');    
       if ( $this->Test->save($this->request->data)):
       	   $this->msgFlash(__('Data saved'), '/admin/tests/listing');
       endif;
   elseif(intval($test_id) and $test_id != Null): # populate form 
	   $this->request->data = $this->Test->read(Null, $test_id);
   endif;
 }
 
/**
 * See student answers in admin area
 * @access public
 * @param integer $user_id
 * @param integer $test_id
 * @param integer $vclassroom_id
 * @return void
 */ 
 public function admin_see($user_id, $test_id, $vclassroom_id)
 { 
   $this->layout = 'popup';
   $this->set('data', $this->Test->getTest($user_id, $test_id, $vclassroom_id));
 }
 
/**
 * Change status published/draft
 * @access public
 * @param integer $test_id
 * @param integer $status
 * @return void
 */
 public function admin_change($test_id, $status, $type=False)
 { 
   $field = $type ? 'type' :  'status';
   $news_status    = ($status == 0 ) ? 1 : 0;
   $this->Test->id = $test_id;
   if ($this->Test->saveField($field, $news_status)):
       $this->msgFlash(__('Status modified'), '/admin/tests/listing');
   endif;
 }

/**
 * admin_questions
 * @access public
 * @param integer $test_id
 */ 
 public function admin_questions($test_id)
 {
  $this->layout    = 'admin';
  $params = array('conditions' => array('Test.user_id'=>$this->Auth->user('id'), 'Test.id'=>$test_id),
                  'fields'     => array('Test.id', 'Test.user_id', 'Test.title', 'Test.description'),
                  'recursive'  => 2
                  );
  $this->Test->unbindModel(array('belongsTo'=>array('User')));

  $data = $this->Test->find('first', $params);

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
  $this->Test->Result->id = $result_id;
  $new_correct     = $sense == 0 ? 1 : 0;
  $this->Test->Result->saveField('correct', $new_correct);
  $this->set('correct',  $new_correct);
  $this->render('admin_points', 'ajax');
 }

/**
 * delete Test 
 * @access public
 * @param integer $test_id
 * @return void 
 */
 public function admin_delete($test_id) 
 {
  if ( $this->Test->delete($test_id) ):
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
   $this->request->data = $this->Test->TestVclassroom->read(Null, $this->request->data['TestVclassroom']['id']);
   $this->render('admin_ekandie', 'ajax');
 }
/**
 * update linked Kandie
 * @access public
 */
 public function admin_update() 
 {
   $this->layout = 'ajax';
   if ( $this->Test->TestVclassroom->save($this->request->data) ):
       $this->msgFlash(__('Data updated'), '/admin/vclassrooms/dide/'.$this->request->data['TestVclassroom']['vclassroom_id']);
   endif;
 }

/**
 * Delete answer in result Model 
 * @access public
 * @param integer $test_id
 * @return void 
 */
 public function admin_delactivity($test_id, $user_id, $vclassroom_id) 
 {
  $conditions = array('Result.test_id'=>$test_id, 'Result.user_id'=>$user_id, 'Result.vclassroom_id'=>$vclassroom_id);
  $TestsStudentId = $this->Test->TestsStudent->field('id', array('user_id'=>$user_id, 'test_id' => $test_id, 'vclassroom_id' => $vclassroom_id));
  if ( $this->Test->Result->deleteAll($conditions, True)):
      $this->Test->TestsStudent->delete($TestsStudentId);
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, $this->referer()); 
 }
}

# ? > EOF
