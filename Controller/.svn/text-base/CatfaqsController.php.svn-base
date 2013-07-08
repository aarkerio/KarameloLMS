<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package faqs
*  @license http://www.gnu.org/licenses/agpl.html
*/
#File: /APP/Controller/CatfaqsController.php 

/**
 * Load libraries
 */
App::uses('Sanitize', 'Utility');

class CatfaqsController extends AppController{
 
/**
 *  Load CakePHP helpers
 *  @access public
 *  @var array
 */ 
 public $helpers  = array('User');
 
/**
 *  Load CakePHP Components
 *  @access public
 *  @var array 
 */ 
 public $components = array('Edublog');

/**
 *  Auth Component permisssions
 *  @access public
 *  @return void 
 */ 
 public function beforeFilter() 
 {
    parent::beforeFilter();
    $this->Auth->allow(array('display', 'view', 'blogElement'));
 }

/**
 *  Load element in edublog 
 *  @access public
 *  @return void 
 */
 public function blogElement($user_id) 
 {
  $conditions      = array('Catfaq.user_id'=>$user_id, 'Catfaq.status'=>1);    
  if ( !$this->Auth->user() || !$this->Edublog->generalBelongs($this->Auth->user('id'))):
      $conditions['Catfaq.public'] = 1;
  endif;
  $params = array('conditions' => $conditions,
                  'fields'     => array('Catfaq.id', 'Catfaq.title'),
                  'order'      => 'Catfaq.title DESC',
                  'limit'      => 10,
                 'contain'     => False);
  return $this->Catfaq->find('all', $params); 
 }

/**
 *  View one catfaq
 *  @access public
 *  @return void 
 */
 public function view($username, $catfaq_id)
 {
  $conditions = array('Catfaq.id'=>$catfaq_id, 'Catfaq.status'=>1);
  if ( !$this->Auth->user() || !$this->Edublog->generalBelongs($this->Auth->user('id'))):
       $conditions['Catfaq.public'] = 1;
  endif;
  $this->Edublog->setUserId($username);
  if ( $this->Auth->user() && $this->Auth->user('id') ==  $this->Edublog->userId): # user is owner
      $conditions = array('Catfaq.id'=>$catfaq_id);
  endif;
 
  $params = array('conditions'=>$conditions);
  $data   = $this->Catfaq->find('first', $params);
  if ( !$data ):
      $this->msgFlash(__('Resource is not public'), '/blog/'.$username);
  endif;
  $this->set('data', $data);
 }
 
/**
 *  Show all published catfaqs
 *  @access public
 *  @return void 
 */
 public function display($username) 
 {
   $this->Edublog->setUserId($username);
   $conditions      = array('Catfaq.user_id'=>$this->Edublog->userId, 'Catfaq.status'=>1);    
   if ( !$this->Auth->user() || !$this->Edublog->generalBelongs($this->Auth->user('id'))):
       $conditions['Catfaq.public'] = 1;
   endif;
   $params = array('conditions' => $conditions);
   $this->set('data', $this->Catfaq->find('all', $params));
  }
 
 /***  ===== ADMIM METHODS ===== ***/
/**
 *  List all teacher Catfaqs
 *  @access public
 *  @return void 
 */
 public function admin_listing()
 {
  $this->layout = 'admin';
  $params = array('conditions' => array('Catfaq.user_id'=>$this->Auth->user('id')),
                  'fields'     => array('Catfaq.id', 'Catfaq.title', 'Catfaq.created', 'Catfaq.status', 'Catfaq.public', 'Catfaq.description'),
                  'order'      => 'Catfaq.title',
                  'contain'    => False);
  $this->set('data', $this->Catfaq->find('all', $params)); 
 }

/**
 *  Edit Ajax call
 *  @access public
 *  @return void 
 */
 public function admin_start()
 {
   $this->layout = 'ajax';
   $this->set('add');
   $this->render('admin_edit');
 }

/**
 *  Edit catfaq
 *  @access public
 *  @return void 
 *  @param integer $catfaq_id
 */
 public function admin_edit($catfaq_id = null)
 {  
    $this->layout = 'admin';
    #die(debug($this->request->data['Catfaq']));
    if (empty($this->request->data['Catfaq'])):
        $this->request->data = $this->Catfaq->findById($catfaq_id);
    else:
        if ( !isset($this->request->data['Catfaq']['id']) ):
            $this->request->data['Catfaq']['user_id'] = (int) $this->Auth->user('id');
        endif;
        if ($this->Catfaq->save($this->request->data)):
            if ( !isset($this->request->data['Catfaq']['id']) && $this->request->data['Catfaq']['end'] == 0 ):
                $id = $this->Catfaq->getLastInsertID();
                $url = '/admin/catfaqs/edit/'.$id;              
            elseif ( isset($this->request->data['Catfaq']['id'])  && $this->request->data['Catfaq']['end'] == 0 ):
                $url = '/admin/catfaqs/edit/'.$this->request->data['Catfaq']['id']; 
            elseif ( $this->request->data['Catfaq']['end'] == 1):
                $url = '/admin/catfaqs/listing/';
            endif;
            $this->msgFlash(__('Data saved'), $url);
        endif;
    endif;
 }

/**
 *  Change status published/draft
 * @access public
 * @retun void
 */
 public function admin_change($status, $catfaq_id)
 { 
  $new_status       = ($status == 0 ) ? 1 : 0;
  $this->Catfaq->id = (int) $catfaq_id;

  if ($this->Catfaq->saveField('status', $new_status)):
      $this->msgFlash(__('Status modified'), '/admin/catfaqs/listing');
  endif;
 }

/**
 *  Change file status public/non public
 *  @access public
 *  @retun void
 *  @param integer $catfaq_id
 *  @param integer $public
 */
 public function admin_public($catfaq_id, $public)
 {  
   $new_status = ($public == 0 ) ? 1 : 0;    
   $this->Catfaq->id = (int) $catfaq_id;
   if ($this->Catfaq->saveField('public', $new_status)):
       $this->msgFlash(__('Data modified'), '/admin/catfaqs/listing');
   endif;
 }

/**
 * Remove Catfaq
 * @access public
 * @retun void
 * @param integer $catfaq_id
 */
 public function admin_delete($catfaq_id)
 {
  if ($this->Catfaq->delete($catfaq_id)):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/catfaqs/listing/');
 }
}
# ? > EOF
