<?php 
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012,Chipotle Software(c)
*  @version 0.7
*  @package blog
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /app/models/comment.php

class Comment extends AppModel
{

/**
 *  CakePHP model class name
 *  @access public
 *  @var array
 */
  public $name = 'Comment';

/**
 *  CakePHP behaviours
 *  @access public
 *  @var array
 */
  public $actsAs    = array('Containable');  

/**
 *  CakePHP belongsTo relationship
 *  @access public
 *  @var array
 */
  public $belongsTo = array('User' =>
                                 array('className'  => 'User',
                                       'conditions' => '',
                                       'fields'     => 'User.id, User.username, User.avatar',
                                       'foreignKey' => 'user_id'
                                 ),
                            'Entry' =>
                                 array('className'  => 'Entry',
                                       'conditions' => '',
                                       'fields'     => 'Entry.title, Entry.id',
                                       'foreignKey' => 'entry_id'
                                 )
                            );
  
/**
 *  CakePHP Model validation rules
 *  @access public
 *  @var array
 */
 public $validate = array(
    'comment' => array(
                    'rule'       => array('minLength', 4),
                    'message'    => 'Comment must be at least four characters long',
		            'allowEmpty' => False,
                    'required'   => True 
		    ),    
     'user_id' => array(
		            'rule'       => 'numeric',
                    'allowEmpty' => False,
                    'on'         => 'create',   # but not on update 
                    'required'   => True 
		     ),
      'entry_id' => array(
		            'rule'       => 'numeric',
                    'allowEmpty' => False,
                     'on'        => 'create',   # but not on update 
                    'required'   => True 
		    )
   );
}

# ? > EOF
