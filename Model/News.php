<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package news
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: APP/Model/ews.php

class News extends AppModel {

 public $name       = 'News';

 public $actsAs     = array('Containable');

 public $belongsTo  = array(
             'User' => array(
                             'className'    => 'User',
                             'foreignKey'   => 'user_id',
                             'fields'       =>  'id, username, email'
                               ), 
             'Theme' => array(
                             'className'    => 'Theme',    
                             'foreignKey'   => 'theme_id' 
                              )
             );
    
 public $hasMany  = array(
             'Discussion' => array(
                                   'className'    => 'Discussion',
                                   'foreignKey'   => 'new_id',
                                   'conditions'   => 'Discussion.status = 1'
                                   )
                         );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
  'title' => array(
                   'rule'       => array('minLength', 4),
                   'message'    => 'Title must be at least four characters long',
                   'allowEmpty' => False,
                   'required'   => True 
		  ),
  'body'  => array(
                   'rule'       => array('minLength', 8),
                   'message'    => 'Entry must be at least 8 characters long',
		           'allowEmpty' => False,
                   'required'   => True 
		  ),
   'theme_id' => array(
		             'rule'       => 'numeric',
                     'allowEmpty' => False,
                     'required'   => True 
		     ),
  'reference' => array(
                     'rule'       => 'url',
                     'message'    => 'Do not look like a valid URL',
                     'allowEmpty' => True,
                     'required'   => False
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
