<?php
/**
 *  Karamelo e-Learning Platform
 *  GNU Affero General Public License V3
 *  @copyright Copyright 2006-2012, Chipotle Software(c)
 *  @version 0.7
 *  @package tests
 *  @license http://www.gnu.org/licenses/agpl.html
 */
# file: app/Model/Quiz.php

class Quiz extends AppModel {

/**
 * Containable behaviour enabled
 * @access public
 * @var array
 */
 public $actsAs   = array('Containable');

/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array
 */
 public $belongsTo = array('User' =>
			 array('className'  => 'User',
			       'conditions' => '',
			       'order'      => '',
                               'foreignKey' => 'user_id',
                               'fields'     => 'id, username'
			       )
			 );
   
/**
 *  CakePHP hasMany relationship
 *  @access public
 *  @var array
 */
  public $hasMany = array(
                   'QuizVclassroom' =>
					   array('className'             => 'QuizVclassroom',   # link classroom with eKandie
						     'foreignKey'            => 'quiz_id',
                            ),
                   'Inquiry' =>
		               array('className'     => 'Inquiry',             # questions in the quiz test
			                 'conditions'    => Null,
			                 'order'         => 'Inquiry.id ASC',
			                 'limit'         => Null,
			                 'foreignKey'    => 'quiz_id',
			                 'dependent'     => True,
			                 'exclusive'     => False,
                             'finderQuery'   => Null
				            ),
                   'QuizResults' =>
		               array('className'     => 'QuizResults',     # save student results
			                 'conditions'    => Null,
			                 'order'         => Null,
			                 'limit'         => Null,
			                 'foreignKey'    => 'quiz_id',
			                 'dependent'     => True,
			                 'exclusive'     => False,
                             'finderQuery'   => Null
                             ),
                    'QuizzesStudent' =>
		                array('className'     => 'QuizzesStudent',     # Test answered by student, graded and sent by teacher
			                  'conditions'    => Null,
			                  'order'         => Null,
			                  'limit'         => Null,
			                  'foreignKey'    => 'quiz_id',
                             )
		       );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
		      'title' => array(
			              'rule'      => array('minLength', 4),
                          'message'   => 'Minimum 4 characters long', 
				          'required'  => True 
				       ),
		      'description' => array(
			              'rule'      => array('minLength', 4),
                      	  'message'   => 'Minimum 4 characters long',
					      'required'  => True 
					 ),
              'user_id' => array(
		                  'rule'       => 'numeric',
                      	  'allowEmpty' => False,
                          'on'         => 'create', # but not on update
                          'required'   => True 
		                  )		
		        );
/**
 *  getPoints  returns points from already answered quiz by student
 *  @access public
 *  @param integer $quiz_id
 *  @param integer $user_id
 *  @param integer $vclassroom_id
 *  @return mixed   return integer points or False if student have not yet answered the quiz 
 */
 public function getPoints($quiz_id, $user_id, $vclassroom_id)
 {
  $points  = (int) 0;
  $params  = array('conditions' => array('Result.quiz_id'=>$quiz_id, 'Result.user_id'=>$user_id, 'Result.vclassroom_id'=>$vclassroom_id), 'contain'=>False);
  $answers = $this->Result->find('all', $params);  # get the answers gived by student
  
  if ( count($answers) < 1 ): # quiz not answer yet
      return False;
  endif;

  foreach($answers as $a):
      $params   = array('conditions' => array('Question.id'=>$a['Result']['question_id']), 
                        'fields'     => array('Question.worth', 'Question.type'));
      $question = $this->Inquiry->find('first', $params); # how many points question have?
      #die(debug( $question ));
      if ( $question['Question']['type'] == 1 ):  # mutiple choice 
          if ( count($question['Answer']) > 0 ):
              foreach($question['Answer'] as $qa):
                  if ($qa['id'] == $a['Result']['answer_id'] && $qa['question_id'] == $a['Result']['question_id'] && $qa['correct'] == 1):
                      $points += (int) $question['Question']['worth'];  
	              endif;
              endforeach;
          endif;
      else:                                       # open question
          if ( $a['Result']['correct'] == 1 ):
              $points += (int) $question['Question']['worth'];  
          endif;
      endif;
  endforeach;
  
  return $points;
 }

/**
 *  Link quiz to vClassroom
 *  @access public
 *  @param integer $quiz_id
 *  @param integer $user_id
 *  @return array 
 */
 public function linkClassroom($quiz_id, $user_id)
 {
    $params = array('conditions' => array('Quiz.status'=>1, 'Quiz.user_id'=>$user_id, 'Quiz.id'=>$quiz_id));
    $vclassrooms = array();
    $result = $this->find('first', $params);
    
    foreach ($result['Vclassroom'] as $val):
       $vclassrooms[$val['name']] = $val['id'];
    endforeach;
    
    return $vclassrooms;
 }

/**
 *  return shared Gaps
 *  @access public
 *  @return mixed array or Null
 */
 public function getKnet()
 {
   $params = array('conditions' => array('Quiz.knet' => 1),
                   'fields     '=> array('Quiz.title', 'Quiz.id'),
                   'contain'    => array('User'=>array('conditions'=>array('User.active'=>1),'fields'=>array('User.username')))
                  );
   return $this->find('all', $params);
 }

/**
 *  Check if studen already answered the quiz
 *  @access public
 *  @param integer quiz_id 
 *  @param integer user_id      
 *  @param integer vclassroom_id
 *  @return boolean
 */
 public function chk($quiz_id, $user_id, $vclassroom_id)
 {
    $conditions =  array('Result.user_id'=>$user_id, 'Result.quiz_id'=>$quiz_id, 'Result.vclassroom_id'=>$vclassroom_id);
    $data       =  $this->Result->field('Result.id', $conditions);
    
    if ($data == False ):
        return False;   
    else:
        return True;
    endif;
 }

/**
 *  getQuiz return quiz full details
 *  @access public
 *  @param int user_id
 *  @return array
 */
 public function getQuiz($user_id, $quiz_id, $vclassroom_id)
 {
  $this->Result->bindModel(array('belongsTo'=>array('Question', 'Answer')));
  $params = array('conditions' => array('Result.user_id'=>$user_id, 'Result.quiz_id'=>$quiz_id, 'Result.vclassroom_id'=>$vclassroom_id),
                  'order'      => 'Result.question_id',
                  'fields'     => array('Result.id', 'Result.created','Result.question_id','Result.answer', 'Result.correct', 'Quiz.title', 
                                        'Question.question', 'Question.worth', 'Question.type', 'Answer.answer', 'Answer.correct')
                 );
  return $this->Result->find('all', $params);
 }


/**
 * Get Quiz(s) answered by students,  used in action /admin/quizs/record/
 * @return array
 * @access public
 * @param integer $vclassroom_id
 */
 public function quizsAnswered($vclassroom_id)
 {
  # get all quizs in this vClassroom
  $quizs  =  $this->QuizVclassroom->find('all', array('conditions'=> array('QuizVclassroom.vclassroom_id'=>$vclassroom_id),
                                                       'fields'    => array('QuizVclassroom.quiz_id')
                                                       )
                                         );
  $data   = array();
  $i      = (int) 0;
  # get all users in this vClassroom
  $params = array(
                  'conditions' => array('UserVclassroom.vclassroom_id'=>$vclassroom_id, 'UserVclassroom.kind'=>0),
                  'fields'     => array('UserVclassroom.user_id')
                 );
  $users = $this->UserVclassroom->find('all', $params);
  #die(debug($users));
  # Now mix all this shit
  foreach($quizs as $t):
      $quiz_id  = $t['QuizVclassroom']['quiz_id'];
      foreach($users as $u):
          $user_id = $u['UserVclassroom']['user_id'];
          $chk = $this->chk($quiz_id, $user_id, $vclassroom_id);
          if ( $chk ):  # if true, student already answered the quiz
              $i++;
              $row['quiz_id']  = $quiz_id;
              $row['user_id']  = $user_id;
              $row['points']   = $this->getPoints($quiz_id, $user_id, $vclassroom_id);
              $row['title']    = $this->field('title', array('id'=>$quiz_id));
              $row['username'] = $this->User->field('username', array('id'=>$user_id));
              $row['checked']  = $this->QuizsStudent->field('checked', array('user_id'=>$user_id, 'quiz_id'=>$quiz_id, 'vclassroom_id'=>$vclassroom_id));
              $row['created']  = $this->Result->field('created',  array('Result.user_id'=>$user_id, 'Result.quiz_id'=>$quiz_id, 'Result.vclassroom_id'=>$vclassroom_id));
              $data[$i]        = $row; 
          endif;
      endforeach;
  endforeach;

  #die(debug($data));
  return $data;
 }

/**
 * Return quizs owned by one teacher and not already linked to specific vclassroom
 * @return array
 * @access public
 * @param integer $user_id
 * @param integer $vclassroom_id
 */
 public function getQuizs($user_id, $vclassroom_id)
 {
   $params = array('conditions'   => array('Quiz.user_id'=>$user_id),
                   'fields'       => array('Quiz.id', 'Quiz.title'),
                   'order'        =>'Quiz.title');
   $this->contain();
   $quizs        = $this->find('all', $params);
   foreach ($quizs as $k =>$t):
       $params = array('conditions' => array('QuizVclassroom.quiz_id' => $t['Quiz']['id'], 'QuizVclassroom.vclassroom_id' => $vclassroom_id),
                       'fields'     => array('QuizVclassroom.quiz_id'));
       $assigned = $this->QuizVclassroom->find('first', $params);
       if ( $assigned ): # quiz is already assigned to this Vclassroom, so unset
           unset($quizs[$k]);
       endif; 
   endforeach;

  return $quizs;
 }

/**
 * check Wrong/Corect answers given by student
 * @access public
 * @param integer $quiz_id
 * @return array
 */ 
 public function chkAnswers($answers, $quiz_id)
 {
    $this->Quiz->unbindModel(array('belongsTo'=>array('User'))); #just get few data
    
    $result = 0;
    
    foreach($questions as $q_id => $a_id):  # question id and answer id
        $correct_answer = $this->Quiz->Inquiry->Answer->field('Answer.correct', array('Answer.id'=>$a_id));   # answer was correct?
         
        if ($correct_answer == 1):
	        $worth   = $this->Quiz->Inquiry->field('Question.worth', array('Question.id'=>$q_id));         # how many points
	        $result += $worth;
        endif;
    endforeach;
    #exit('Result was:' . $result)e
    return $result; 
  }
}

# ? > EOF
