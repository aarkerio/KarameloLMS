<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package tests
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: app/Model/Answer.php

class Answer extends AppModel {

/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array
 */   
 public $belongsTo = array('Question' =>
		                            array('className'  => 'Question',
		                                  'conditions' => '',
       			                          'order'      => '',
                                          'foreignKey' => 'question_id'
                                          )
                          );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
  'answer' => array(
                    'rule'       => array('minLength', 2),
                    'message'    => 'Answer must be at least two characters long',
		            'allowEmpty' => False,
                    'required'   => True 
		    ),
  'question_id' => array(
		             'rule'       => 'numeric',
                     'on'         => 'create',  # but not on update
                     'allowEmpty' => False,
                     'required'   => True 
		     ),
  'user_id' => array(
		             'rule'       => 'numeric',
                     'on'         => 'create',  # but not on update
                     'allowEmpty' => False,
                     'required'   => True 
		     )
   );

/**
 * Check Wrong/Correct answer given by student
 * @access public
 * @param integer $test_id
 * @param array $answers
 * @return array
 */ 
 public function chkAnswer($answer_id)
 {
  
  $correctWrong = $this->field('Answer.correct', array('Answer.id'=>$answer_id));   # answer was correct?       

  return $correctWrong; 
 }
}

# ? > EOF
