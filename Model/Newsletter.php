<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package newsletters
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: APP/Model/Newsletter.php

class Newsletter extends AppModel {

/**
 *  CakePHP class name
 *  @access pub
lic
 *  @var string
 */
  public $name      = 'Newsletter';
  
/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array
 */
  public $belongsTo = array('User');

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
			   'title' => array('rule' => array('minLength', 8),
                                'message' => 'Mimimum 8 characters long'
				           ),
               'body' => array('rule' => array('minLength', 40),
               'message' => 'Mimimum 40 characters long'
				           )				
			   );
}

# ? > EOF
