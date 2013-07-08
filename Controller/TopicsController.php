<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package forum
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: app/Controller/TopicsController.php

# Load CakePHP librarie
App::uses('Sanitize', 'Utility');

class TopicsController extends AppController {

/**
 *  Cake helpers
 *  @var array
 *  @access public
 */
 public $helpers       = array('Time', 'Ck'); 
 
/**
 *  Cake components
 *  @var array
 *  @access public
 */
 public $components    = array('Edublog', 'Mailer');

/**
 *  Change status published/draft 
 *  @access public
 *  @return void
 */ 
 public function beforeFilter() 
 {   
   parent::beforeFilter();

   if ( $this->Auth->user() ):
       $this->Auth->allow(array('display', 'add', 'reply'));
   endif;
 }

/**
 *  Display discussion Thread
 *  @access public
 *  @param  string  $username
 *  @param  integer $forum_id
 *  @param  integer $topic_id
 *  @return mixed  array or boolean  
 */
 public function display($username, $forum_id, $topic_id)
 {  
  $this->Edublog->setUserId($username);
 
  $vclassroom_id = $this->Topic->Forum->field('vclassroom_id', array('Forum.id'=>$forum_id));
  # student belongst to this class?
  $belongs =  $this->Topic->Forum->Vclassroom->UserVclassroom->belongs($this->Auth->user('id'), $vclassroom_id); 
  if ( $belongs ):
      $this->set('belongs',$belongs);
  else:
      $this->redirect('/blog/'.$username);
      return False;
  endif;
  
  if ( $this->Auth->user('id') == $this->Edublog->userId):
      $params = array('conditions' => array('Topic.id'=>$topic_id), 'recursive' => 2);
  else:
      $params = array('conditions' => array('Topic.id'=>$topic_id),
                      'contain'=>array('User','Forum', 'Reply'=>array('User','conditions'=>array('Reply.status'=>1), 'fields'=>array('Reply.id', 'Reply.reply', 'Reply.user_id', 'Reply.status', 'Reply.created'))));
  endif;
  # This must be improved
  $this->Topic->User->unbindModel(array('hasMany'=>array('Category', 'Faq', 'Lesson', 'Entry', 'Acquaintance', 'Vclassroom')));
  $this->Topic->Forum->unbindModel(array('hasMany'=>array('Topic'), 'belongsTo'=>array('UserVclassroom', 'Catforum')));
  $data =  $this->Topic->find('first',$params);
  #die(debug($data)); 
  $this->set('data',$data);

  if ( !$this->Session->check('topic'.$topic_id)  ): # add 1 to visit 
      $this->Topic->addVisitor($topic_id, $this->Auth->user('id'));
      $this->Session->write('topic'.$topic_id,  $topic_id); # set session, only one visit per session
  endif;
 }

/**
 *  Add new topic Ajax first display form and then this method saved
 *  @param integer $vclassroom_id
 *  @param integer $forum_id
 *  @param integer $blogger_id
 *  @access public
 *  @return void
 */  
 public function add($vclassroom_id = Null, $forum_id = Null,  $blogger_id = Null) 
 {
   $this->layout='ajax';
   if ( !empty($this->request->data['Topic']) ):
       $this->request->data['Topic']['user_id'] = (int) $this->Auth->user('id');
       if ($this->Topic->save($this->request->data)): 
           # Email STARTS
           $email   = $this->Topic->User->field('email', array('User.id'=>$this->request->data['Topic']['blogger_id']));
           $subject =  __('New comment in forum');
           $message = $this->Auth->user('username').' '.__('wrote').": \n ".$this->request->data['Topic']['message'].". \n";
           $this->Mailer->set('url', $this->referer());
           $this->Mailer->set('username', $this->Auth->user('username'));
           $this->Mailer->set('message',$message);
           $this->Mailer->template = 'msgforum';
           $this->Mailer->sendAs   = 'html';
           $this->Mailer->subject  = $subject;
           $this->Mailer->send($email);
           # Email ENDS 
           $this->msgFlash(__('Topic added'), $this->referer());
       endif;
   else:
       $this->set('forum_id',      $forum_id);
       $this->set('vclassroom_id', $vclassroom_id);
       $this->set('blogger_id',    $blogger_id);
   endif;
 }
 
/**
 *  Change status published/draft 
 *  @param integer $vclassroom_id
 *  @param integer $forum_id
 *  @param integer $topic_id
 *  @param integer $blogger_id
 *  @access public
 *  @return void
 */
 public function reply($vclassroom_id, $forum_id, $topic_id, $blogger_id) 
 {
   #adds new reply to topic
   $this->layout = 'ajax';
   $this->set('forum_id',      $forum_id);
   $this->set('topic_id',      $topic_id);
   $this->set('blogger_id',    $blogger_id);
   $this->set('vclassroom_id', $vclassroom_id);
 }
 
/*** ===   ADMIN METHODS ===********/
/**
 *  Change status published/draft 
 *  @access public
 *  @return void
 */
 public function admin_listing($topic_id)
 {
  $this->layout    = 'admin';
  $parasms = array('conditions' => array('Topic.user_id'=>$this->Auth->user('id'), 'Topic.id'=>$topic_id),
                   'fields'     => array('id', 'subject', 'message', 'status', 'created')
                  );
  $this->set('data', $this->Topic->find('first', $params));     
 }

/**
 *  Change status published/draft 
 *  @access public
 *  @return void
 */ 
 public function admin_edit($topic_id = Null)
 {
   if (empty($this->request->data['Topic'])):
      $this->request->data = $this->Topic->findById($topic_id);
  else:
	  if ($this->Topic->save($this->request->data)):
          $this->msgFlash(__('Data updated'), '/admin/vclassrooms/listing');
	  endif;
  endif;
 }
 
/**
 *  Change status published/draft 
 *  @access public
 *  @return void
 */
 public function admin_change($topic_id, $status, $forum_id)
 {  
  $new_status = ($status == 0 ) ? 1 : 0;
  $this->Topic->id = (int) $topic_id;
  
  if ($this->Topic->saveField('status', $new_status)):
	  $this->msgFlash(__('Status modified'), '/admin/forums/topics/'.$forum_id);
  endif;
 }
 
/**
 *  Change status published/draft 
 *  @access public
 *  @return void
 */
 public function admin_reply($reply_id) 
 {
   $this->layout = 'popup';
   $params = array('conditions' => array('Reply.id'=>$reply_id),
                   'contain'    => False);
   $this->set('data', $this->Topic->Reply->find('first', $params));
 }

/**
 *  Change status published/draft 
 *  @param integer $topic_id
 *  @param integer $vclassroom_id
 *  @param integer $forum_id
 *  @param integer $blogger
 *  @access public
 *  @return void
 */
 public function admin_delete($topic_id, $vclassroom_id, $forum_id, $blogger)
 {
  if ( $this->Topic->delete($topic_id) ):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/forums/display/'.$blogger.'/'.$forum_id.'/'. $vclassroom_id);
 } 
}
# ? > EOF
