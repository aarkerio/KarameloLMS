<?php
/*
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright 2006-2012, Chipotle Software(C)
*  @version 0.7
*  @package tests
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/Inquiry.php

class Inquiry extends AppModel {

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
 public $belongsTo = array('Quiz' =>
                            array('className'  => 'Quiz',
                                  'conditions' => '',
                                  'foreignKey' => 'quiz_id'
                            )
                          );
 
/**
 * HasMany relationship
 * @access public
 * @var array
 */
  public $hasMany = array('Resolution' =>
                        array('className'     =>'Resolution',
                              'conditions'    => Null,
	                          'foreignKey'    => 'inquiry_id',
	                          'dependent'     => True,
	                          'exclusive'     => False,
                              'order'         => 'Resolution.id ASC'
	                        )
		         );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
  'inquiry' => array(
                    'rule'       => array('minLength', 4),
                    'message'    => 'Field must be at least four characters long',
                    'allowEmpty' => False,
                    'required'   => True 
		             ),
  'quiz_id' => array(
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
                     )
          );
}

# ? > EOF
