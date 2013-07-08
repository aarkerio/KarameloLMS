<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package lessons
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : app/Controller/AnnotationsController.php

/**
 *  Include files
 */
App::uses('Sanitize', 'Utility');

class AnnotationsController extends AppController {

/**
 *  Cake Paginate
 *  @var array
 *  @access public
 */
 public $paginate = array('limit' => 20, 'page' => 1);

/**
 *  Cake Components
 *  @var array
 *  @access public
 */
 public $components = array('Captcha', 'Mailer');

/**
 *  Auth Component permisssions
 *  @access public
 *  @return void 
 */ 
 public function beforeFilter() 
 {
   parent::beforeFilter();
   $allowed = array('add', 'captcha');
   if ( $this->Auth->user() && $this->Auth->user('group_id') < 2):
       array_push($allowed, 'change', 'delete');
   endif;
   $this->Auth->allow($allowed);
 }

/**
 *  Generate captcha
 *  @access public
 *  @return void 
 */ 
 public function captcha()
 {
   return $this->Captcha->show();
 }


/**
 *  Save comment
 *  @access public
 *  @return void 
 */ 
 public function add()
 {
  if ( !empty($this->request->data['Annotation']) ):
      if ( !$this->Auth->user() ):
          if ( $this->Captcha->check($this->request->data['Annotation']['captcha']) == False ):
             $this->flash(__('Error in captcha click back button'), $this->referer(), 3);
             return False;
          endif;
          $this->request->data['Annotation']['user_id']  = 2; # give anonymus user id
      else:
          $this->request->data['Annotation']['user_id']  = (int) $this->Auth->user('id');
      endif;
      if ($this->Annotation->save($this->request->data)):
           $email = $this->Annotation->User->field('email', array('User.id'=> $this->request->data['Annotation']['blogger_id']));
           $this->Mailer->set('message', $this->request->data['Annotation']['comment']);
           $this->Mailer->template = 'msglesson'; # note no '.ctp'
           $this->Mailer->subject  = 'Karamelo e-Learning:: new comment in lesson';
           $this->Mailer->send($email);
           $id = (int) $this->Annotation->getLastInsertID();
           $params = array('conditions'=>array('Annotation.id'=>$id));
           $this->set('data', $this->Annotation->find('first', $params));
      endif;
  endif;
 }

/**
 *  Change status enabled/disabled actived
 *  @access public
 *  @param integer $annotation_id
 *  @param integer $status
 *  @param string  $username
 *  @param integer $lesson_id
 *  @return void 
 */ 
 public function change($annotation_id, $status, $username, $lesson_id)
 { 
  $new_status = ($status == 0 ) ? 1 : 0;
  $this->Annotation->id  = (int) $annotation_id;
  if ($this->Annotation->saveField('status', $new_status)):
      $this->msgFlash(__('Status modified'), '/lessons/view/'. $username.'/'.$lesson_id);
  endif;
 }

/**    ===== ADMIN METHODS ====== **/
/**
 *  Display comments
 *  @access public
 *  @return void 
 */ 
 public function admin_listing()
 {
   $this->layout                  = 'admin';
   $this->paginate['conditions']  = array('Lesson.user_id'=>$this->Auth->user('id'));
   $this->paginate['fields']      = array('id', 'comment', 'created', 'user_id', 'status');
   $this->paginate['order']       = array('Annotation.id' => 'DESC');

   $data = $this->paginate('Annotation');

   $this->set(compact('data'));
 }
 
/**
 *  Change status enabled/disabled actived
 *  @access public
 *  @return void 
 */
 public function admin_change($annotation_id, $status)
 { 
  $new_status = ($status == 0 ) ? 1 : 0;
  $this->Annotation->id  = (int) $annotation_id;
  if ($this->Annotation->saveField('status', $new_status)):
      $this->msgFlash(__('Status modified'), '/admin/lessons/comments');
  endif;
  }

/**
 *  Create or edit  
 *  @access public
 *  @return void 
 */
 public function admin_edit($id=null)
 {
  $this->layout    = 'admin';

  if ( empty( $this->request->data['Annotation'] ) ):
      $this->request->data      = $this->Annotation->read(null, $id);
  else:
      if ($this->Annotation->save($this->request->data)):  
          $this->msgFlash(__('Data saved', true), '/admin/comments/edit/'.$this->request->data["Annotation"]["id"]);
      endif;
  endif;
 }

/**
 *  Remove comment or all comments in lesson
 *  @access public
 *  @return void 
 */  
 public function admin_delete($model_id, $delAll=False)
 {
  if ($delAll === False):  
      if ($this->Annotation->delete($model_id)):   #delete one comment in lesson
          $this->msgFlash(__('Comment removed'), $this->referer());
      endif;
  else:
      if ( $this->Annotation->deleteAll(array('Annotation.lesson_id'=>$model_id)) ):  # del all coments 
          $this->msgFlash(__('All comments removed'), $this->referer());
      endif;
  endif;
 }
}

# ? > EOF
