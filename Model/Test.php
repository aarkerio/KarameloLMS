<?php
/**
 *  Karamelo e-Learning Platform
 *  GNU Affero General Public License V3
 *  @copyright Copyright 2006-2012, Chipotle Software(c)
 *  @version 0.7
 *  @package tests
 *  @license http://www.gnu.org/licenses/agpl.html
 */
# file: app/Model/Test.php

class Test extends AppModel {

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
                   'TestVclassroom' =>
					   array('className'             => 'TestVclassroom',   # link classroom with eKandie
						     'foreignKey'            => 'test_id',
                            ),
                   'Question' =>
		               array('className'     => 'Question',                 # test questions
			                 'conditions'    => Null,
			                 'order'         => 'Question.order ASC',
			                 'limit'         => Null,
			                 'foreignKey'    => 'test_id',
			                 'dependent'     => True,
			                 'exclusive'     => False,
                             'finderQuery'   => Null
				            ),
                   'Result' =>                                         
		               array('className'     => 'Result',                    # Save stunde result after resolved
			                 'conditions'    => Null,
			                 'order'         => Null,
			                 'limit'         => Null,
			                 'foreignKey'    => 'test_id',
			                 'dependent'     => True,
			                 'exclusive'     => False,
                             'finderQuery'   => Null
                             ),
                    'TestsStudent' =>
                   array('className'     => 'TestsStudent',                  # Test answered by student, graded and sent by teacher
			                  'conditions'    => Null,
			                  'order'         => Null,
			                  'limit'         => Null,
			                  'foreignKey'    => 'test_id',
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
 *  getPoints  returns points from already answered test by student
 *  @access public
 *  @param integer $test_id
 *  @param integer $user_id
 *  @param integer $vclassroom_id
 *  @return mixed  return integer points or False if student have not yet answered the test 
 */
 public function getPoints($test_id, $user_id, $vclassroom_id)
 {
  $points  = (int) 0;
  $params  = array('conditions' => array('Result.test_id'=>$test_id, 'Result.user_id'=>$user_id, 'Result.vclassroom_id'=>$vclassroom_id), 
                   'contain'    => False);
  $answers = $this->Result->find('all', $params);  # get the answers gived by student
  
  if ( count($answers) < 1 ): # test not answer yet
      return False;
  endif;

  foreach($answers as $a):
      $params   = array('conditions' => array('Question.id'=>$a['Result']['question_id']), 
                        'fields'     => array('Question.worth', 'Question.type'));
      $question = $this->Question->find('first', $params); # how many points question have?
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
 *  Link test to vClassroom
 *  @access public
 *  @param integer $test_id
 *  @param integer $user_id
 *  @return array 
 */
 public function linkClassroom($test_id, $user_id)
 {
    $params = array('conditions' => array('Test.status'=>1, 'Test.user_id'=>$user_id, 'Test.id'=>$test_id));
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
   $params = array('conditions' => array('Test.knet' => 1),
                   'fields     '=> array('Test.title', 'Test.id'),
                   'contain'    => array('User'=>array('conditions'=>array('User.active'=>1),'fields'=>array('User.username')))
                  );
   return $this->find('all', $params);
 }

/**
 *  Check if student already answered the test
 *  @access public
 *  @param integer test_id 
 *  @param integer user_id      
 *  @param integer vclassroom_id
 *  @return boolean
 */
 public function chk($test_id, $user_id, $vclassroom_id)
 {
    $conditions =  array('Result.user_id'=>$user_id, 'Result.test_id'=>$test_id, 'Result.vclassroom_id'=>$vclassroom_id);
    $data       =  $this->Result->field('Result.id', $conditions);
    
    if ($data == False ):
        return False;   
    else:
        return True;
    endif;
 }

/**
 *  getTest return test full details
 *  @access public
 *  @param int user_id
 *  @return array
 */
 public function getTest($user_id, $test_id, $vclassroom_id)
 {
  $this->Result->bindModel(array('belongsTo'=>array('Question', 'Answer')));
  $params = array('conditions' => array('Result.user_id'=>$user_id, 'Result.test_id'=>$test_id, 'Result.vclassroom_id'=>$vclassroom_id),
                  'order'      => 'Result.question_id',
                  'fields'     => array('Result.id', 'Result.created','Result.question_id','Result.answer', 'Result.correct', 'Test.title', 
                                        'Question.question', 'Question.worth', 'Question.type', 'Answer.answer', 'Answer.correct')
                 );
  return $this->Result->find('all', $params);
 }


/**
 * Get Test(s) answered by students,  used in action /admin/tests/record/
 * @return array
 * @access public
 * @param integer $vclassroom_id
 */
 public function testsAnswered($vclassroom_id)
 {
  # get all tests in this vClassroom
  $tests  =  $this->TestVclassroom->find('all', array('conditions'=> array('TestVclassroom.vclassroom_id'=>$vclassroom_id),
                                                       'fields'    => array('TestVclassroom.test_id')
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
  foreach($tests as $t):
      $test_id  = $t['TestVclassroom']['test_id'];
      foreach($users as $u):
          $user_id = $u['UserVclassroom']['user_id'];
          $chk = $this->chk($test_id, $user_id, $vclassroom_id);
          if ( $chk ):  # if true, student already answered the test
              $i++;
              $row['test_id']  = $test_id;
              $row['user_id']  = $user_id;
              $row['points']   = $this->getPoints($test_id, $user_id, $vclassroom_id);
              $row['title']    = $this->field('title', array('id'=>$test_id));
              $row['username'] = $this->User->field('username', array('id'=>$user_id));
              $row['checked']  = $this->TestsStudent->field('checked', array('user_id'=>$user_id, 'test_id'=>$test_id, 'vclassroom_id'=>$vclassroom_id));
              $row['created']  = $this->Result->field('created',  array('Result.user_id'=>$user_id, 'Result.test_id'=>$test_id, 'Result.vclassroom_id'=>$vclassroom_id));
              $data[$i]        = $row; 
          endif;
      endforeach;
  endforeach;

  #die(debug($data));
  return $data;
 }

/**
 * Return tests owned by one teacher and not already linked to specific vclassroom
 * @return array
 * @access public
 * @param integer $user_id
 * @param integer $vclassroom_id
 */
 public function getTests($user_id, $vclassroom_id)
 {
   $params = array('conditions'   => array('Test.user_id'=>$user_id),
                   'fields'       => array('Test.id', 'Test.title'),
                   'order'        =>'Test.title');
   $this->contain();
   $tests        = $this->find('all', $params);
   foreach ($tests as $k =>$t):
       $params = array('conditions' => array('TestVclassroom.test_id' => $t['Test']['id'], 'TestVclassroom.vclassroom_id' => $vclassroom_id),
                       'fields'     => array('TestVclassroom.test_id'));
       $assigned = $this->TestVclassroom->find('first', $params);
       if ( $assigned ): # test is already assigned to this Vclassroom, so unset
           unset($tests[$k]);
       endif; 
   endforeach;

  return $tests;
 }

/**
 * check Wrong/Corect answers given by student
 * @access public
 * @param integer $test_id
 * @param array $answers
 * @return array
 */ 
 public function chkAnswers($answers, $test_id)
 {
    $this->Test->unbindModel(array('belongsTo'=>array('User'))); #just get few data
    
    $result = 0;
    
    foreach($questions as $q_id => $a_id):  # question id and answer id
        $correct_answer = $this->Test->Question->Answer->field('Answer.correct', array('Answer.id'=>$a_id));   # answer was correct?
         
        if ($correct_answer == 1):
	        $worth   = $this->Test->Question->field('Question.worth', array('Question.id'=>$q_id));         # how many points
	        $result += $worth;
        endif;
    endforeach;
    #exit('Result was:' . $result)e
    return $result; 
  }

/**
  *  Max points in a test
  *  @access public
  *  @return void
  *  @param integer $test_id
  */
 public function maxPoints($test_id)
 {
  $maxpoints = (int) 0;
  $params = array('conditions' => array('Test.id'=>$test_id), 
                  'contain'    => array('Question'=>array('fields'=>array('worth', 'test_id')))
                  );
  $data = $this->find('first',$params);
  $tax  = 0.16;
  $total = 0.00;
  $i = 0;
  $callback = function ($question) use (&$i, &$maxpoints)
              {
                #echo __CLASS__ . ' '. debug($question) .'<br />';
                 
                $maxpoints +=  $question['worth'];
              };

  array_walk($data['Question'], $callback);
 
  return $maxpoints;
 }
 
}

# ? > EOF
