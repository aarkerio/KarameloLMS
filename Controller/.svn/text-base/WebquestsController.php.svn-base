<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright (c) 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package webquest
*  @license http://www.gnu.org/licenses/agpl.html
*/
#file: APP/Controller/WebquestController.php

App::uses('Sanitize', 'Utility');

class WebquestsController extends AppController {

/**
 *  Cake Helpers
 *  @var array
 *  @access public
 */  
 public $helpers     = array('Ck'); 

/**
 *  Cake Components
 *  @var array
 *  @access public
 */ 
 public $components  = array('Edublog', 'Wizard.Wizard', 'Mailer');

/**
 *  Auth Component permisssions
 *  @access public
 *  @return void 
 */
 public function beforeFilter() 
 {
  parent::beforeFilter();
  $this->Auth->allow(array('display', 'view', 'result'));
  # Wizard 
  $this->Wizard->WizardAction ='admin_wizard';
  $this->Wizard->steps        = array('admin_wzdone', 'admin_wzdtwo', 'admin_wzdthree');
  $this->Wizard->completeUrl  = '/admin/webquests/finish'; 
  $this->Wizard->cancelUrl    = '/admin/webquests/display'; 
  $this->Wizard->validate     = False; 
 }

/**
 * Display
 * @param string $username
 * @param integer $webquest_id
 * @access public
 * @return void
 */
 public function display($username, $webquest_id)
 {    
  $this->Edublog->setUserId($username);
  $params = array('conditions' => array('Webquest.status'=>1, 'Webquest.id' => $webquest_id),
                  'fields'     => array('id', 'title', 'introduction', 'created'),
                  'order'      => 'Webquest.id DESC',
                  'limit'      => 20);
  $this->set('data', $this->Webquest->find('all', $params)); 
 }

/**
 * View webquest
 * @param string $username
 * @param integer $webquest_id
 * @param integer $vclassroom_id
 * @access public
 * @return void
 */
 public function view($username, $webquest_id, $vclassroom_id)
 { 
  $this->Edublog->setUserId($username); 
  $this->Edublog->checkPermissions($vclassroom_id, $webquest_id, 'Webquest', $this->Auth->user('id')); # set permissions
  $data   = $this->Webquest->find('first', array('conditions' => array('Webquest.status'=>1, 'Webquest.id'=>$webquest_id)));
  $this->set('data', $data);
 }

/**
 * Save student answer
 * @access public
 * @return void
 */
 public function result()
 { 
  if ( !empty($this->request->data['ResultWebquest']) ) :
      $this->request->data['ResultWebquest'] = Sanitize::clean($this->request->data['ResultWebquest']); 
      $this->request->data['ResultWebquest']['user_id'] = (int) $this->Auth->user('id');
      if ($this->Webquest->ResultWebquest->save($this->request->data)):
          $this->msgFlash(__('Data saved'), 
                             '/vclassrooms/show/'.$this->request->data['ResultWebquest']['blogger'].'/'.$this->request->data['ResultWebquest']['vclassroom_id']);
          # Send email teacher(s) section STARTS
          $teachers = $this->Webquest->User->getTeachers($this->request->data['ResultWebquest']['vclassroom_id']);
          $title = $this->Webquest->field('title', array('Webquest.id'=>$this->request->data['ResultWebquest']['webquest_id']));
          # Send email to teacher
          $sendArray = array(
                        'subject' => __('Webquest filling answered'),
                        'message' => __('Student').' '.$this->Auth->user('username').' '.__('has answered the kandie'). ': '.$title);
          $this->Mailer->sendMany($sendArray, $teachers);
          # Send email teacher(s) section  ENDS
	  endif;
  endif;
 }

/**== ADMIN METHODS ==**/
/**
 * Points
 * @param string $username
 * @param integer $webquest_id
 * @access public
 * @return void
 */
 public function admin_points($resultwebquest_id, $sense)
 {
  $points = (int) $this->Webquest->ResultWebquest->field('points', array('ResultWebquest.id'=>$resultwebquest_id));
   
  $points = ($sense == 'up' ) ? ($points + 1) : ($points - 1);
  
  $this->Webquest->ResultWebquest->id = (int) $resultwebquest_id;    
  
  if ($this->Webquest->ResultWebquest->saveField('points', $points)):
      $this->set('points', $points);
      $this->render('admin_points', 'ajax');
  endif;
 }

/**
 * Display Webquest
 * @access public
 * @return void
 */
 public function admin_listing()
 {    
   $this->layout = 'admin';
      
   $params = array(
                    'conditions' => array('Webquest.user_id'=>$this->Auth->user('id')),
                    'fields'     => array('Webquest.id', 'Webquest.title', 'Webquest.status', 'Webquest.points'),
                    'order'      => 'Webquest.id DESC',
                    'limit'      => 12
                  );
   $this->set('data', $this->Webquest->find('all', $params));
 }
 
/**
 * Points
 * @access public
 * @return void
 */
 public function admin_start()
 {
  $this->layout = 'ajax';  
  $this->render('admin_start', 'ajax');
 }
 
/**
 * Points
 * @access public
 * @return void
 */
 public function admin_add()
 { 
  $this->layout    = 'admin';   
  if ( !empty($this->request->data['Webquest']) ):
      $this->request->data['Webquest']['user_id'] = (int) $this->Auth->user('id');
      if ($this->Webquest->save($this->request->data)):
          $this->msgFlash(__('Data saved'), '/admin/webquests/edit/'.$this->Webquest->getLastInsertID());
      endif;
 endif;
 }
 
/**
 * Get teacher's Webquests
 * @param integer $vclassroom_id
 * @access public
 * @return void
 */
 public function admin_getWq($vclassroom_id)
 {      
   $this->layout = 'ajax';
   return $this->Webquest->getWebQuests($this->Auth->user('id'), $vclassroom_id);
 } 

/**
 * Points
 * @param string $section
 * @param integer $webquest_id
 * @access public
 * @return void
 */ 
 public function admin_get($section=Null, $webquest_id=Null)
 {
  $this->layout = 'ajax';
    
  if ( !empty($this->request->data['Webquest']) ) :
      $this->set('section', $this->request->data['Webquest']['section']);
      $this->set('id', $this->request->data['Webquest']['id']);
      $this->set('field', $this->Webquest->field($section, array('Webquest.id'=>$this->request->data['Webquest']['id'])));
      if ($this->Webquest->save($this->request->data)):
          # Show something  # really?
      endif;
  else:
      $this->set('section', $section);
      $this->set('id', $webquest_id);
      if ($section != 'title'):
          $this->set('field', $this->Webquest->field($section, array('Webquest.id'=>$webquest_id)));
      else:
          $this->request->data = $this->Webquest->read(Null, $webquest_id);
      endif;
  endif;
  $this->render('admin_get', 'ajax');
 }

/**
 * see webquest with student results
 * Used in student record
 * @param integer $student_id
 * @param integer $webquest_id
 * @access public
 * @return void
 */
 public function admin_see($student_id, $webquest_id)
 { 
   $this->layout = 'popup'; 
   $this->set('data', $this->Webquest->getQuest($student_id, $webquest_id));
 }

/**
 * Let teacher see full webquest 
 * @param integer $webquest_id
 * @access public
 * @return void
 */
 public function admin_view($webquest_id)
 { 
   $this->layout = 'popup';
   $params = array('conditions' => array('Webquest.id'=>$webquest_id, 'Webquest.user_id'=>$this->Auth->user('id')),
                   'fields'     => array('Webquest.title', 'Webquest.introduction', 'Webquest.roles', 'Webquest.tasks', 'Webquest.process', 'Webquest.evaluation', 
                                         'Webquest.conclusion', 'Webquest.points'),
                   'contain'    => False);
   $this->set('data', $this->Webquest->find('first', $params));
 }

/**
 * Let teacher see full webquest 
 * @param integer $webquest_id
 * @access public
 * @return void
 */
 public function admin_edit($webquest_id=null)
 { 
   $this->layout    = 'admin';
   if ( !empty($this->request->data['Webquest']) ):
        if ($this->Webquest->save($this->request->data)):
            $this->msgFlash(__('Data saved'), '/admin/webquests/edit/'.$this->request->data['Webquest']['id']);
        endif;
  else:   
        $this->set('wq_title', $this->Webquest->field('title', array('Webquest.id'=>$webquest_id)));
        $this->set('id', $webquest_id);
  endif;
 }
 
/**
 * Save / Update webquest 
 * @access public
 * @return void
 */
 public function admin_save()
 {    
   $this->layout    = 'ajax';
      
   if ( !empty($this->request->data['Webquest']) ):
         if ($this->Webquest->save($this->request->data)):
            $this->set('section', $this->request->data['Webquest']['section']);
            $this->set('id', $this->request->data['Webquest']['id']);
            
            $this->set('field', $this->Webquest->field($section, array('Webquest.id'=>$this->request->data['Webquest']['id'])));        
            $this->render('admin_get', 'ajax');
         endif;
  endif;
 }
 
/**
 * Change webquest status published/draft
 * @param integer $webquest_id
 * @param integer $status
 * @access public
 * @return void
 */
 public function admin_change($webquest_id, $status)
 {  
  $new_status = ($status == 0 ) ? 1 : 0;
     
  $this->Webquest->id     = (int) $webquest_id;
     
  if ($this->Webquest->saveField('status', $new_status)):
      $this->msgFlash(__('Status modified'), '/admin/webquests/listing');
  endif;
 } 

/**
 * Select classroom to link
 * @param integer $webquest_id
 * @access public
 * @return void
 */
 public function admin_vclassrooms($webquest_id)
 {    
  $this->layout = 'admin';
  $this->set('webq', $this->Webquest->find('first', array('contain'=>False, 'conditions'=>array('Webquest.id'=>$webquest_id), 'fields'=>array('id', 'title'))));
  $params = array(
                   'conditions' => array('Vclassroom.user_id'=>$this->Auth->user('id'), 'Vclassroom.status'=>1)
                  );

   $this->set('data', $this->Webquest->Vclassroom->find('all', $params));
   $params = array(
                   'conditions'=>array('VclassroomWebquest.webquest_id' => $webquest_id)
                  );
   $this->set('webquests',$this->Webquest->VclassroomWebquest->find('all', $params));
 }

/**
 * Link to class
 * @access public
 * @return void
 */
 public function admin_link2class() 
 {
  $this->layout    = 'admin';
  if ( !empty($this->request->data['VclassroomWebquest']) ):
      $this->request->data['VclassroomWebquest'] = Sanitize::clean($this->request->data['VclassroomWebquest']);
      if ( $this->Webquest->VclassroomWebquest->save($this->request->data)):
          if ( isset( $this->request->data['VclassroomWebquest']['popup']) ):
              $return = '/admin/vclassrooms/dide/'.$this->request->data['VclassroomWebquest']['vclassroom_id'];
          else:
              $return = '/admin/webquests/vclassrooms/'.$this->request->data['VclassroomWebquest']['webquest_id'];
          endif;
          $this->msgFlash(__('Webquest assigned'), $return);
      endif;
  endif;
 }

/**
 * Link to class
 * @access public
 * @return void
 */
 public function admin_unlink2class() 
 {
   $this->layout    = 'admin';
   if ( !empty($this->request->data['VclassroomWebquest']) ):
       $this->request->data['VclassroomWebquest'] = Sanitize::clean($this->request->data['VclassroomWebquest']);
       if ( $this->Webquest->VclassroomWebquest->delete($this->request->data['VclassroomWebquest']['id'])):
           if (isset($this->request->data['VclassroomWebquest']['popup'])):
               $return =  '/admin/vclassrooms/dide/'.$this->request->data['VclassroomWebquest']['vclassroom_id'];
           else:
               $return =  '/admin/webquests/vclassrooms/'.$this->request->data['VclassroomWebquest']['webquest_id'];
           endif;
           $this->msgFlash(__('Kandie unlinked'), $return);
       endif;
   endif;
 }

/**
 * Remove webquest
 * @param integer $webquest_id
 * @access public
 * @return void
 */
 public function admin_delete($webquest_id)
 {
   if ($this->Webquest->delete($webquest_id)):
       $this->msgFlash(__('Data removed'), '/admin/webquests/listing/');
   endif;
 }

/**
 * Wizard beggins
 * @param mixed $step
 * @access public
 * @return void
 */
 public function admin_wizard($step = null) 
 {
   if ($step =='admin_wzdone'):
       $this->set('subjects', Set::combine($this->Webquest->Subject->find('all', array('order' => 'title')), 
                      "{n}.Subject.id","{n}.Subject.title"));
       $this->set('langs', Set::combine($this->Webquest->Lang->find('all', array('order' => 'lang')), "{n}.Lang.id","{n}.Lang.lang"));
   endif;
  
   $this->layout = 'admin'; 
   $this->Wizard->process($step);
 } 

/**
 * [Wizard Process Callbacks]
 * @param integer $webquest_id
 * @access public
 * @return void
 */
 public function processAdminWzdone() 
 {
  $this->Webquest->set($this->request->data);
  return True;
 }

/**
 * Wizard Step Two
 * @access public
 * @return boolean
 */
 public function processAdminWzdtwo() 
 {
  $this->Webquest->set($this->request->data);
  return True;
 }

/**
 * Wizard Step Three
 * @access public
 * @return boolean
 */
 public function processAdminWzdthree() 
 {
  $this->Webquest->set($this->request->data);
  return True;
 }

/**
 * Finish Wizard
 * @access public
 * @return void
 */
 public function admin_finish() 
 {
  $this->layout = 'admin';
  $ecourse_id   = (int) $this->Session->read('Webquest.id');
  $this->set('ecourse_id', $ecourse_id);
 }

/**
 * Edit linked Kandie
 * @access public
 * @return void
 */
 public function admin_ekandie() 
 {
   $this->layout = 'ajax';
   $this->request->data = $this->Webquest->VclassroomWebquest->read(Null, $this->request->data['VclassroomWebquest']['id']);
   $this->render('admin_ekandie', 'ajax');
 }

/**
 * Update linked Kandie
 * @param integer $webquest_id
 * @access public
 * @return void
 */
 public function admin_update() 
 {
   $this->layout = 'ajax';
   if ( $this->Webquest->VclassroomWebquest->save($this->request->data) ):
      $msg = __('Data updated');
  else:
      $msg = __('Data NOT updated');
  endif; 
  $this->msgFlash($msg, '/admin/vclassrooms/dide/'.$this->request->data['VclassroomWebquest']['vclassroom_id']);
 }
}
# ? > EOF
