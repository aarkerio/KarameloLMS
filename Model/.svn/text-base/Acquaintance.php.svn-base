<?php
/**
*  Karamelo e-Learning Platform
*  GPLv3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package links
*  @license http://www.gnu.org/licenses/gpl-3.0.html
*/
#File: /APP/Model/Acquaintance.php

class Acquaintance extends AppModel {

/**
 *  CakePHP Model behaviour
 *  @access public
 *  @var array
 */
  public $actsAs   = array('Containable');

/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array
 */
  public $belongsTo = array(
		 'User' => array(
		                 'className'   => 'User',
                                 'foreignKey'  => 'user_id',
                                 'fields'      => 'id, username'
			         )
			      );  

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
  'name' => array(
                    'rule'       => array('minLength', 4),
                    'message'    => 'Name must be at least four characters long',
		            'allowEmpty' => False,
                    'required'   => True 
		    ),
  'url' => array(
                    'rule'       => 'url',
                    'message'    => 'Please enter a valid URL',
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
