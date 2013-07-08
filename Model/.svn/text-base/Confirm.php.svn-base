<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package users
*  @license http://www.gnu.org/licenses/agpl.html
*/
#File: /app/models/confirm.php

class Confirm extends AppModel
{
/**
 *  CakePHP Model class name
 *  @access public
 *  @var array
 */
 public $name      = 'Confirm';

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
  'secret' => array(
                    'rule'       => array('minLength', 4),
                    'message'    => 'Secret must be at least four characters long',
		            'allowEmpty' => False,
                    'required'   => True 
		    ),
  'user_id' => array(
		              'rule'      => 'numeric',
                     'allowEmpty' => False,
                     'on'         => 'create', # but not on update
                     'required'   => True 
		     )
   );
}

# ? > EOF
