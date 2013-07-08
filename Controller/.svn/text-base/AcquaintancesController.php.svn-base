<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package blog
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Controller/AcquaitancesController.php

/**
 *  Include files
 */
App::uses('Sanitize', 'Utility');

class AcquaintancesController extends AppController {

/**
 *  CakePHP Helpers
 *  @var array
 *  @access public
 */  
 public $helpers      = array('User', 'Ck');

/**
 *  Cake Helpers
 *  @var array
 *  @access public
 */  
 public $paginate      = Null;

/**
 *  Cake Components
 *  @var array
 *  @access public
 */ 
 public $components   = array('Edublog', 'RequestHandler');

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */ 
 public function beforeFilter() 
 {
    parent::beforeFilter();
    $this->Auth->allow(array('display', 'blogElement')); 
 }
 
/**
 *  charge element in edublog 
 *  @access public
 *  @return boolean
 */
 public function blogElement($user_id) 
 {
  $params = array('conditions' => array('Acquaintance.user_id'=>$user_id),
                  'fields'     => array('Acquaintance.name', 'Acquaintance.url'),
                  'order'      => 'Acquaintance.id DESC',
                  'limit'      => 10,
                  'contain'    => False);
  return $this->Acquaintance->find('all', $params);
  }

/**
 *  Display in edublog
 *  @access public
 *  @return void
 */
 public function display($username)
 {
  $this->Edublog->setUserId($username);
  $params = array('conditions' => array('Acquaintance.user_id'=> $this->Edublog->userId));
  $this->set('data', $this->Acquaintance->find('all', $params));
 }

/** === ADMIN METHODS === ***/
/**
 * Manage in backend
 * @access public
 * @return void
 */
 public function admin_listing()
 {
  if ( $this->RequestHandler->isAjax() ):
      $this->layout = 'ajax';
      $show = False;
  else:
      $this->layout = 'admin';
      $show = True;
  endif;

  $data = $this->__setData($show);

  if ($this->Session->check('CommentErrors')): 
        # Get session vars from admin_add()
	    $this->Acquaintance->validationErrors = $this->Session->read('CommentErrors');
	    $this->request->data= $this->Session->read('Values'); 
	    #Delete session vars
	    $this->Session->delete('CommentErrors'); 
	    $this->Session->delete('Values'); 
	    $this->set('show', $show);
  endif; 
 }

/**
 *  Set data for paginaton
 *  @access private
 *  @param boolean $show 
 *  @return void
 */
 private function __setData($show=True)
 { 
  $this->paginate['Acquaintance'] = array('conditions' => array('Acquaintance.user_id' => $this->Auth->user('id')),
                  'fields'       => array('Acquaintance.id', 'Acquaintance.url', 'Acquaintance.name'),
                  'order'        => 'Acquaintance.name',
                  'limit'        => 20);
  $data = $this->paginate('Acquaintance');
  $this->set(compact('data'));
  $this->set('show', $show);
}

/**
 *  Add/Edit method
 *  @access public
 *  @param mixed integer $acquaintance_id or False
 *  @return void
 */
 public function admin_edit($acquaintance_id=False)
 {
  $this->layout = 'ajax';

  if ( !empty($this->request->data['Acquaintance']) ):
      $this->request->data['Acquaintance']['user_id'] = (int) $this->Auth->user('id');
      if ($this->Acquaintance->save($this->request->data)):
          $this->Session->setFlash(__('Data saved'));
          $this->__setData(False);
          $this->render('admin_listing');
      endif;
  elseif($acquaintance_id !=False and intval($acquaintance_id)):
      $this->Acquaintance->id = $acquaintance_id;
      $this->request->data = $this->Acquaintance->read();
  endif;
 }
 
/**
 *  Remove acquaintance
 *  @access public
 *  @param mixed integer $acquaintance_id
 *  @return void
 */
 public function admin_delete($acquaintance_id)
 {
  if ($this->Acquaintance->delete($acquaintance_id)):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->Session->setFlash($msg);
  $this->__setData(False);
  $this->render('admin_listing');
 }
}

# ? > EOF
