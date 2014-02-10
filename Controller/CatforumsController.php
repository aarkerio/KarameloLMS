<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package forums
*  @license http://www.gnu.org/licenses/agpl.html
*/
#File: /APP/Controller/CatforumsController.php 

/**
 *  Include files
 */ 
App::uses('Sanitize', 'Utility');

class CatforumsController extends AppController {

/**
 *  Cake Helpers
 *  @var array
 *  @access public
 */
 public $helpers       = array( 'Time');

/**
 *  Cake Components
 *  @var array
 *  @access public
 */
 public $components    = array('Edublog');

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */ 
 public function beforeFilter() 
 {
   parent::beforeFilter();
 }
 
 /****======= ADMIN METHODS   ====******/
/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */ 
 public function admin_listing()
 {
  $this->layout = 'admin';
  $params = array('conditions' => array('Catforum.user_id'=>$this->Auth->user('id')),
                  'fields'     => array('Catforum.id', 'Catforum.title', 'Catforum.description','Catforum.created'),
                  'order'      => 'Catforum.id ASC'
                 );
  $this->set('data', $this->Catforum->find('all',$params)); 

  # Show error messages 
  if ($this->Session->check('CommentErrors')): 
      # Get session vars from admin_add() 
	  $this->Catforum->validationErrors = $this->Session->read('CommentErrors');
	  $this->request->data= $this->Session->read('Values'); 
      # Delete session vars
	  $this->Session->delete('CommentErrors');  
	  $this->Session->delete('Values');  
	  $this->set('show', true); 
  endif; 
 }
 
/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */ 
 public function admin_add() 
 {
  $this->layout = 'admin';
  if (!empty($this->request->data['Catforum'])):
      $this->request->data['Catforum'] = Sanitize::clean($this->request->data['Catforum']);
      $this->request->data['Catforum']['user_id'] = $this->Auth->user('id');
      if ($this->Catforum->save($this->request->data)):
          $this->msgFlash(__('Data saved'), '/admin/catforums/listing');
      else:
		  # Save error messages from model in Session vars! 
		  $this->Session->write('CommentErrors', $this->Catforum->validationErrors);  
		  $this->Session->write('Values', $this->request->data);  
		  $this->redirect('/admin/catforums/listing'); 
      endif;
  endif;
 }
 
/**
 *  Edit forum category
 *  @access public
 *  @return void 
 */ 
 public function admin_edit($catforum_id = null) 
 {
   $this->layout = 'admin';

   if ( empty($this->request->data['Catforum']) ):
       $this->request->data = $this->Catforum->read(Null, $catforum_id);
   else:
       $this->request->data['Catforum'] = Sanitize::clean($this->request->data['Catforum']);
       if ($this->Catforum->save($this->request->data)):
           $this->msgFlash(__('Data saved'), '/admin/catforums/listing');
       endif;
   endif;
 }
 
/**
 *  Remove category
 *  @access public
 *  @return void 
 */ 
 public function admin_delete($catforum_id)
 {
  if ( $this->Catforum->delete($catforum_id) ):           
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/catforums/listing');
 }
}
# ? > EOF
