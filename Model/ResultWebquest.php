<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package webquests
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/ResultWebquest.php

class ResultWebquest extends AppModel {

/**
 * CakePHP Class Name
 */
  public $name       = 'ResultWebquest';
   

/**
 *  CakePHP belongsTo
 *  @access public    
 *  @var array
 */   
  public $belongsTo  = array(
             'User' => array(
                             'className'    => 'User',
                             'foreignKey'   => 'user_id',
                             'fields'       => 'id, username'
                               ), 
             'Webquest' => array(
                             'className'    => 'Webquest',  
                             'foreignKey'   => 'webquest_id'
                              )
             );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
  public $validate = array(
		   'answer'      => array(
		                           'rule'       => array('minLength', 4),
		                           'message'    => 'Answer must be at least four characters long',
		                           'allowEmpty' => False,
		                           'required'   => True
			                     ),
		  'points'       => array(
                                   'rule'       => 'numeric',
                                   'allowEmpty' => False,
                                   'required'   => True                                                                                           
			                      ),                          
		  'webquest_id'   => array(
                                   'rule'       => 'numeric',  
                                   'allowEmpty' => False,
                                   'required'   => True
                                  ),                                                                                             
          'vclassroom_id' => array(
                                   'rule'       => 'numeric',                       
		                           'allowEmpty' => False,  
                                   'required'   => True
		                           ),
          'user_id'       => array(
                                   'rule'       => 'numeric',
                                   'on'         => 'create',   # but no on update
		                           'allowEmpty' => False,  
                                   'required'   => True
                            )
  );
}

# ? > EOF
