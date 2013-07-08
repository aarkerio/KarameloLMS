<?php 
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package forums
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Model/Reply.php

class Reply extends AppModel {

public $actsAs   = array('Containable');

public $belongsTo = array('User' => 
                                     array('className'  => 'User', 
                                           'foreignkey' => 'user_id',
					                       'fields'     => array('username','id', 'avatar'))
                         );
/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
  'reply' => array(
                    'rule'       => array('minLength', 2),
                    'message'    => 'Reply must be at least two characters long',
		            'allowEmpty' => False,
                    'required'   => True 
		    ),
   'topic_id' => array(
		              'rule'      => 'numeric',
                     'allowEmpty' => False,
                     'on'         => 'create', # but not on update
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
