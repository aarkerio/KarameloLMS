<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package college
*  @license http://www.gnu.org/licenses/agpl.html
*/
#File: /app/models/College.php

class College extends AppModel {

/**
 *  CakePHP Model class name
 *  @access public
 *  @var array
 */
 public $name = 'College';

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
    'description' => array(
                    'rule'       => array('minLength', 4),
                    'message'    => 'Description must be at least four characters long',
		            'allowEmpty' => False,
                    'required'   => True 
		    ),    
    'email' => array(
                    'rule'       => array('minLength', 4),
                    'message'    => 'Email must be at least four characters long',
		            'allowEmpty' => False,
                    'required'   => True 
		    )
   );
}

# ? > EOF
