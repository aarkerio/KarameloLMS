<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package chats
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /APP/Controller/ChatsController.php

App::uses('Sanitize', 'Utility');

class ChatsController extends AppController {

/**
 *  CakePHP helper
 *  @access public
 *  @var array
 */ 
 public $helpers = array('Time');

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */ 
 public function beforeFilter() 
 {
  parent::beforeFilter();
  if ( $this->Auth->user() ):
      $this->Auth->allow(array('display', 'getMessages'));
  endif;
 }

/**
 *  Show and refresh chats in popup window
 *  @access public
 *  @return void 
 */ 
 public function getMessages()
 {
  $this->layout = 'ajax';
   
  $params = array('conditions'   => array('Chat.status'=>1, 'Chat.vclassroom_id'=>$_POST['vclassroom_id']),
                   'fields'       => array('Chat.message', 'Chat.created', 'User.username', 'User.id'),
                   'order'        => 'Chat.id DESC',
                   'limit'        => 15);
  $data = $this->Chat->find('all', $params);
  # debug($data);
  $this->set('msgs', $data);
  $this->render('messages', 'ajax');
 }
 
/*=== ADMIN  METHODS ===*/
/**
 *  Display all chats
 *  @access public
 *  @return void 
 */ 
 public function admin_listing($vclassroom_id) 
 {
  $this->layout = 'admin';
  $params = array('conditions' => array('Chat.vclassroom_id'=>$vclassroom_id));
  $this->set('data', $this->Chat->find('all', $params));
 }

/**
 *  Update FLV stream
 *  @access public
 *  @return void 
 */ 
 public function admin_edit() 
 {
  $this->layout = 'ajax';
  $this->Chat->Vclassroom->id = (int) $this->request->data['Vclassroom']['id'];
  if ($this->Chat->Vclassroom->saveField('streaming', $this->request->data['Vclassroom']['streaming'])):
      $this->Session->setFlash('Data saved');
  endif;
  #$params = array('conditions'=>array('vclassroom_id'=> $this->request->data['Vclassroom']['id']));
  $this->set('data',  $this->request->data['Vclassroom']['streaming']);
 }

/**
 *  View all chats  
 *  @access public
 *  @return void 
 */ 
 public function admin_export($vclassroom_id)
 {
   $this->Chat->updateAll(
                          array('Chat.status'        => 0),
                          array('Chat.vclassroom_id' => $vclassroom_id)
                          );
   $this->msgFlash(__('Chat reseted'),'/admin/chats/record/'.$vclassroom_id);
 }

/**
 *  View all chats  
 *  @param integer $vclassroom_id
 *  @param integer $view_all
 *  @access public
 *  @return void 
 */ 
 public function admin_record($vclassroom_id, $view_all=0)
 {
   $this->layout = 'popup';
   $conditions = array('Chat.vclassroom_id'=>$vclassroom_id);
   if ( $view_all == 0 ): # by default get chats no reseted
       $conditions['Chat.status'] = 1; 
   else:
       $this->set('historic');
   endif;
   $params = array('conditions'   => $conditions,
                   'fields'       => array('Chat.message', 'Chat.created', 'User.username', 'User.id'),
                   'order'        => 'Chat.id DESC',
                   'limit'        => Null);
   $msgs = $this->Chat->find('all', $params);
   # debug($data);
   $this->set('msgs', $msgs);
   $params = array('conditions' => array('Vclassroom.id'=>$vclassroom_id),
                   'fields'     => array('Vclassroom.name','Vclassroom.id','Vclassroom.chat','Vclassroom.streaming','Vclassroom.videoconference'),
                   'contain'    => False
                   );
   $this->set('data', $this->Chat->Vclassroom->find('first', $params));
 }
 
/**
 *  Remove all chats in this vclassroom      
 *  @access public 
 *  @return void
 */
 public function admin_delete($vclassroom_id)
 {
  if ($this->Chat->deleteAll(array('Chat.vclassroom_id'=>$vclassroom_id))):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg,'/admin/chats/record/'.$vclassroom_id);
 }
}
# ? > EOF
