<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package users
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/Recover.php


class Recover extends AppModel {

 public $name      = 'Recover';
 
 public $belongsTo = array('User');

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */ 
 public $validate = array(
  'random' => array(
                    'rule'       => array('minLength', 4),
                    'message'    => 'Field must be at least four characters long',
		    'allowEmpty' => false,
                    'required'   => true 
		    ), 
  'user_id' => array(
		     'rule'       => 'numeric',
                     'allowEmpty' => false,
                     'required'   => true 
		     )
   );

}

# ? > EOF
