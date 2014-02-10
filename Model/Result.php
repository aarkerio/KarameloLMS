<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software(c)
*  @version 0.7
*  @package tests
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/Result.php

class Result extends AppModel {

 public $name      = 'Result';

/**
 * Containable behaviour enabled
 * @access public
 * @link http://book.cakephp.org/view/474/Containable
 */
 public $actsAs   = array('Containable');
    
 public $belongsTo  = array(
             'User' => array(
                             'className'    => 'User',
                             'foreignKey'   => 'user_id',
                             'fields'       => 'id, username'
                               ), 
             'Test' => array(
                             'className'    => 'Test',    
                             'foreignKey'   => 'test_id',
                             'fields'       => 'id, title'
                              )
             );
/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var    array
 */
 public $validate = array(
          'question_id' => array(
                      'rule'       => 'numeric',
                      'allowEmpty' => False,         
                      'required'   => True                                                                                           
		           ),                          
		  'vclassroom_id' => array(
                      'rule'       => 'numeric',  
                      'allowEmpty' => False,
                      'on'         => 'create',
                      'required'   => True
                         ),                                                                                             
          'test_id' => array(
                      'rule'       => 'numeric',                       
		              'allowEmpty' => False,
                      'on'         => 'create',  
                      'required'   => True
		      ),
          'user_id' => array(
                      'rule'       => 'numeric',
                      'on'         => 'create',   
                      'allowEmpty' => False,  
                      'required'   => True
                        )    
  );


}

# ? > EOF
