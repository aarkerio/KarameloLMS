<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package vclassroom
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /app/models/chat.php

class Chat extends AppModel
{

/**
 *  CakePHP Model class name
 *  @access public
 *  @var array
 */
  public $name       = 'Chat';
   
/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array
 */ 
  public $belongsTo  = array(
                             'User' => array(
                                            'className'    => 'User',
                                            'foreignKey'   => 'student_id'
                                            ),
                             'Vclassroom' => array(
                                            'className'    => 'Vclassroom',
                                            'foreignKey'   => 'vclassroom_id'
                                            )
             );
/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */  
  public $validate = array(
                           'message' => array(
                                           'rule'       => array('minLength', 1),
                                           'message'    => 'Entry must be at least 1 characters long',
                                           'allowEmpty' => False,
                                           'required'   => True 
                                          ),
                           'student_id' => array(
                                             'rule'       => 'numeric',
                                             'allowEmpty' => False,
                                             'on'         => 'create',  # but not on update
                                             'required'   => True 
                                             ),
                          'vclassroom_id' => array(
                                             'rule'       => 'numeric',
                                             'allowEmpty' => False,
                                             'on'         => 'create', # but not on update
                                             'required'   => True 
                                             )
                    
                           );
}

# ? > EOF
