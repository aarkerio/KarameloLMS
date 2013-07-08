<?php
/*
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright 2006-2012, Chipotle Software(C)
*  @version 0.7
*  @package tests
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: app/Model/Question.php

class Question extends AppModel {

/**
 * Containable behaviour enabled
 * @access public
 * @link http://book.cakephp.org/view/474/Containable
 * @var array
 */
 public $actsAs   = array('Containable');


/**
 * belongsTo relationship
 * @access public
 * @var array
 */
 public $belongsTo = array('Test' =>
                            array('className'  => 'Test',
                                  'conditions' => '',
                                  'order'      => '',
                                  'foreignKey' => 'test_id'
                            )
                          );
 
/**
 * HasMany relationship
 * @access public
 * @var array
 */
  public $hasMany = array('Answer' =>
                        array('className'=>'Answer',
                              'conditions'    => Null,
	                          'foreignKey'    => 'question_id',
	                          'dependent'     => True,
	                          'exclusive'     => False,
                              'order'         => 'Answer.id ASC'
	                        )
		         );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
  'question' => array(
                    'rule'       => array('minLength', 4),
                    'message'    => 'Field must be at least four characters long',
                    'allowEmpty' => False,
                    'required'   => True 
		             ),
  'test_id' => array(
		             'rule'       => 'numeric',
                     'allowEmpty' => False,
                     'on'         => 'create', # but not on update
                     'required'   => True 
                     ),
  'user_id' => array(
		             'rule'       => 'numeric',
                     'allowEmpty' => False,
                     'on'         => 'create', # but not on update
                     'required'   => True 
                     ),
  'type'    => array(
		             'rule'       => 'numeric',
                     'allowEmpty' => False,
                     'on'         => 'create', # but not on update
                     'required'   => True 
		            )
          );

/**
 *  Get array index to show in the test
 *  @access public
 *  @return void
 *  @param integer $question_id
 */
 public function getNextIndex($question_id)
 {
  $data = $this->find('first', array('conditions' => array('id'=>$question_id),
                                     'fields'     => array('order', 'test_id'),
                                     'contain'    => False
                                     )); 
  $next = $this->field('Question.id',array('Question.order >'=>$data['Question']['order'],'Question.test_id'=>$data['Question']['test_id']),'Question.order ASC');
  return $next;
 }
 
}

# ? > EOF
