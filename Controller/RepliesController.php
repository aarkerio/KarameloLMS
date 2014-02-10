<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package forums
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/controllers/replies_controller.php

App::uses('Sanitize', 'Utility');

class RepliesController extends AppController
{
 public $components = array('Edublog', 'Mailer');

/**
 *  Auth Component permisssions
 *  @access public
 *  @return void 
 */
 public function beforeFilter() 
 {
   parent::beforeFilter();

   if ( $this->Auth->user() ):
       $this->Auth->allow(array('add', 'reply'));
   endif;
 }

/**
 * 
 *  @access public
 *  @return void 
 */
 public function add() 
 {
   if (!empty($this->request->data['Reply'])):
       $this->request->data['Reply']['user_id'] = $this->Auth->user('id');

       if ($this->Reply->save($this->request->data)): 
          # Email STARTS
          $this->Mailer->template = 'msgforum';
          $this->Mailer->sendAs   = 'html';
          $this->Mailer->subject =  __('New comment in forum', False);
          $this->Mailer->set('url', $this->referer());
          $this->Mailer->set('message',  $this->request->data['Reply']['reply']);
          $this->Mailer->set('username', $this->Auth->user('username'));
          $email   = $this->Reply->User->field('email', array('User.id'=>$this->request->data['Reply']['blogger_id'])); # get teachers email 
          $this->Mailer->send($email);
          # Email ENDS 
          $this->msgFlash(__('Reply saved'), $this->referer());
      endif;
  endif; 
 }
 
 /**===    ADMIN METHODS  ===**/
 
/**
 * 
 *  @access public
 *  @return void 
 */
 public function admin_points($reply_id, $sense)
 {
   $points = (int) $this->Reply->field('points', array('Reply.id'=>$reply_id));   
   $points = ($sense == 'up' ) ? $points + 1 : $points - 1;
   $this->Reply->id = (int) $reply_id;    
   if ($this->Reply->saveField('points', $points)):
       $this->set('points', $points);
       $this->render('admin_points', 'ajax');
   endif;
 }

/**
 * 
 *  @access public
 *  @return void 
 */
 public function admin_record($reply_id, $sense)
 {
   $points = (int) $this->Reply->field('points', array('Reply.id'=>$reply_id));
  
   $points = $sense == 'up' ? $points + 1 : $points - 1;
   #echo $points;
   $this->Reply->id = (int) $reply_id;
   if ($this->Reply->saveField('points', $points)):
       $this->set('points', $points);
	   $this->render('admin_points', 'ajax');
   endif;
 }

/**
 * 
 *  @access public
 *  @return void 
 */
 public function admin_edit($id = null)
 {
   if (empty($this->request->data)): 
       $this->Reply->id = $id;
       $this->request->data = $this->Reply->read();
   else:
       if ($this->Reply->save($this->request->data['Reply'])):
           $this->msgFlash(__('Reply updated', true),'/admin/topics/listing/'.$this->request->data['Reply']['topic_id']);
       endif;
   endif;
 }

/**
 *  Change status published/draft 
 *  @access public
 *  @return void 
 */
 public function admin_change($reply_id, $status, $topic_id, $blogger,$forum_id)
 {  
  $new_status = ($status == 0 ) ? 1 : 0;
  $this->Reply->id     = (int) $reply_id;
  if ($this->Reply->saveField('status', $new_status)):
      $this->msgFlash(__('Status modified'), '/topics/display/'.$blogger.'/'. $forum_id.'/'.$topic_id);
  endif;
 }

/**
 *  Remove
 *  @access public
 *  @return void 
 */
 public function admin_delete($reply_id, $topic_id, $blogger, $forum_id)
 {
  if ( $this->Reply->delete($reply_id) ):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/topics/display/'.$blogger.'/'. $forum_id.'/'.$topic_id);
 }
}
# ? > EOF
