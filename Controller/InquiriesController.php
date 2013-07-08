<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package quizs
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: app/Controller/InquiriesController.php

App::uses('Sanitize', 'Utility');

class InquiriesController extends AppController {

/**
 *  CakePHP helpers
 *  @var array
 *  @access public
 */
  public $helpers = array('Gags');

/**
 *  CakePHP Methods
 *  @var array
 *  @access public
 */
  public $components = array('Acl', 'Session', 'Auth'=>array('authorize' => 'Crud'));

/**
 *  CakePHP Method
 *  @access public
 *  @return void
 */
  public function beforeFilter() 
 {
   parent::beforeFilter();
 }

 /***  ===   ADMIN METHODS ===  ***/  
/**
 *  Reorder inquirries in Quiz
 *  @access public
 *  @return void
 */
 public function admin_order() 
 {
   $this->autoRender = False;
   #die(debug($this->request->data));
   $i = (int) 0;
   foreach ($this->request->data['questions'] as $key => $value):
       $this->Inquiry->id = $value;
       $this->Inquiry->saveField('order',$i++);
   endforeach;
 }

/**
  *  Add question Ajax
  *  @access public
  *  @return void
  */
 public function admin_add() 
 {
  if (!empty($this->request->data['Inquiry'])):
    #die(debug($this->request->data));
    $this->request->data['Inquiry']['user_id'] = (int) $this->Auth->user('id');
    $this->request->data['Inquiry']['order']   = $this->__getOrderNumber($this->request->data['Inquiry']['quiz_id']);
    if ( $this->Inquiry->save( $this->request->data ) ):
        $this->__ajaxCall($this->request->data['Inquiry']['quiz_id']);
    endif;
  endif;
 }

/**
 * Edit question
 * @access public
 * @return void
 */
 public function admin_edit() 
 {
  $this->layout = 'ajax';
  if ( isset($this->request->data['Inquiry']['save']) ):
      if ( $this->Inquiry->save( $this->request->data ) ): 
          $this->__ajaxCall($this->request->data['Inquiry']['quiz_id'], $msg='Data saved');
	  endif;
  else:  
      $this->Inquiry->contain();
      $this->request->data = $this->Inquiry->read(Null, $this->request->data['Inquiry']['id']);
  endif;
 }

/**
 *  Get next order number in quiz
 *  @access private
 *  @return void
 *  @param integer $user_id
 */
 private function __getOrderNumber($quiz_id)
 {

  $order = $this->Inquiry->field('order',  array('user_id'=>$this->Auth->user('id'), 'quiz_id'=>$quiz_id), 'order DESC');
  if ( !$order ):
      $order = (int) 1;
  else:
      $order = (int) $order + 1;
  endif;
  return $order; 
 }

/**
 *  Callback 
 *  @access private
 *  @return void
 *  @param integer $user_id
 */
 private function __ajaxCall($quiz_id, $msg='Data saved')
 {
   $data = $this->requestAction('/admin/quizzes/questions/'. $quiz_id);
   $this->set('ajax', True);
   $this->set('data', $data);
   $this->Session->setFlash($msg);
   $this -> viewPath = 'Quizzes';
   $this->render('admin_questions', 'ajax');
   return True;
}


/**
 * Display questions
 * @access public
 * @return void
 */
  public function admin_listing($quiz_id)
  {   
    $this->layout   = 'ajax';
    $this->__ajaxCall($quiz_id);
  }

/**
 * Show quiz questions 
 * @access public
 * @return void
 */
  public function admin_questions($quiz_id)
  {
    $this->layout    = 'admin';
    $params = array(
                    'conditions' => array('Inquiry.user_id'=>$this->Auth->user('id'), 'Inquiry.id'=>$quiz_id),
                    'field'      => array('Inquiry.id', 'Inquiry.user_id', 'Inquiry.title','Inquiry.description'),
                    'order'      => 'Inquiry.id DESC'
                   );
    $this->set('data', $this->Inquiry->find('all', $params));
  }
  
/**
 * Dsiplay answers
 * @access public
 * @return void
 */
  public function admin_answers($outside = False)
  {
   $this->layout = 'ajax';
   $params = array('conditions' => array('Inquiry.id'=>$this->request->data['Inquiry']['question_id']));
   $data = $this->Inquiry->find('first', $params);

   if ( $outside == True ):  # ajax called from AnswersController.php
       return $data;
   endif;

   $this->set('data',$data);
  }

/**
 *
 * @access public
 * @return void
 */
  public function admin_change($id, $status)
  { 
    $new_status = ($status == 0 ) ? 1 : 0;
    $this->Inquiry->id  = $id;      

    if ($this->Inquiry->saveField('status', $new_status)):
        $this->__ajaxCall($quiz_id);
    endif;
  }

/**
 * Remove question and answers
 * @access public
 * @return void
 */
 public function admin_delete() 
 {
  if ( $this->Inquiry->delete($this->request->data['Inquiry']['id']) ):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->__ajaxCall($this->request->data['Inquiry']['quiz_id'], $msg);
 }
}

# ? > EOF

