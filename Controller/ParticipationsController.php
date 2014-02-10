<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package vclassroom
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /APP/Controller/ParticipationsController.php

App::uses('Sanitize', 'Utility');

class ParticipationsController extends AppController {

/**
 * Load helpers
 * @access public
 * @var array
 */
  public  $helpers = array('Paginator');

/**
 *  Cake components
 *  @var array
 *  @access public
 */ 
  public $components    = array('Mailer');

/**
 *  Pagination array
 *  @var array
 *  @access public
 */ 
  public $paginate = array('limit' => 40,'order' => array('Participation.created' => 'ASC'));

/**
 * Auth component
 * @access public
 * @return void
 */
 public function beforeFilter() 
 {
   parent::beforeFilter();

   if ( $this->Auth->user() ):
       $this->Auth->allow(array('display', 'show', 'add', 'points'));
   endif;
 }

/**
 * add
 * @access public
 * @return void
 */
 public function add()
 {
   if ( !empty($this->request->data['Participation'])):
       $this->request->data['Participation']['user_id']  = (int) $this->Auth->user('id');  # student_id
       $this->request->data['Participation']['points']   = (int) 0;   # no points to student by default

       if ($this->Participation->save($this->request->data)):
           $msg = __('Your participation has been saved');
       else:
           $msg = __('Data NOT saved');
       endif; 
	   $url = '/vclassrooms/show/'.$this->request->data['Participation']['blogger_username'].'/'.$this->request->data['Participation']['vclassroom_id'];
       # Email STARTS
       $email   = (string) $this->Auth->user('email');
       $this->Mailer->set('url', $url);
       $activity =  $this->Participation->Activity->field('title', 'id='.$this->request->data['Participation']['activity_id']);
       $msg =  __('Teacher has received your participation'). "\n<br />". __('Activity') .': ' . $activity ."\n<br />";

       $this->Mailer->set('message', $msg);
       $this->Mailer->subject  = (string) __('Participation submitted successfully');
       $this->Mailer->layout   = 'default';
       $this->Mailer->sendAs   = 'html';
       $this->Mailer->send($email);  # email to student
       # Emails to teacher and tuthors in this virtual classroom
       $users = $this->Participation->User->getTeachers($this->request->data['Participation']['vclassroom_id']);
       $data  = array('subject'=>__('New particpiation'), 'message'=>__('Student has sent a participation').' '.$url);
       $this->Mailer->sendMany($data, $users);
       # Email ENDS
       $this->msgFlash(__('Participation saved'), $url);   # Return 
   endif;
 }

/*=== ADMIN  METHODS ===*/

/**
 *  List all stundents participations 
 *  @access public
 *  @return void
 *  @param integer $vclassroom_id
 */
  public function admin_listing($vclassroom_id)
  {
    $this->layout = 'admin';
    $this->set('vclassroom_id', $vclassroom_id);
    
    $this->paginate['limit']      = 40;
    $this->paginate['fields']     = array('Participation.id', 'Participation.title', 'Participation.created', 'Participation.points', 'Participation.user_id', 'Participation.participation', 'Participation.checked');
    $this->paginate['conditions'] = array('Participation.vclassroom_id'=>$vclassroom_id);
    $this->paginate['contain']    =  array('User'=>array('fields'=>array('User.id', 'User.name', 'User.username', 'User.avatar')));
    $this->paginate['order']      = 'Participation.created DESC';
    $data = $this->paginate('Participation');
    $this->set(compact('data')); 
  }

/**
 * Update title
 * @access public
 * @return void
 * @param integer $report_id
 */
 public function admin_edit()
 {
   #die(debug($this->request));
   $participation_id = substr_replace($this->request->data['id'], '', 0, 14);
   #die(debug($participation_id)); 

   $title =  trim($this->request->data['value']);
   $this->Participation->id  = (int) $participation_id;  
   if ($this->Participation->saveField('title', $title)):
       $this->set('title', $title);
   endif;
 }

/**
 * Participation evaluated
 * @access public
 * @return void
 * @param integer $report_id
 * @param string  $sense
 */
 public function admin_share($participation_id)
 {
  $data = $this->Participation->getData($participation_id); # Model call
  #die(debug($data));
  $this->Participation->id  = $participation_id; 
    
   if ($this->Participation->saveField('checked', 1)):
       # Email STARTS
       $email   = (string) $data['User']['email'];
       $msg  = __('The teacher has graded the participation you sent'). ": \n<br />" .  $data['Participation']['title'] . '<br />';
       $msg .= __('Activity'). ': '.$data['title'];
       $this->Mailer->set('url', '/vclassrooms/show/'. $data['teacher_username'].'/'.$data['Participation']['vclassroom_id']);
       $this->Mailer->set('message',$msg);
       $this->Mailer->subject  =  (string) $data['Vclassroom']['name'];
       $this->Mailer->layout   = 'default';
       $this->Mailer->sendAs   = 'html';
       $this->Mailer->send($email);  # email to student
       # Email ENDS    
       $this->msgFlash(__('Participation graded'), $this->referer());
   endif;
 }

/**
 * Update points
 * @access public
 * @return void
 */
 public function admin_points($participation_id, $sense)
 {
  $points = (int) $this->Participation->field('points', array('Participation.id'=>$participation_id));   
  $points = ($sense == 'up' ) ? ($points + 1) : ($points - 1);
  $this->Participation->id = (int) $participation_id;
 
  if ($this->Participation->saveField('points', $points)):
      $this->set('points', $points);
	  $this->render('admin_points', 'ajax');
  endif;
 }

/**
 * Write participation
 * @access public
 * @param integer $vclassroom_id
 * @return void
 */
 public function admin_add($student_id=Null, $vclassroom_id=Null)
 {
  if ( !empty($this->request->data['Participation']) ):
      if ($this->Participation->save($this->request->data)):
	      $url = '/admin/vclassrooms/record/'.$this->request->data['Participation']['user_id'].'/'.$this->request->data['Participation']['vclassroom_id'];
          $this->msgFlash(__('Your participation has been saved'), $url);
      endif;
  else:
      $this->set('student_id', $student_id);
      $this->set('vclassroom_id', $vclassroom_id);
      $this->render('admin_add');
  endif;
 }

/**
 * Change public or not
 * @access public
 * @param integer $vclassroom_id
 * @return void
 */
 public function admin_show($participation_id) 
 {
   $this->layout = 'popup';
   $params = array('conditions' => array('Participation.id'=>$participation_id),
                   'contain'    => array('User'=>array('fields'=>array('username', 'avatar', 'name'))));
   $this->set('data', $this->Participation->find('first', $params));
 }

/**
 * Remove
 * @access public
 * @param integer $vclassroom_id
 * @return void
 */
 public function admin_delete($participation_id, $vclassroom_id) 
 {
  if ( $this->Participation->delete($participation_id) ):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/participations/listing/'.$vclassroom_id);
 }

 /**                                                                                                 
  *  Remove all parrticipations on virtual classroom
  *  @access public           
  *  @param integer $vclassroom_id       
  *  @return void                                                                                         
  */
 public function admin_unlink($vclassroom_id)
 {
   $this->Participation->deleteAll(array('Participation.vclassroom_id' => $vclassroom_id), False);
   $this->msgFlash(__('Data deleted'),  $this->referer());
 }
}

# ? > EOF
