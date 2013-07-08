<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package chats
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /APP/Plugin/Shout/Controller/ShoutsController.php

App::uses('Sanitize', 'Utility');

class ShoutsController extends ShoutAppController {

/**
 *  CakePHP helpers
 *  @access public
 *  @var array
 */ 
    public $helpers = array('Time', 'Session');


/**
 *  CakePHP helpers
 *  @access public
 *  @var array
 */ 
 public $components    = array('Adds');

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */ 
 public function beforeFilter() 
 {
  parent::beforeFilter();
  $this->Auth->allow(array('savemessage', 'getMessages', 'stream', 'save'));
 }

/**
 *  Just print
 *  @access public
 *  @return void
 */
 public function stream($session_id='video1')
 {
  $this->layout    = 'videos';

  if ( !$this->Session->read('Shout.username') ):
      $random = $this->Adds->genPassword(5);
      $username = 'invitado_'.$random;
      $this->Session->write('Shout.username', $username);
  endif;
 
  $params = array('conditions' => array('Shout.session_id'=>$session_id),
                  'fields'     => array('Shout.message', 'Shout.created', 'Shout.username'),
                  'order'      => 'Shout.id DESC',
                  'limit'      => 15);
  $this->set('msgs', $this->Shout->find('all', $params));
  $this->set('session_id', $session_id);
 }

/**
 *  Save messages on chat
 *  @access public
 *  @return void
 */
 public function savemessage()
 {
  $this->layout = 'ajax';
 
  if ( !empty($this->request->data['Shout'])):
      $this->Shout->save($this->request->data);
      $params = array('conditions' => array('Shout.session_id'=>$this->request->data['Shout']['session_id']),
                      'fields'     => array('Shout.message', 'Shout.created', 'Shout.username'),
                      'order'      => 'Shout.id DESC',
                      'limit'      => 15);
      $this->set('msgs', $this->Shout->find('all', $params));
      $this->render('messages');
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
   
  $params = array('conditions'   => array('Shout.session_id'=>$_POST['session_id']),
                   'fields'       => array('Shout.message', 'Shout.created', 'Shout.username'),
                   'order'        => 'Shout.id DESC',
                   'limit'        => 15);
  # debug($params);
  $data = $this->Shout->find('all', $params);
  # debug($data);
  $this->set('msgs', $data);
  $this->render('messages', 'ajax');
 }
 
/*=== ADMIN  METHODS ===*/

/**
 *  Update FLV stream
 *  @access public
 *  @return void 
 */ 
 public function admin_edit() 
 {
  $this->layout = 'ajax';
  $this->Shout->Vclassroom->id = (int) $this->request->data['Vclassroom']['id'];
  if ($this->Shout->Vclassroom->saveField('streaming', $this->request->data['Vclassroom']['streaming'])):
      $this->Session->setFlash('Data saved');
  endif;
  #$params = array('conditions'=>array('vclassroom_id'=> $this->request->data['Vclassroom']['id']));
  $this->set('data',  $this->request->data['Vclassroom']['streaming']);
 }


/**
 *  Remove all chats in this vclassroom      
 *  @access public 
 *  @return void
 */
 public function admin_delete($session_id)
 {
  if ($this->Shout->deleteAll(array('Shout.session_id'=>$session_id))):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg,'/admin/chats/record/'.$session_id);
 }
}
# ? > EOF
