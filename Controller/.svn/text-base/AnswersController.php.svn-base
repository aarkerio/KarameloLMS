<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package tests
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /app/Controller/AnswersController.php

App::uses('Sanitize', 'Utility');

class AnswersController extends AppController
{

/**
 *  CakePHP Helpers
 *  @var array
 *  @access public
 */ 
 public $helpers = array('Ck');

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */ 
 public function beforeFilter() 
 {
   parent::beforeFilter();
 }
 
/***   === ADMIN METHODS===  ***/

/**
 *  Save answers and render questions view file
 *  @access public
 *  @return void 
 */ 
 public function admin_add() 
 {
  if (!empty($this->request->data['Answer'])):
      $this->request->data['Answer']['user_id'] = (int) $this->Auth->user('id');

      if ( $this->Answer->save($this->request->data) ):
          $this->__callAjax($this->request->data['Answer']['question_id']);
      else:
          die(debug( $this->Answer->validationErrors));
      endif;
  endif;
 }

/**
 *  Ajax display
 *  @access public
 *  @return void
 *  @param integer $user_id
 */
 private function __callAjax($question_id, $msg='Data saved')
 {
  App::uses('QuestionsController','Controller');  # I am dirty, bur effective!!
  $Questions = new QuestionsController;
  $Questions->request->data['Question']['question_id'] = $question_id;
  $data = $Questions->admin_answers(True);
  $this->set('ajax', True);
  $this->set('data', $data);
  $this->Session->setFlash($msg);
  $this -> viewPath = 'Questions';
  $this->render('admin_answers', 'ajax');
  return True;
 }

/**
 *  Ajax display
 *  @access public
 *  @return void
 *  @param integer $user_id
 */
 private function __ajaxOne($answer_id, $msg='Data saved')
 {
  if ($answer_id !== False):
      $params = array('conditions'   => array('Answer.user_id'=>$this->Auth->user('id'), 'Answer.id'=>$answer_id),
                  'fields'       => array('Answer.id', 'Answer.user_id', 'Answer.correct', 'Answer.answer', 'Answer.question_id'),
                  'order'        => 'Answer.id DESC'
                  );
      $data= $this->Answer->find('first', $params);
  else:
      $data = False;
  endif;
  $this->set('data', $data);
  $this->Session->setFlash($msg);
  $this->render('admin_see', 'ajax');
  return True;
 }

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return boolean 
 */ 
 public function admin_edit($answer_id=Null)
 {  
   $this->layout = 'ajax';

   if (empty($this->request->data['Answer'])):
       $this->request->data = $this->Answer->read(Null, $answer_id);
   else:
       if ($this->Answer->save($this->request->data)):
            $this->__callAjax($this->request->data['Answer']['question_id']);
            return True;
       else:
           die(debug($this->Answer->validationErrors));
       endif;
   endif;
   $this->render('admin_edit', 'ajax');
 }

/**
 *  Display one answer
 *  @access public
 *  @return void
 *  @param integer $answer_id
 */
 public function admin_see($answer_id)
 {
   $this->layout = 'ajax';
   $params = array('conditions'   => array('Answer.user_id'=>$this->Auth->user('id'), 'Answer.id'=>$answer_id),
                   'fields'       => array('Answer.id', 'Answer.user_id', 'Answer.correct', 'Answer.answer', 'Answer.question_id'),
                   'order'        => 'Answer.id DESC'
                  );
   $this->set('data', $this->Answer->find('first', $params));
   $this->render('admin_see', 'ajax');
 }

/**
 *  Display answers
 *  @access public
 *  @return void
 *  @param integer $question_id
 */
 public function admin_listing($question_id)
 {
   $this->layout = 'ajax';
   $params = array('conditions'   => array('Answer.user_id'=>$this->Auth->user('id'), 'Answer.question_id'=>$question_id),
                   'fields'       => array('Answer.id', 'Answer.user_id', 'Answer.correct'),
                   'order'        => 'Answer.id DESC');
   $this->set('question_id', $question_id); 
   $this->set('data', $this->Answer->find('all', $params));
   $this->render('admin_listing', 'ajax');
  }
  
/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */ 
 public function admin_questions($test_id)
 {
   $params = array('conditions' => array('Answer.user_id'=>$this->Auth->user('id'), 'Answer.id'=>$test_id),
                   'fields'     => array('Answer.id', 'Answer.user_id', 'Answer.title', 'Answer.description'),
                   'order'      => 'Answer.id DESC');
   $this->set('data', $this->Answer->find('all', $params));
 }

/**
 *  Change status
 *  @access public
 *  @return void 
 */ 
  public function admin_change($answer_id, $correct)
  {  
   $new_correct = ($correct == 0 ) ? 1 : 0;
   $this->Answer->id = (int) $answer_id;
    
   if ( $this->Answer->saveField('correct', $new_correct) ):
       $msg = __('Data updated');
   else:
       $msg = __('Data NOT updated');
   endif;
   $this->__ajaxOne($answer_id, $msg);
  }
  
/**
 *  Delete answer
 *  @access public
 *  @return void 
 */ 
  public function admin_delete($answer_id, $question_id) 
 {
  if ( $this->Answer->delete($answer_id) ):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->Session->setFlash($msg);
 }
}

# ? > EOF
