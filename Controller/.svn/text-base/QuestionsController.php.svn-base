<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package tests
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: app/Controller/QuestionsController.php

App::uses('Sanitize', 'Utility');

class QuestionsController extends AppController {

/**
 *  Cake helpers
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
   $this->Auth->allow(array('save', 'view'));
 }
  /**
   *  Save answer
   *  @access public
   *  @return void
   *  @param integer $user_id
   */
  public function save($question_id, $answer_id, $test_id, $vclassroom_id) 
  {
   if ( isset( $this->request->query['answer'] )):
       $this->request->data['Result']['answer']     = $this->request->query['answer'];
       $this->request->data['Result']['answer_id']  = Null;
   else:
       $this->request->data['Result']['answer_id']  = $answer_id;
   endif;
   $this->request->data['Result']['user_id']       = $this->Auth->user('id');
   $this->request->data['Result']['question_id']   = $question_id;
   $this->request->data['Result']['test_id']       = $test_id;
   $this->request->data['Result']['vclassroom_id'] = $vclassroom_id;
   $this->Question->Test->Result->save($this->request->data);

   $data = $this->Question->Test->find('first', array('conditions'=>array('Test.id'=>$test_id), 
                                                      'contain' => array('Question'=>array('Answer')))
                                                     );
   $this->set('next',$this->Question->getNextIndex($question_id));
   $this->set('points',$this->Question->Test->getPoints($test_id, $this->Auth->user('id'), $vclassroom_id));
   $this->set('vclassroom_id', $vclassroom_id);
   $this->set('data', $data);
   $this->render('question', 'ajax');
 }

 /***  ===   ADMIN METHODS ===  ***/  

 public function admin_order() 
 {
   $this->autoRender = False;
   #die(debug($this->request->data));
   $i = (int) 0;
   foreach ($this->request->data['questions'] as $key => $value):
       $this->Question->id = $value;
       $this->Question->saveField('order',$i++);
   endforeach;
 }

 /**
  *  Addn question Ajax
  *  @access public
  *  @return void
  */
 public function admin_add() 
 {
  if (!empty($this->request->data['Question'])):
    #die(debug($this->request->data));
    $this->request->data['Question']['user_id'] = (int) $this->Auth->user('id');
    $this->request->data['Question']['order']   = $this->__getOrderNumber($this->request->data['Question']['test_id']);
    if ( $this->Question->save( $this->request->data ) ):
        $this->__ajaxCall($this->request->data['Question']['test_id']);
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
  if ( isset($this->request->data['Question']['save']) ):
      if ( $this->Question->save( $this->request->data ) ): 
          $this->__ajaxCall($this->request->data['Question']['test_id'], $msg='Data saved');
	  endif;
  else:  
      $this->Question->contain();
      $this->request->data = $this->Question->read(Null, $this->request->data['Question']['id']);
  endif;
 }

/**
 *  Get next order number in test
 *  @access private
 *  @return void
 *  @param integer $user_id
 */
 private function __getOrderNumber($test_id)
 {

  $order = $this->Question->field('order',  array('user_id'=>$this->Auth->user('id'), 'test_id'=>$test_id), 'order DESC');
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
 private function __ajaxCall($test_id, $msg='Data saved')
 {
   $data = $this->requestAction('/admin/tests/questions/'. $test_id);
   $this->set('ajax', True);
   $this->set('data', $data);
   $this->Session->setFlash($msg);
   $this -> viewPath = 'Tests';
   $this->render('admin_questions', 'ajax');
   return True;
}


/**
 * Display questions
 * @access public
 * @return void
 */
  public function admin_listing($test_id)
  {   
    $this->layout   = 'ajax';
    $this->__ajaxCall($test_id);
  }

/**
 * Show test questions 
 * @access public
 * @return void
 */
  public function admin_questions($test_id)
  {
    $this->layout    = 'admin';
    $params = array(
                    'conditions' => array('Question.user_id'=>$this->Auth->user('id'), 'Question.id'=>$test_id),
                    'field'      => array('Question.id', 'Question.user_id', 'Question.title','Question.description'),
                    'order'      => 'Question.id DESC'
                   );
    $this->set('data', $this->Question->find('all', $params));
  }
  
/**
 * Dsiplay answers
 * @access public
 * @return void
 */
  public function admin_answers($outside = False)
  {
   $this->layout = 'ajax';
   $params = array('conditions' => array('Question.id'=>$this->request->data['Question']['question_id']));
   $data = $this->Question->find('first', $params);

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
    $this->Question->id  = $id;      

    if ($this->Question->saveField('status', $new_status)):
        $this->__ajaxCall($test_id);
    endif;
  }

/**
 * Remove question and answers
 * @access public
 * @return void
 */
 public function admin_delete() 
 {
  if ( $this->Question->delete($this->request->data['Question']['id']) ):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->__ajaxCall($this->request->data['Question']['test_id'], $msg);
 }
}

# ? > EOF

