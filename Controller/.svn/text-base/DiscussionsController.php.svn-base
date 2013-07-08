<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package news
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: app/Controller/DiscussionsController.php

/**
 * Include files
 */
App::uses('Sanitize', 'Utility');

class DiscussionsController extends AppController {

/**
 *  Cake Helpers
 *  @var array
 *  @access public
 */
 public $helpers    = array('Ck');

/**
 *  Cake Components
 *  @var array
 *  @access public
 */
 public $components = array('Mailer', 'Captcha');

/**
 *  Cake Paginate
 *  @var array
 *  @access public
 */
 public $paginate   = array('limit' => 10, 'page' => 1, 'order' => array('Discussion.id' => 'DESC'));

/**
 *  Auth component setting
 *  @access public
 *  @return void
 */
 public function beforeFilter() 
 {
  parent::beforeFilter();
  $this->Auth->allow(array('add'));
 }

/**
 *  Save discussion
 *  @access public
 *  @return void
 */
 public function add()
 {
   if ( !empty($this->request->data['Discussion']) ):
       #die(debug($this->request->data));
       $this->request->data['Discussion']['level']         = 1;
       $this->request->data['Discussion']['discussion_id'] = 1;
    
       if ( $this->Auth->user() ):
           $this->request->data['Discussion']['user_id']  = (int)    $this->Auth->user('id');   
           $this->request->data['Discussion']['name']     = (string) $this->Auth->user('username');
       else:
           if ( $this->Captcha->check($this->request->data['Discussion']['captcha']) == False ):
               $this->flash(__('Error in captcha click back button'), $this->referer(), 3);
               return False;
           endif;
           $this->request->data['Discussion']['user_id']  = (int) 2; # give anonymus user id
       endif;
 
       if ( $this->Discussion->save($this->request->data) ):  # save the comment
           $user_id  = $this->Discussion->News->field('user_id', array('News.id'=>$this->request->data['Discussion']['new_id']));
           # Email STARTS
           $email   = $this->Discussion->User->field('email', array('User.id'=>$this->request->data['Discussion']['user_id']));
           $this->Mailer->subject  =  __('New comment on portal');
           $this->Mailer->template =  'newdiscussion'; # text
           $this->Mailer->send($email);
           # Email ENDS
           $this->msgFlash(__('Message waiting for approval'), '/news/view/'.$this->request->data['Discussion']['new_id'].'#cnews');
       endif;
   endif;
 }

/*****#### ADMIN METHODS  #####*****/

 public function admin_listing()
 {
   $this->layout    = 'admin';
   $this->Discussion->bindModel(array('belongsTo'=> array('News' =>array('className'=> 'News', 'foreignKey'=> 'new_id' ))));   
   $this->paginate['fields'] = array('Discussion.id','News.id','News.title','Discussion.id','Discussion.comment', 'Discussion.created', 'Discussion.user_id', 'Discussion.status', 'User.username', 'User.avatar'); 
   $this->paginate['conditions']   = Null;
   $this->paginate['order']        = 'Discussion.id DESC';
   $this->paginate['limit']        = 30;
   $data = $this->paginate('Discussion');
   $this->set(compact('data'));
 }
 
/** 
 * Edit discussion
 * @access public
 * @param mixed integer or Null $discussion_id
 * @return void
 */
 public function admin_edit($discussion_id=Null)
 {
    if (empty($this->request->data['Discussion'])):
        $this->layout = 'admin';
        $this->request->data = $this->Discussion->read(Null, $discussion_id);
    else:
        $this->request->data['Discussion'] = Sanitize::clean($this->request->data['Discussion']);
        if ($this->Discussion->save($this->request->data)):
             $this->msgFlash(__('Data saved'), '/admin/discussions/listing');
	    endif;
    endif;
 }

/** 
 * Change status enabled/disabled actived
 * @access public
 * @param integer $discussion_id
 * @param integer $status
 * @return void
 */
 public function admin_change($discussion_id, $status)
 { 
  $new_status = ($status == 0 ) ? 1 : 0;
  $this->Discussion->id = (int) $discussion_id;

  if ($this->Discussion->saveField('status', $new_status)):
      $this->msgFlash(__('Status modified'));
  endif;
 }

/** 
 * Delete discussion
 * @access public
 * @param integer $discussion_id
 * @return void
 */
 public function admin_delete($discussion_id)
 {
  if ( $this->Discussion->delete($discussion_id) ):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/discussions/listing');
 }
}

# ? > EOF
