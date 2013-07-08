<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package collections (books & media)
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Controller/CollectionsController.php

/**
 * Include files
 */
App::uses('Sanitize', 'Utility');

class CollectionsController extends AppController {

/**
 * Cake helpers
 * @access public
 * @var array 
 */ 
 public $helpers          = array('Ck');

/**
 *  CakePHP Paginate
 *  @var array
 *  @access public
 */ 
  public $paginate = array();

/**
 * Cake components
 * @access public
 * @var array 
 */ 
 public $components       = array('Edublog');

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */ 
 public function beforeFilter() 
 {
  parent::beforeFilter();
  $this->Auth->allow(array('index', 'view', 'display', 'search'));
 }

/**
 * Display collection in portal
 * @access public
 * @return void
 */ 
 public function index()
 {
   $this->set('types',Set::combine($this->Collection->Type->find('all',array('order'=>'type')),"{n}.Type.id","{n}.Type.type"));
   $this->layout    = 'portal';
   $this->paginate['Collection']  = array(
                    'conditions' => array('Collection.status'=>1),
                    'order'      => 'Collection.title', 
                    'limit'      => 30
                    );
  $data = $this->paginate('Collection'); 
  $this->set(compact('data'));
 }

/**
 * Search in collection
 * @access public
 * @return void
 */
 public function search() 
 {
  $this->layout    = 'portal';
  $terms = Sanitize::escape($this->request->data['Collection']['terms']); 
  $this->set('data', $this->Collection->search($terms));
 }

/**
 * 
 * @access public
 * @return void
 */ 

 public function view($media_id)
 {
  $this->layout    = 'portal';
  $params = array('conditions'=>array('Collection.id'=>$media_id));
  $this->set('data', $this->Collection->find('all', $params)); 
 }


/**
 * Display category
 * @access public
 * @return void
 */ 
 public function display($category_id)
 {
   $params = array('conditions'=>array('Collection.id'=>$category_id));
   $this->set('data', $this->Collection->find('all', $params)); 
 }

/** ==ADMIN METHODS ==**/

/**
 * Display collection in backend
 * @access public
 * @return void
 */ 
 public function admin_listing() 
 {
  $this->layout = 'admin';
  $this->paginate['Collection'] = array(
                                  'order'   => 'Collection.id DESC',
                                  'fields'  => array('Collection.title','Collection.status','Collection.id','Collection.author','Collection.copies'),
                                  'limit'   => 40,
                                  'contain'  => array('Lending'=>array('fields'=>array('collection_id')))
                                	  );
  $data = $this->paginate('Collection');
  $this->set(compact('data'));
 }

/**
 * View lent
 * @access public
 * @return void
 */ 
 public function admin_record() 
 {
  $this->layout = 'admin';
  $params= array(
                 'fields'    => array('Lending.collection_id', 'Lending.status', 'Lending.fdate', 'Lending.sdate', 'Lending.id', 'Lending.user_id', 'Lending.collection_id', 'User.username', 'User.id','Collection.title', 'Collection.id'),
                 'order'     => 'Lending.id DESC',
                );
  $this->set('data', $this->Collection->Lending->find('all', $params));
 }

/**
 * Add lent
 * @access public
 * @return void
 */ 
 public function admin_add($collection_id=Null) 
 {
  $this->layout = 'admin';
  if (!empty($this->request->data['Lending'])):
      #die(debug($this->request->data));
      $this->Collection->bindModel(array('belongsTo'=>array('User')));
      $user_id = $this->Collection->User->field('User.id', array('User.username'=>$this->request->data['Message']['sendername']));

      if ( !$user_id ):
          $this->flash(__('User does not exist'), '/admin/collections/listing');
          return False;
      endif;
      $this->request->data['Lending']['user_id'] = (int) $user_id;
      $this->Collection->Lending->save($this->request->data);
      $this->msgFlash(__('Data saved'), '/admin/collections/listing');
  else:
      $params= array('conditions' => array('Collection.id'=> $collection_id));
      $this->set('data', $this->Collection->find('first', $params));
  endif;
 }
 
/**
 * Change status
 * @access public
 * @param integer $media_id
 * @param integer $status
 * @return void
 */ 
 public function admin_change($media_id, $status)
 {
  $new_status     = ($status == 0 ) ? 1 : 0;
  $this->Collection->id = (int) $media_id;
  if ($this->Collection->saveField('status', $new_status)):
      $this->msgFlash(__('Status modified'), '/admin/collections/listing/');
  endif;
 }
     
/**
 *  ADD/EDIT MEDIA FILE  
 *  @access public
 *  @param mixed integer or null
 *  @return void
 */ 

 public function admin_edit($media_id = null)
 {
   $this->layout = 'admin';    

   $this->set('types',Set::combine($this->Collection->Type->find('all',array('order'=>'type')),"{n}.Type.id","{n}.Type.type"));
   $this->set('clasifications',Set::combine($this->Collection->Clasification->find('all',array('order'=>'name')),"{n}.Clasification.id","{n}.Clasification.name"));
     
   if (!empty($this->request->data['Collection'])):
       if ($this->Collection->save($this->request->data)):
	       if ($this->request->data['Collection']['end'] == 0 && !isset($this->request->data['Collection']['id'])):
                $id = $this->Collection->getLastInsertID();
                $return = '/admin/collections/edit/'.$id;    
           elseif ($this->request->data['Collection']['end'] == 0 && isset($this->request->data['Collection']['id'])):
                $return = '/admin/collections/edit/'.$this->request->data['Collection']['id'];
	       elseif ($this->request->data['Collection']['end'] == 1 ):
	            $return = '/admin/collections/listing';
	       endif;
           $this->msgFlash(__('Data saved'),$return);
	   endif;
   elseif($media_id != Null && intval($media_id)):
       $this->request->data = $this->Collection->read(Null, $media_id);
   endif;
 }

/**
 * DELETE  Remove item
 * @access public
 * @return void
 */ 
 public function admin_delete($collection_id)
 {  
  if ($this->Collection->delete($collection_id)):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/collections/listing');
 }
}
# ? > EOF
