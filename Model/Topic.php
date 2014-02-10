<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software(c)
*  @version 0.7
*  @package topics
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: app/Model/Topic.php

class Topic extends AppModel {

/**
 *  Load behaviours
 *  @access public    
 *  @var array
 */ 
 public $actsAs   = array('Containable');

/**
 *  CakePHP hasMany relation
 *  @access public
 *  @var array
 */
 public $belongsTo = array('Forum' => 
                                     array('className'  => 'Forum', 
                                           'foreignkey' => 'forum_id'),
                          'User' => 
                                     array('className'  => 'User', 
                                           'foreignkey' => 'user_id',
                                           'fields'     => 'username, id')
                                           ); 
/**
 *  CakePHP hasMany relation
 *  @access public
 *  @var array
 */
 public $hasMany = array('Reply' => 
                                     array('className'  => 'Reply', 
                                           'foreignkey' => 'topic_id',
	       				                   'order'      => 'id'
					   ),
                         'Visitor' => 
                                     array('className'  => 'Visitor', 
                                           'foreignkey' => 'topic_id',
	       				                   'order'      => Null
					   )
      );

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
		   'subject' => array(
				       'rule' => array('minLength', '3'),
                                       'message' => 'Minimum 3 characters long'
				       ),
		   'message' => array(
				       'rule' => array('minLength', '5'),
                                       'message' => 'Minimum 5 characters long'
				       ),
           'user_id' => array(
				     'rule'       => 'numeric',
				     'allowEmpty' => False,
				     'required'   => True,
                     'on'         => 'create'  # but no on update
				     ),
           'forum_id' => array(
				     'rule'       => 'numeric',
				     'allowEmpty' => False,
				     'required'   => True,
                     'on'         => 'create'   # but not on update
				      )
		     );

/**
 * Indicates user is watching this topic by first time and is not a new topic anymore
 * @access public
 * @param integer $topic_id
 * @param integer $user_id
 * @return boolean
 */  
  public function addVisitor($topic_id, $user_id)  
  { 
    $this->data['Visitor']['topic_id'] = (int) $topic_id; 
    $this->data['Visitor']['user_id']  = (int) $user_id;

    if ( $this->Visitor->save($this->data) ):
        return True;
    else:
        die('Error on addVisitor function');
    endif;

    return True;
  }
}

# ? > EOF
