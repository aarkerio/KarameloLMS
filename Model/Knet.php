<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software(c)
*  @version 0.7
*  @package kandies
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: APP/models/knet.php

class Knet extends AppModel {

/**
 *  belongsTo
 *  @acces public
 *  @var array
 */
 public $belongsTo = array('User' =>
			    array('className'  => 'User',
                      'conditions' => '',
				      'order'      => '',
                      'fields'     => 'id, username, avatar',
                       'foreignKey' => 'user_id'
				  ),
                    'Subject' =>
			    array('className'  => 'Subject',
				      'conditions' => '',
				      'order'      => '',
                      'fields'     => 'title',
                      'foreignKey' => 'subject_id'
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
  'body' => array(
                   'rule'       => array('minLength', 8),
                   'message'    => 'Lesson must be at least 8 characters long',
		           'allowEmpty' => False,
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
