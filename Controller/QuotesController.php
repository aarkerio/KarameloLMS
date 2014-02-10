<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package quotes
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: app/Controller/QuotesController.php

/**
 *  Load libraries
 */
App::uses('Sanitize', 'Utility');

class QuotesController extends AppController {
 
/**
 * Load cakephp helpers
 * @access public
 * @var array
 */   
 public $helpers    = array('Paginator');

/**
 * Auth CakePHP setup
 * @access public
 * @return void 
 */ 
 public function beforeFilter() 
 {
   parent::beforeFilter();
   $this->Auth->allow(array('getOne'));
 }

/**
 * Get one, used in quote.ctp element
 * @access public
 * @return void 
 */ 
 public function getOne($user_id)
 {
  $dbkind     = $this->getDbKind(); # Mysql or Postgresql
  $order      = $dbkind == 'PGSQL' ?  'RANDOM()': 'RAND()'; #MySQL
  $params = array('conditions' => array('Quote.user_id'=>$user_id),
                  'fields'     => array('Quote.quote', 'Quote.author'));
  return $this->Quote->find('first', $params);
 }

/* === ADMIN METHODS === */

/**
 * Display in admin
 * @access public
 * @return void 
 */ 
 public function admin_add() 
 {
  if (!empty($this->request->data) ):
      $this->request->data['Quote']['user_id'] = (int) $this->Auth->user('id');
      #die(debug($this->request->data));         
      if ( $this->Quote->save($this->request->data)):
          $this->msgFlash(__('Data saved'), '/admin/quotes/listing');
          return True;
      else:
	      $this->Session->write('CommentErrors', $this->Quote->validationErrors); 
	      $this->Session->write('Values', $this->request->data); 
          $this->msgFlash(__('Error saving!'), '/admin/quotes/listing');
          return False;
      endif;
  endif;
 }

/**
 * Display in admin
 * @access public
 * @return void 
 */ 
 public function admin_listing()
 {
  if ( !$this->RequestHandler->isAjax() ):
      $this->layout    = 'admin';
  else:
      $this->set('ajaxTrue');
  endif;
        
  # Show error messages if save forms sent
  if ($this->Session->check('CommentErrors')): 
       # Get session vars from admin_add()
	   $this->Quote->validationErrors = $this->Session->read('CommentErrors');
	   $this->request->data= $this->Session->read('Values'); 
   	   #Delete session vars
	   $this->Session->delete('CommentErrors'); 
	   $this->Session->delete('Values'); 
	   $this->set('show', True); 
  endif; 
   
  $this->paginate = array('conditions' => array('user_id'=>$this->Auth->user('id')),
                          'order'      => 'author',
                          'fields'     => array('quote', 'author', 'id'),
                          'limit'      => 30
                         );
  $data = $this->paginate('Quote');
  $this->set(compact('data'));
 }
  
/**
 * Edit qoute
 * @access public
 * @return void 
 */  
 public function admin_edit($quote_id=Null)
 {
  if (empty($this->request->data['Quote'])):
      $this->layout     = 'admin';        
      $this->request->data       = $this->Quote->read(null, $quote_id);
  else:
      $this->request->data['Quote'] = Sanitize::clean($this->request->data['Quote']);
      if ($this->Quote->save($this->request->data)):
            $this->msgFlash(__('Data saved'), '/admin/quotes/listing');
	  else:
	      $this->Session->write('CommentErrors', $this->Quote->validationErrors); 
          $this->Session->write('Values', $this->request->data); 
          $this->msgFlash(__('Error saving!'), '/admin/quotes/listing');
      endif;
  endif;
 }

/**s
 * Remove quote
 * @access public
 * @return void
 */

 public function admin_delete($quote_id)
 {
  if ($this->Quote->delete($quote_id)):
      $msg = __('Data removed');
      $success = True;
  else:
      $msg = __('Data NOT removed');
      $success = False;
  endif;
  $this->msgFlash($msg,'/admin/quotes/listing');
  return $success;
 }
}

# ? > EOF
