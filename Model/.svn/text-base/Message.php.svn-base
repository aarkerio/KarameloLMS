<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package messages
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: APP/Model/Message.php

class Message extends AppModel
{

 public $name      = 'Message';
 
/**
 *  validate CakePHP association
 *  @access public
 *  @var array
 */
 public $belongsTo = array(
                           'User' =>
                               array('className'  => 'User',
                                     'conditions' => '',
                                     'fields'     => 'id, username, avatar',
                                     'foreignKey' => 'user_id'
                                 ),
                           'Sender' =>
                               array('className'  => 'User',
                                     'conditions' => '',
                                     'fields'     => 'id, username, avatar',
                                     'foreignKey' => 'sender_id'
                                 ),
                           );
/**
 *  Behaviours
 *  @access public
 *  @var array
 */
 public $actsAs = array('Containable');

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
			'title' => array(
 			       'rule' => array('minLength', '4'),
                   'message' => 'Mimimum 4 characters long'
		   		       ),
            'body' => array(
			       'rule' => array('minLength', '4'),
                    'message' => 'Mimimum 4 characters long'
	  			       ),
			 'user_id' => array(
		             'rule'       => 'numeric',
                     'allowEmpty' => False,
                     'on'         => 'create', # but not on update
                     'required'   => True 
                                 ),
     	     'sender_id' => array(
		             'rule'       => 'numeric',
                     'allowEmpty' => False,
                     'on'         => 'create', # but not on update
                     'required'   => True 
		                          )
	   );
 
/**
 * inbox
 * @access public
 * @param integer $user_id
 * @return array empty or populated
 */
 public function inbox($user_id) 
 {
  $this->unbindModel(array('belongsTo'=>array('User')));

  $this->bindModel(array('belongsTo'=>array(
	                                     'User' => array(
                                                              'className'  => 'User',
                                                              'foreignKey' => 'sender_id'
                                                             )
                                              )
                  ) ); 

   $params = array('conditions'   => array('Message.user_id' => $user_id),
                   'fields'       => array('Message.id', 'Message.title', 'Message.body', 'Message.created', 'Message.sender_id', 'Message.status', 'User.id', 'User.username'),
                   'order'        => 'Message.id DESC',
                   'limit'        => 50);

   return $this->find('all', $params);
 }

/**
 * display
 * @access public
 * @param integer $message_id
 * @param integer $user_id
 * @return array
 */
 public function display($message_id, $user_id) 
 {
  $this->unbindModel(array('belongsTo'=>array('User')));

  $this->bindModel(array('belongsTo'=>array(
	                                     'User' => array(
                                                         'className'  => 'User',
                                                         'foreignKey' => 'sender_id'
                                                        )
                                              )
                  )); 

   $params = array('conditions' => array('Message.user_id' => $user_id, 'Message.id'=>$message_id),
                   'fields'     => array('Message.id', 'Message.title', 'Message.body', 'Message.created', 'Message.sender_id', 'Message.status', 'User.id', 'User.username'),
                  );
        
   $data = $this->find('first', $params);

   if ( $data['Message']['status'] == 0 ):    # change from new to readed
       $this->change($data['Message']['id'], 1);
   endif;

   return $data;
 }

/**
 * sentmessage Messages sent
 * @access public
 * @param integer $user_id
 * @return array  empty or populated  
 */
 public function sentmessages($user_id) 
 {
   $params = array('conditions' => array('Message.sender_id' => $user_id),
                   'fields'     => array('Message.id', 'Message.title', 'Message.body', 'Message.created', 'Message.sender_id', 'Message.status', 'User.id', 'User.username'),
                   'order'      => 'Message.id DESC',
                   'limit'      => 50);
   return $this->find('all', $params);
 }

/**
 * Change message status 
 * @param integer $message_id 
 * @param integer $message_status 
 * @return boolean 
 */
 public function change($message_id, $message_status)
 {
   $this->id = $message_id;
   
   if ( $this->saveField('status', $message_status) ):
       return True;
   else:
       return False;
   endif;
 }

/**
 *  getUsers  get user to send message to many students 
 *  @access public
 *  @param integer $vclassroom_id
 *  @return array empty or populated 
 */
 public function getUsers($vclassroom_id)
 {
   $users = array();

   $params = array('conditions' => array('UserVclassroom.vclassroom_id'=>$vclassroom_id),
                    'fields'     => array('UserVclassroom.user_id'));
    $Users_ids = $this->User->UserVclassroom->find('all', $params);

    # die(debug($Usersids));
    foreach($Users_ids as $u):
        $params = array('conditions' => array('User.id'=>$u['UsersVclassroom']['user_id']),
                        'fields'     => array('User.email', 'User.id'));
        $this->User->contain();
        $tmp = $this->User->find('first', $params);
        # die(debug($tmp));
        array_push($users, $tmp['User']);
    endforeach;
    
    return $users; 
 } 
}
# ? > EOF
