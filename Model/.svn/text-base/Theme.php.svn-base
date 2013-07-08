<?php 
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.6
*  @package news
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/Theme.php

class Theme extends AppModel {

/**
 *  CakePHP Model class name
 *  @access public
 *  @var string
 */
public $name = 'Theme';

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
                     'theme' => array(
		                       'rule'    => array('minLength', '2'),
                                       'message' => 'Minimum 4 characters long'
			                         ),
                     'description' => array(
			             'rule'    => array('minLength', '2'),
                                     'message' => 'Minimum 2 characters long'
					                ),
                     'img' => array(
			              'rule' => array('minLength', '4'),
                                      'on'   => 'create',
                                      'message' => 'Minimum 4 characters long'
				                 )
	       );
}

# ? > EOF
