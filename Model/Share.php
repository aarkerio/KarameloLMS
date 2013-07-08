<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package shares
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/Share.php

class Share extends AppModel {
 
/**
 *  CakePHP Active record relationship belongsTo
 *  @access public
 *  @var array
 */
 public $belongsTo = array('User' =>
	                              array('className'  => 'User',
	                                    'conditions' => '',
     		                            'order'      => '',
	    	                            'fields'     =>'id, username',
		                                'foreignKey'  => 'user_id'
		                                ),
		                   'Subject' =>
		                          array('className'  => 'Subject',
	                                    'conditions' => '',
		                                'order'      => Null,
			                            'foreignKey' => 'subject_id'
	                     )
                      );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
  'file' => array(
                    'rule'       => array('minLength', 4),
                    'message'    => 'File must be at least four characters long',
         		    'allowEmpty' => False,
                    'on'         => 'create',  # but not on update
                    'required'   => True 
		    ),
  'description' => array(
                    'rule'       => array('minLength', 2),
                    'message'    => 'Description must be at least 2 characters long',
		            'allowEmpty' => False,
                    'on'         => 'create',  # but not on update
                    'required'   => True 
		    ),
  'user_id' => array(
		            'rule'       => 'numeric',
                    'allowEmpty' => False,
                    'on'         => 'create',  # but not on update
                    'required'   => True 
		     )
   );
}
# ? > EOF
