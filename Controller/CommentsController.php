<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package blog
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : APP/Controller/CommentsController.php

App::uses('Sanitize', 'Utility');

class CommentsController extends AppController {

/**
 *  Paginate options
 *  @access public
 *  @var array
 */
  public $paginate = array('contain'=>array('Entry'=>array('title')));

/**
 *  Array helpers
 *  @access public
 *  @var array
 */
 public $helpers    = array('Ck', 'News', 'Time');

/**
 * Components
 * @access public
 * @var array
 */
 public $components = array('Captcha', 'Mailer');

/**
 *  Auth component
 *  @access public
 *  @return void
 */
 public function beforeFilter() 
 {
   parent::beforeFilter();
   $this->Auth->allow(array('add', 'securimage'));
 }

/**
 * Add comment
 * @access public
 * @return void
 */
 public function add()
 {
  $this->autoRender = False;
  if ( !empty($this->request->data['Comment']) ):
      if ( !$this->Auth->user() ):
          if ( $this->Captcha->check($this->request->data['Comment']['captcha']) == False ):
              $this->set('captcha', False);
              $this->render('/entries/comment', 'ajax');
              return False;
          endif;
          $this->request->data['Comment']['user_id']  = 2; # give anonymus user id
      else:
          $this->request->data['Comment']['user_id']  = (int) $this->Auth->user('id');
          $this->request->data['Comment']['username'] = (string) $this->Auth->user('username');
      endif;
      if ($this->Comment->save($this->request->data)):
          # Email STARTS
          $email   = (string) $this->Comment->User->field('email', array('User.id'=>$this->request->data['Comment']['blogger_id']));
          $this->Mailer->subject =  __('New comment on your blog');
          $this->Mailer->view    = 'msgblog';  
          $this->Mailer->send($email);
          # Email ENDS
          $comment_id = (int) $this->Comment->getLastInsertID();
          $params = array('conditions'=>array('Comment.id'=>$comment_id));
          $this->set('data',  $this->Comment->find('first', $params));
          $this->render('/Entries/comment', 'ajax');
      endif;
  endif;
 } 

/**
  *  Generate captcha
  *  @access public
  *  @return void
  */ 
 public function securimage()
 {
    return $this->Captcha->show();
 }

/**    ===== ADMIN METHODS ====== **/

/**
 * List Comments
 * @access public
 * @return void
 */
 public function admin_listing()
 {
 $this->layout = 'admin';

 $conditions = array('Comment.blogger_id'=>$this->Auth->user('id'));
 
 $this->paginate['Comment'] = array(
                                 'contain'    => array('Entry', 'User'),
                                 'order'      => 'Comment.id DESC',
                                 'conditions' => $conditions,
                                 'recursive'  => True,
                                 'limit'      => 20
                                 );
 $data = $this->paginate('Comment');

 $this->set(compact('data'));
}

/**
 * change status enabled/disabled actived}
 * @access public
 * @param integer $comment_id
 * @param integer $status
 * @param integer $current_page
 * @param moxed integer or Null $entry_id
 * @param mixed string or Null $blogger
 * @return void
 */
 public function admin_change($comment_id, $status, $current_page = 1,  $sort = 'id', $direction, $entry_id=Null, $blogger=Null)
 { 
  $new_status        = $status == 0 ? 1 : 0;
  $this->Comment->id = (int) $comment_id;
  if ($sort == 'id'):
      $direction ='desc'; 
  endif;

  if ($this->Comment->saveField('status', $new_status)):
      if ( $entry_id === Null): # I came from a general comment review
          $url = '/admin/comments/listing/page:'.$current_page.'/sort:'.$sort.'/direction:'.$direction;
      elseif($entry_id != Null and $blogger != Null):
          $url = '/entries/view/'.$blogger .'/'.$entry_id; 
      else:      # I came from a single entry comments review, so back to there
          $url = '/admin/comments/listing/'.$entry_id.'/page:'.$current_page.'/sort:'.$sort.'/direction:'.$direction;  # rnstux pagination option ;-)
      endif;
      $this->msgFlash(__('Status modified'), $url);
  endif;
 }
 
 /**
  * Edit comment
  * @access public 
  * @param integer $entry_id
  * @return void
  */
 public function admin_edit($id=null)
 {   
   $this->layout    = 'admin';
     
   if ( empty( $this->request->data['Comment'] ) ):
       $this->request->data      = $this->Comment->read(Null, $id);
   else:
       $this->request->data['Comment']['comment'] = Sanitize::clean($this->request->data['Comment']['comment']);
       if ($this->Comment->save($this->request->data)):
           $this->msgFlash(__('Data updated'), '/admin/comments/edit/'.$this->request->data['Comment']['id']);
       endif;
   endif;
 }
 
/**
 * Delete comment
 * @access public 
 * @param integer $comment_id
 * @param mixed Null or integer $entry_id
 * @param mixed Null or string  $blogger
 * @return void
 */
 public function admin_delete($comment_id, $entry_id=Null, $blogger=Null)
 {
  if ($this->Comment->delete($comment_id)):
      if ( $entry_id === Null and $blogger === NUll):       # I came from a general comment review
          $url = '/admin/comments/listing';
      elseif( $entry_id != Null and $blogger != NUll):      # I came from edublog frontend
          $url = '/entries/view/'.$blogger .'/'.$entry_id; 
      else:                                                 # I came from a single entry comments review, so back to there
          $url = '/admin/comments/listing/'. $entry_id;
      endif;
      $this->msgFlash(__('Data removed'), $url);
  endif;
 }
}

# ? > EOF
