<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package messages
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Controller/MessagesController.php

/**
 *  Include files
 */
App::uses('Sanitize', 'Utility');

class MessagesController extends AppController {

/**
 *  Cake Helpers
 *  @var array
 *  @access public
 */
 public $helpers    = array('Ck', 'Time');

/**
 *  Cake components
 *  @var array
 *  @access public
 */
 public $components = array('Mailer', 'Edublog');

/**
 *  Cake Paginate
 *  @var array
 *  @access public
 */
 public $paginate   = array('limit' => 20, 'page' => 1);

/**
 *  Auth Component defining  permissions
 *  @access public
 *  @return void 
 */  
 public function beforeFilter() 
 {
  parent::beforeFilter();
  $actions_allowed = array('message');
  if ( $this->Auth->user() ):
     array_push($actions_allowed, 'deliver','listing','compose', 'chkMsg','display','add','send','autocomplete','sentmessages','delete');
  endif;
  $this->Auth->allow($actions_allowed);
 }

/**
 *  New message
 *  @access public
 *  @return mixed array or boolean
 */
 public function chkMsg()
 {
  if ( $this->Auth->user('id') ):
      $conditions = array('Message.user_id'=> $this->Auth->user('id'), 'Message.status'=>0);     
      return $this->Message->field('Message.id', $conditions, 'Message.id DESC');
  else:
      return False;
  endif;
 }

/**
 *  New message
 *  @access public
 *  @return void
 */
 public function message($username) # show form to send message to teacher
 {      
  $this->Edublog->setUserId($username); # blogger elements
 }

/**
 *  New message
 *  @access public
 *  @return void
 */ 
 public function compose()
 {    
  $this->layout    = 'portal';
 }

/**
 *  Deliver method, used to save and send email. This method is used in admin and front end section
 *  @access public
 *  @return void
 */
 public function deliver()
 { 
   # All here is Ajax
   $this->layout = 'ajax';
   if ( !empty($this->request->data['Message']) ):
      $this->request->data['Message']['sender_id']  = (int) $this->Auth->user('id');  # set sender
           
      if ( isset( $this->request->data['Message']['sendername']) &&  !isset( $this->request->data['Message']['user_id'])): # get user_id  if not set
         $this->request->data['Message']['user_id'] = (int) $this->Message->User->field('id',array('username'=>trim($this->request->data['Message']['sendername'])));
      endif;
      unset($this->request->data['Message']['ajax']);
      #die(debug($this->request->data));
      if ( $this->Message->save($this->request->data) ):
          $this->__sendMail($this->request->data['Message']['user_id']);
          $this->render('sent', 'ajax');
      endif;
   endif;
 }

/**
 *  Display user messages
 *  @access public
 *  @return void
 */
 public function listing()
 {
  $this->layout    = 'portal';   
  $this->paginate['conditions'] = array('Message.user_id' => $this->Auth->user('id'));
  $this->paginate['fields']     = array('Message.id', 'Message.title', 'Message.body', 'Message.created', 'Message.sender_id', 'Message.status', 'Sender.id', 'Sender.username', 'Sender.avatar');
  $this->paginate['order']      = 'Message.id DESC';
  $this->paginate['limit']      = 20;
  
  $data = $this->paginate('Message');
  $this->set(compact('data')); 
 }
 
/**
 *  Display user messages
 *  @access public
 *  @return void
 */
 public function sentmessages()
 {
   $this->layout    = 'portal';
   $this->set('data', $this->Message->sentmessages($this->Auth->user('id')));
 }

/**
 *  Ajax autocomplete
 *  @access public
 *  @return void
 */
 public function autocomplete()
 {
   #Partial strings will come from the autocomplete field as
   $this->Message->User->contain(False);
   #die(debug($_GET['query'])); # jQuery
   $this->set('users', $this->Message->User->find('all', array('fields'=>array('User.id', 'User.username'), 'conditions'=>"username LIKE '{$_GET['query']}%' AND User.id != 2")));
   $this->layout = 'ajax';
 }

/**
 *  Save messages
 *  @access public  
 *  @return void
 */
 public function add()
 {    
  $this->layout    = 'ajax';
        
  if (!empty($this->request->data['Message'])):          
     if ( isset( $this->request->data['Message']['message_id'] ) ):
         $this->Message->change($this->request->data['Message']['message_id'], 2);  # set "Reply" 
     endif;
          
     if ($this->Message->save($this->request->data)):
         $this->__sendMail($this->request->data['Message']['user_id']);
         $this->render('sent','ajax');
     endif;
  endif;
 }

/**
 *  Diplay message
 *  @access public  
 *  @return void
 */
 public function display($message_id)
 {
   $this->layout    = 'portal';
   $this->set('data', $this->Message->display($message_id, $this->Auth->user('id')));
 }

/**
 *  Delete one or several messages
 *  @access public  
 *  @return void
 */
 public function delete()
 {
   foreach ($this->request->data['Message'] as $v):
       if ( $v != 0):
           $this->Message->delete($v);
       endif;
   endforeach;
     
   $this->msgFlash(__('Data removed'),'/messages/listing');
 }

 /* == PRIVATE == **/
/**
 * Send email
 * @param integer
 * @access private
 * @void boolean
 */
 private function __sendMail($user_id)
 {
   # Email STARTS
   $this->Mailer->template = 'message';
   $this->Mailer->subject = 'Karamelo :: New message';
   $email = $this->Message->User->field('User.email', array('User.id'=>$user_id)); # get user email
   #die($email);
   # Email ENDS 
   if ( $this->Mailer->send($email) ):
       return True;
   else:
       return False;
   endif;   
 }

/** 
 *  Send mesaage to all vClassroom
 *  @access public
 *  @return void
 */
 private function __sendAll($user_id, $vclassroom_id, $blogger_id)
 { 
    $params =  array('fields'=>array('User.email', 'User.username'), 'conditions'=>array('User.id'=>$user_id));
    $user   = $this->Message->User->find('first',$params);
    
    $this->layout          = 'default';
    $this->set('vclassroom_id', $vclassroom_id);
    $this->set('username', $user['User']['username']);

    $this->Mailer->subject  = 'Karamelo :: New message';
    $this->Mailer->replyTo  = 'support@karamelo.org';
    $this->Mailer->from     = 'Chipotle-software.com';
    $this->Mailer->template = 'teacher'; 

    # Do not pass any args to send()
    if ( $this->Mailer->send( $user['User']['email']) ):
        return True;
    else:
        return False;
    endif;
 }

/**
 *  Change message status
 *  @access public
 *  @return void
 */
 public function change($message_id, $message_status)
 {
   $this->Message->id = $message_id;
   $this->Message->saveField('status', $message_status); 
 }
 
 /**=== ADMIN METHODS ===**/  

/** 
 * Send a general message to all commnunity
 * @access public
 * @return void
 */
 public function admin_general() 
 {
   if ($this->Auth->user('group_id') != 1):
       $this->redirect('/admin/messages/listing');
   endif;
    
   $this->layout = 'admin';
    
   if (!empty($this->request->data['Message'])):
      $this->request->data['Message']['title'] = Sanitize::paranoid($this->request->data['Message']['title']);
      $this->request->data['Message']['body']  = Sanitize::html($this->request->data['Message']['body']);
     
     $params = array('conditions' => array('active'=>1),
                     'fields'     => array('id'),
                     'contain'    => False);
     
     $data = $this->Message->User->find('all', $params);
     $j = 0;   # counter
     $this->request->data['Message']['sender_id'] = $this->Auth->user('id');
     #exit(print_r($data));
     
     foreach($data as $val): 
           $this->Message->create();
           $this->request->data['Message']['user_id'] = $val['User']['id'];
           if ($this->Message->save($this->request->data)):
               $j++;
           else:
               exit('error on save');
           endif;
     endforeach;
     $this->msgFlash($j . ' ' . __('messages sent'), '/admin/messages/listing');
   endif;
 }

/**  
 *  Send a message to all student on a group
 *  @access public
 *  @param integer $vclassroom_id
 *  @return void
 */ 
 public function admin_allclass($vclassroom_id)
 {
    $this->layout    = 'ajax'; 
    $this->set('vclassroom_id', $vclassroom_id);
    $this->render('admin_allclass', 'ajax');
 }

/**  
 *  Send a message to all student on a group
 *  @access public
 *  @return void
 */ 
 public function admin_send2class()
 {
  $this->layout  = 'ajax';
  #die(debug($this->request->data));
  $messages      = (int) 0;

  $this->request->data['Message']['sender_id'] = $this->Auth->user('id');
  $users = $this->Message->getUsers($this->request->data['Message']['vclassroom_id']);

  #die(debug($users));
  foreach ($users as $u):
      $this->request->data['Message']['user_id'] = $u['id'];
      $this->Message->create();
      if ($this->Message->save($this->request->data)):
          $this->__sendAll($this->request->data['Message']['user_id'],$this->request->data['Message']['vclassroom_id'],$this->request->data['Message']['sender_id']);
          $messages++;
      endif;
  endforeach;
  $this->msgFlash($messages.' '.__('messages sent to group'),'/admin/vclassrooms/members/'.$this->request->data['Message']['vclassroom_id']);  
 }
 
/**  
 *  Change status
 *  @access public
 *  @return void
 */ 
 public function admin_change($message_id, $message_status)
 {
  $this->Message->id   = $message_id;  
  $new_status = $message_status;

  if ($this->Message->saveField('status', $new_status)):
      $this->msgFlash(__('Status modified'), '/admin/news/listing');
  endif;
 }

/**  
 *  Display user messages
 *  @access public
 *  @return void
 */ 
 public function admin_listing()
 {
  $this->layout    = 'admin';
  $this->paginate['conditions'] = array('Message.user_id' => $this->Auth->user('id'));
  $this->paginate['fields']     = array('Message.id', 'Message.title', 'Message.body','Message.created','Message.sender_id','Message.status', 'Sender.id', 'Sender.username', 'Sender.avatar');
  $this->paginate['order']      = 'Message.id DESC';
  $this->paginate['limit']      = 20;
  $data = $this->paginate('Message');
  $this->set(compact('data'));
 }

/**  
 *  Reply to all members 
 *  @access public
 *  @return void
 */ 
 public function admin_reply()
 {
  $this->layout    = 'ajax';
  $this->set('data', $this->request->data['Message']);  
  $this->set('admin_reply', 'ajax');
 }


/**  
 *  Send a message to all student on a group
 *  @access public
 *  @return void
 */ 
 public function admin_compose($user_id=null)
 {
    $this->layout = 'ajax';

    if (!empty($this->request->data['Message'])):
           $this->request->data['Message']['title'] = Sanitize::html($this->request->data['Message']['title']);
           $this->request->data['Message']['body']  = Sanitize::html($this->request->data['Message']['body']);
           $this->request->data['Message']['sender_id']   = (int) $this->Auth->user('id');
           $this->request->data['Message']['username']    = $this->Auth->user('username'); 
           if ($this->Message->save($this->request->data)):
                $this->__sendMail($this->request->data['Message']['user_id']);
                $this->render('admin_ok', 'ajax');
      	   endif;
   else:
       $this->set('user_id', $user_id);
       $this->render('admin_compose', 'ajax');
   endif;
 }

/** 
 *  Display compose message form message deliver() metod saves
 * @access public
 */
 public function admin_add($username=Null)
 { 
   $this->layout   = 'admin';
   if ( $username != Null ):
       $params = array('conditions' => array('User.username'=>$username),
                       'fields'     => array('User.id', 'User.username'),
                       'contain'    => False);
      $data        =  $this->Message->User->find('first', $params);
      if ( $data ):
          $this->set('data',$data);
      endif;
   endif;
 }
 
/**  
 *  
 *  @access public
 *  @return void
 */ 
 public function admin_display($message_id)
 {
  $this->layout    = 'admin';
  $this->set('data', $this->Message->display($message_id, $this->Auth->user('id')));
  $this->render('display');
 }

/**  
 *  
 *  @access public
 *  @return void
 */ 
 public function admin_edit($message_id = null)
 {
  if (empty($this->request->data)):
     $this->layout = 'admin';           
     $this->request->data = $this->Message->read(null, $message_id);   
  else:
     $this->request->data['Message'] = Sanitize::clean($this->request->data['Message']); 
     if ($this->Message->save($this->request->data)):
         $this->msgFlash(__('Message updated'),'/admin/messages/listing');
	 endif;
 endif;
 }

/**  
 *  Delete one or several messages
 *  @access public
 *  @return void
 */
 public function admin_delete($message_id=null)
 {
   if ($this->request->data['Message']):
      foreach ($this->request->data['Message'] as $v):
         if ( $v != 0 ):
             $this->Message->delete($v);
         endif;
      endforeach;
   else:
      $this->Message->delete($message_id);
   endif;
   $this->msgFlash(__('Data removed'),'/admin/messages/listing');
 }
}
# ? > EOF
