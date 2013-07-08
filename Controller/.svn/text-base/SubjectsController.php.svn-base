<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package news
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : APP/Controller/SubjectsController.php

/*
 *  Import libraries
 */
App::uses('Sanitize', 'Utility');

class SubjectsController extends AppController {  

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */   
 public function beforeFilter() 
 {
    parent::beforeFilter();
    $this->Auth->allow(array('display', 'view','show', 'panda'));
 }

/**
 *  Disdplay subject (Ajax call)
 *  @access public
 *  @return void 
 */
 public function display()
 {  
  $this->layout    = 'ajax';
  $params = array('fields'  => array('Subject.id', 'Subject.title', 'Subject.code'),
                  'order'   => 'Subject.title',
                  'contain' => False);
  $this->set('data', $this->Subject->find('all', $params));
  $this->render('qs', 'ajax');    
 }

/**
 *  View
 *  @param string subject $code  
 *  @access public
 *  @return void 
 */
 public function view($code)
 {  
   $this->layout    = 'portal';
   $this->set('data', $this->Subject->getSubject($code));
 }

/**
 *  hehehehe!  'Eastern::egg Panda'
 *  @access public
 *  @return void 
 */
 public function panda()
 {
   return True;
 }
  
 /** ==== ADMIN METHODS ==== */
/**
 * 
 *  @access public
 *  @return void 
 */
 public function admin_listing()
 {
  $this->layout    = 'admin';
  $params = array('fields'  => array('id', 'title', 'code'),
                  'order'   => 'title ASC',
                  'contain' => False);
  $this->set('data', $this->Subject->find('all', $params));
 }
 
/**
 *  Add subject
 *  @access public
 *  @return void 
 */  
 public function admin_add()
 {
  $this->layout = 'admin';

  if (!empty($this->request->data['Subject'])):
      if ($this->Subject->save($this->request->data)):
          $this->msgFlash(__('Data saved'),'/admin/subjects/listing');
      endif;
  endif;
 }
 
/**
 *  Edit
 *  @param mixed null or integer
 *  @access public
 *  @return void 
 */ 
 public function admin_edit($subject_id = Null)
 { 
    $this->layout = 'admin';    
    if (empty($this->request->data['Subject'])):
        $this->request->data = $this->Subject->read(Null, $subject_id);
    else:
       if ($this->Subject->save($this->request->data)):
           $this->msgFlash(__('Data saved'), '/admin/subjects/listing');
       endif;
   endif;
 }
 
/**
 *  Delete subject
 *  @access public
 *  @return void 
 */
 public function admin_delete($subject_id)
 {
   if ( $this->Subject->delete($subject_id) ):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg,'/admin/subjects/listing');
 } 
}

# ? > EOF
