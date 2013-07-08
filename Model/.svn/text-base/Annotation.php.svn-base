<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package lessons
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /app/Model/Annotation.php

class Annotation extends AppModel{

/**
 *  Load behaviours
 *  @access public    
 *  @var array
 */ 
 public $actsAs  = array('Containable');

/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array
 */    
 public $belongsTo = array('User' =>
			    array('className'  => 'User',
				      'conditions' => '',
				      'order'      => '',
                      'fields'     => 'id, username, avatar',
                      'foreignKey' => 'user_id'
				  )
			    );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
     	'comment' => array('rule'       => array('minLength', 4),
		                   'message'    => 'Mimimum 4 characters long',
                           'allowEmpty' => False,
		                   'required'   => True 
		    
		       ),
	    'user_id' => array('rule'       => 'numeric',
		                   'allowEmpty' => False,
		                   'required'   => True 
			       ),
	    'lesson_id' => array('rule' => 'numeric',
		               'allowEmpty' => False,
		               'required'   => True 
			       )
	   );
}

# ? > EOF

