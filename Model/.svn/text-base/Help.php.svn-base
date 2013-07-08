<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package helps
*  @license http://www.gnu.org/licenses/agpl.html
*/
#File: /app/models/help.php

class Help extends AppModel{
 
/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */     
 public $validate = array(
		       'title' => array(
			           'rule' => array('minLength', '4'),
                       'message' => 'Minimum 4 characters long'
	                     ),
		       'url' => array(
			           'rule' => array('minLength', '8'),
                       'message' => 'Minimum 8 characters long'
	                     ),
		       'help' => array(
			           'rule' => array('minLength', '8'),
                                       'message' => 'Minimum 8 characters long'
	                     )
	               );
}
# ? > EOF
