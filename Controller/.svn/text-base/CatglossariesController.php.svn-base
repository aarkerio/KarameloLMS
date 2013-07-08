<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package glossary
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : APP/Controller/CatglossariesController.php

App::uses('Sanitize', 'Utility');

class CatglossariesController extends AppController {

/*
 *  Cake Helpers
 *  @var array
 *  @access public
 */ 
 public $helpers          = array('User');
 
/*
 *  Cake Components
 *  @var array
 *  @access public
 */ 
 public $components       = array('Edublog');

/**
 *  Auth Component permisssions
 *  @access public
 *  @return void 
 */ 
 public function beforeFilter() 
 {
    parent::beforeFilter();
    $this->Auth->allow(array('display', 'view'));
 }
 
/**
 *  Show all 
 *  @access public
 *  @return void 
 */ 
 public function display($username)
 {
  $this->Edublog->setUserId($username); # blogger elements
  $conditions = array('Catglossary.user_id'=>$this->Edublog->userId, 'Catglossary.status'=>1);
  if ( !$this->Auth->user() || !$this->Edublog->generalBelongs($this->Auth->user('id'))):
       $conditions['Catglossary.public'] = 1;
  endif;

  $params = array('conditions' => $conditions,
                  'fields'     => array('Catglossary.id', 'Catglossary.title', 'Catglossary.description'),
                  'order'      => 'Catglossary.title DESC',
                  'contain'    => False);
  $this->set('data', $this->Catglossary->find('all', $params));
 }
 
/**
 *  Show one glossary
 *  @param string  $username
 *  @param integer $catglossary_id
 *  @access public
 *  @return void 
 */  
 public function view($username, $catglossary_id)
 {
  $this->Edublog->setUserId($username); # blogger elements   
  $this->Catglossary->contain('Glossary.status = 1');
  $conditions = array('Catglossary.user_id'=>$this->Edublog->userId, 'Catglossary.status'=>1, 'Catglossary.id'=>$catglossary_id);
  if ( !$this->Auth->user() || !$this->Edublog->generalBelongs($this->Auth->user('id'))):
      $conditions['Catglossary.public'] = 1;
  endif;
  if ( $this->Auth->user() && $this->Auth->user('id') ==  $this->Edublog->userId): # user is owner
      $conditions = array('Catglossary.id'=>$catglossary_id);
  endif;

  $params= array(
        'conditions'=> $conditions,
        'fields'    => array('Catglossary.id', 'Catglossary.title', 'Catglossary.description','Catglossary.created', 'Catglossary.status')
                );
  $data =  $this->Catglossary->find('first', $params);
  if ( !$data ):
      $this->msgFlash(__('Resource is not public'), '/blog/'.$username);
  endif;
  $this->set('data', $data);
 }
 
/*** ===== ADMIN METHODS ===== ***/
/**
 *  List glossaries
 *  @access public
 *  @return void 
 */ 
 public function admin_listing()
 {      
  $this->layout    = 'admin';
  $params= array(
     'conditions' => array('Catglossary.user_id' => $this->Auth->user('id')),
     'fields'     => array('Catglossary.id', 'Catglossary.title','Catglossary.description','Catglossary.created','Catglossary.public','Catglossary.status'),
     'order'      => 'Catglossary.title');
  $this->set('data', $this->Catglossary->find('all', $params));
 }

/**
 *  Auth Component permisssions
 *  @access public
 *  @return void 
 */  
 public function admin_items($catglossary_id)
 {
   $this->layout    = 'admin';
   $params = array('conditions' => array('Catglossary.user_id' => $this->Auth->user('id'), 'Catglossary.id' => $catglossary_id),
                   'fields'     => array('Catglossary.id', 'Catglossary.title', 'Catglossary.user_id','Catglossary.user_id','User.id','User.username')
                  );
   $this->set('data', $this->Catglossary->find('first', $params));
 }
 
/**
 *  Auth Component permisssions
 *  @access public
 *  @return void 
 */ 
 public function admin_edit($catglossary_id=null)
 {
  $this->layout    = 'admin';

  if ( !empty( $this->request->data['Catglossary'] ) ):
      if ( !isset($this->request->data['Catglossary']['id']) ): # new record
          $this->request->data['Catglossary']['user_id'] = (int) $this->Auth->user('id');
      endif;
      #die(debug($this->request->data));
      if ($this->Catglossary->save($this->request->data)):  
          $msg = __('Data saved');
          if ($this->request->data['Catglossary']['end'] == 0 && !isset($this->request->data['Catglossary']['id'])):
              $id = $this->Catglossary->getLastInsertID();
              $return = '/admin/catglossaries/edit/'.$id;
          elseif ($this->request->data['Catglossary']['end'] == 0 && isset($this->request->data['Catglossary']['id'])):
              $return = '/admin/catglossaries/edit/'.$this->request->data['Catglossary']['id'];
          elseif ($this->request->data['Catglossary']['end'] == 1 ):
              $return = '/admin/catglossaries/listing';    
          endif; 
          $this->msgFlash($msg, $return);
      endif;
  elseif($catglossary_id != Null && intval($catglossary_id)):
      $this->Catglossary->contain(False);
      $this->data  = $this->Catglossary->findById($catglossary_id);
  endif;
 }
 

/**
 *  Change status published/draft
 *  @access public
 *  @return void 
 */ 
 public function admin_change($status, $catglossary_id)
 {  
  if ( !is_numeric($status)  ||  !intval($catglossary_id) ): 
      $this->redirect('/');
      return False;
  endif;  
  $new_status = ($status == 0 ) ? 1 : 0;
  $this->Catglossary->id = (int) $catglossary_id;
  if ($this->Catglossary->saveField('status', $new_status)):
      $this->msgFlash(__('Status modified'), '/admin/catglossaries/listing');
  endif;
 }
 
/**
 *  Change file status public/non public
 *  @access public
 *  @return void 
 */ 
 public function admin_public($catfaq_id, $public)
 {  
  $new_status = ($public == 0 ) ? 1 : 0;    
  $this->Catglossary->id = (int) $catfaq_id;
  if ($this->Catglossary->saveField('public', $new_status)):
      $msg = __('Data modified');
  else:
      $msg = __('Data NOT modified');
  endif; 
  $this->msgFlash($msg, '/admin/catglossaries/listing');
 }

/**
 *  Remove glossary and items
 *  @access public
 *  @return void 
 */ 
 public function admin_delete($catglossary_id)
 {
  if ($this->Catglossary->delete($catglossary_id)):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/catglossaries/listing');
 }
}
# ? > EOF
