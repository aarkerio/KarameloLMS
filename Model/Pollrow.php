<?php 
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @package polls
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /APP/Model/Pollrow.php

class Pollrow extends AppModel {

 public $name      = 'Pollrow';
  
 public $belongsTo = array('Poll' =>
                           array(
                                  'className'  => 'Poll', 
                                  'foreignKey' => 'poll_id'
                           )
                     );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
     	           'answer' => array(
			       'rule' => array('minLength', 2),
                   'message' => 'Mimimum 2 characters long'
			       )

		   );
}

# ? > EOF
