<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package treasures
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /APP/Controller/TreasuresController.php

App::uses('Sanitize', 'Utility');

class TreasuresController extends AppController {

/**
 *  CakePHP helpers
 *  @access public
 *  @var array 
 */
 public $helpers     = array('Ck');
 
/**
 *  CakePHP components
 *  @access public
 *  @var array 
 */
 public $components  = array('Edublog', 'Mailer');

/**
 *  Auth component permissions
 *  @access public
 *  @return void 
 */
 public function beforeFilter()
 {
   parent::beforeFilter();
   $this->Auth->allow(array('view', 'chksw'));
 }

 /**
 * View Metod
 * check if tresure string (final code) is OK, if so, save student data on ResultTreasure model 
 * @access public
 * @return void
 * @param $username string
 * @param $treasure_id int
 * @param $vlcassroom_id int
 */
 public function view($username, $treasure_id, $vclassroom_id)
 {
  $this->Edublog->setUserId($username); # blogger elements
  $this->Edublog->checkPermissions($vclassroom_id, $treasure_id, 'Treasure', $this->Auth->user('id')); # set permissions
  $data   = $this->Treasure->find('first', array('conditions' => array('Treasure.status'=>1, 'Treasure.id'=>$treasure_id)));
  $params = array(
                  'conditions'=> array('TreasureVclassroom.treasure_id'=>$treasure_id, 'TreasureVclassroom.vclassroom_id'=>$vclassroom_id),
                  'fields'    => array('TreasureVclassroom.vclassroom_id',  'TreasureVclassroom.fdate',  'TreasureVclassroom.sdate'),
                  'recursive' => 0
                 );
  $data['t'] =  $this->Treasure->TreasureVclassroom->find('first', $params);
  $this->set('data', $data);
 }

/**
 * Ckheck if student already had answered this Treasure
 * check if tresure string (final code) is OK, if so, save student data on ResultTreasure model 
 * @access public
 * @return void
 */
 public function chksw()
 {
  $this->layout    = 'ajax';

  if ( !empty($this->request->data['ResultTreasure']) ):
      $conditions = array('ResultTreasure.treasure_id'=>$this->request->data['ResultTreasure']['treasure_id'],'ResultTreasure.user_id'=>$this->Auth->user('id'));
      $answer = $this->Treasure->ResultTreasure->field('id', $conditions);

      if ($answer != False):
          $this->set('msg', __('You already answered this Scavenger Hunt'));
          $this->render('chksw', 'ajax');
          return False;
      endif;

      $secret = $this->Treasure->field('secret', array('status'=>1,'id'=>$this->request->data['ResultTreasure']['treasure_id']));
                 
      if ( $this->request->data['ResultTreasure']['secret'] ==  $secret ):
          $this->request->data['ResultTreasure']['user_id'] = $this->Auth->user('id');
	      $this->Treasure->ResultTreasure->save($this->request->data['ResultTreasure']);

          # Send email teacher(s) section STARTS
          $teachers = $this->Treasure->User->getTeachers($this->request->data['ResultTreasure']['vclassroom_id']);
          # die(debug($teachers));
          $title = $this->Treasure->field('Treasure.title', array('Treasure.id'=>$this->request->data['ResultTreasure']['treasure_id']));
          # Send email to teacher
          $sendArray = array(
             'subject' => __('Scavenger Hunt answered'),
             'message' => __('Student').' '.$this->Auth->user('username').' '.__('has answered the kandie'). ': '.$title,
                    );
          $this->Mailer->sendMany($sendArray, $teachers);
          # Send email teacher(s) section  ENDS

          $this->set('msg', __('Cool!, the '). $this->request->data['ResultTreasure']['points'] .' '.__('points are yours'));
          $this->render('chksw', 'ajax');
      else:
          $this->set('msg', __('Sorry, code is incorrect'));
	      $this->render('chksw', 'ajax');
      endif; 
  endif;
 }

/**
 * display Kandies
 * check if tresure string (final code) is OK, if so, save student data on ResultTreasure model 
 * @access public
 * @return void
 */
 public function display($username)
 {    
  $this->Edublog->setUserId($username);
  $params  = array('conditions' => array('Treasure.status'=>1, 'Treasure.user_id'=>$this->Edublog->userId, 'Treasure.knet'=>1),
                   'fields'     => array('Treasure.id', 'Treasure.title', 'Treasure.created'),
                   'order'      => 'Treasure.id DESC',
                   'limit'      => 30);
     
  $this->set('data', $this->Treasure->find('all', $params)); 
 }

/**  === ADMIN METHODS  === **/ 

/**
 * display teacher SHs
 * @access public
 * @return void
 */
 public function admin_listing()
 {   
  $this->layout    = 'admin';
  $params = array('conditions' => array('Treasure.user_id'=>$this->Auth->user('id')),
                  'fields'     => array('id', 'title', 'created', 'status', 'secret', 'points'),
                  'order'      => 'Treasure.id DESC',
                  'limit'      => 20,
                  'contain'    => False);
  $this->set('data', $this->Treasure->find('all', $params)); 
 }

/**
 * display() 
 * check if tresure string (final code) is OK, if so, save student data on ResultTreasure model 
 * @access public
 * @param integer $result_treasure_id
 * @param integer $sense
 * @return void
 */
 public function admin_points($result_treasure_id, $sense)
 {
   $points = $this->Treasure->ResultTreasure->field('points', array('ResultTreasure.id'=>$result_treasure_id));
   $points = ($sense == 'up' ) ? ($points + 1) : ($points - 1);
   $this->Treasure->ResultTreasure->id = (int) $result_treasure_id; 
   #die(debug($points));
   if ($this->Treasure->ResultTreasure->saveField('points', $points)):
       $this->set('points', $points);
	   $this->render('admin_points', 'ajax');
   endif;
 }

/**
 *  Get teacher s Scaveger 
 *  @access public
 *  @param integer $vclassroom_id
 *  @return mixed array or Null
 */
 public function admin_vclassrooms($treasure_id)
 {
   $this->layout = 'admin';
   $params = array('conditions' => array('Vclassroom.user_id'=>$this->Auth->user('id'), 'Vclassroom.status'=>1));
   $this->set('data', $this->Treasure->Vclassroom->find('all', $params)); 
   $this->Treasure->unbindModel(array('belongsTo'=>array('User')));
   $this->set('treasures',$this->Treasure->TreasureVclassroom->find('all', array('conditions'=>array('TreasureVclassroom.treasure_id'=>$treasure_id))));
   $this->set('treasure_id', $treasure_id);
 }

/**
 *  Get teacher's Scavenger 
 *  @access public
 *  @param integer $vclassroom_id
 *  @return mixed array or Null
 */
 public function admin_getScaven($vclassroom_id)
 {      
   $this->layout = 'ajax';
   return $this->Treasure->getScaven($this->Auth->user('id'), $vclassroom_id);
 }

/**
 *  See treasure in student record
 *  @access public
 *  @param integer $treasure_id
 *  @param integer $user_id
 *  @return mixed array or Null
 */
 public function admin_answers($user_id, $treasure_id)
 { 
  $this->layout = 'popup';
  $this->set('data', $this->Treasure->getTreasure($user_id, $treasure_id));
 }

/**
 *  Link kandie to vClassroom
 *  @access public
 *  @param integer $vclassroom_id
 *  @return mixed array or Null
 */
 public function admin_link2class() 
 {
  $this->layout    = 'ajax';
  #die(debug($this->request->data));
  if ( !empty($this->request->data['TreasureVclassroom']) ):
     $this->request->data['TreasureVclassroom'] = Sanitize::clean($this->request->data['TreasureVclassroom']);  # no XSS
     if ($this->Treasure->TreasureVclassroom->save($this->request->data) ):
         if ( isset( $this->request->data['TreasureVclassroom']['popup']) ):
             $return = '/admin/vclassrooms/dide/'.$this->request->data['TreasureVclassroom']['vclassroom_id'];
         else:
             $return = '/admin/treasures/vclassrooms/'.$this->request->data['TreasureVclassroom']['treasure_id'];
         endif;
         $this->msgFlash(__('Treasure assigned'), $return);
     endif;
  endif;
 }

/**
 *  Unlink kandie to vClassroom
 *  @access public
 *  @return mixed array or Null
 */
 public function admin_unlink2class() 
 {
   $this->layout    = 'admin';
 
   if ( !empty($this->request->data['TreasureVclassroom']) ):
       $this->request->data['TreasureVclassroom'] = Sanitize::clean($this->request->data['TreasureVclassroom']);
       if ( $this->Treasure->TreasureVclassroom->delete($this->request->data['TreasureVclassroom']['id'])):
           if (isset($this->request->data['TreasureVclassroom']['popup'])):
               $return =  '/admin/vclassrooms/dide/'.$this->request->data['TreasureVclassroom']['vclassroom_id'];
           else:
               $return =  '/admin/treasures/vclassrooms/'.$this->request->data['TreasureVclassroom']['treasure_id'];
           endif;
           $this->msgFlash(__('Kandie unlinked'), $return);
       endif;
   endif;
 }
 
/**
 *  Add or edit Scavenger 
 *  @access public
 *  @param mixed integer or Null $treasure_id
 *  @return void
 */
 public function admin_edit($treasure_id = null)
 {
   $this->layout    = 'admin';
   if (!empty($this->request->data['Treasure'])):
         if ( !isset($this->request->data['Treasure']['id']) ):
             $this->request->data['Treasure']['user_id']  = (int) $this->Auth->user('id');
         endif;
         $this->request->data['Treasure']['title'] = Sanitize::paranoid($this->request->data['Treasure']['title'], $this->para_allowed);

         if ($this->Treasure->save($this->request->data)):
             if ( $this->request->data['Treasure']['end'] == 0 && !isset($this->request->data['Treasure']['id']) ):
                     $id = (int) $this->Treasure->getLastInsertID();
                     $return = '/admin/treasures/edit/'.$id;
             elseif( $this->request->data['Treasure']['end'] == 0 && isset($this->request->data['Treasure']['id'])):
                     $return = (string)'/admin/treasures/edit/'.$this->request->data['Treasure']['id'];
             elseif ($this->request->data['Treasure']['end'] == 1):
                     $return =  '/admin/treasures/listing';
	         endif;
             $this->msgFlash(__('Data saved'),$return);
	     endif;
   elseif($treasure_id != null && intval($treasure_id)):
       $this->request->data = $this->Treasure->read(Null, $treasure_id);
   endif;
 }

 
/**
 *  Change user status actived/no actived   
 *  @access public
 *  @param integer $vclassroom_id
 *  @param integer $status
 *  @return void
 */
 public function admin_change($treasure_id, $status)
 {
  $new_status          = ($status == 0 ) ? 1 : 0;

  $this->Treasure->id  = (int) $treasure_id;
     
  if ( $this->Treasure->saveField('status', $new_status) ):
      $this->msgFlash(__('Status modified'), '/admin/treasures/listing');
  endif;
 }


/**
 *  Get teacher s Scaveger 
 *  @access public
 *  @param integer $treasure_id
 *  @return array 
 */
 public function admin_view($treasure_id)
 { 
  $this->set('data', $this->Treasure->find('first', array('conditions' => array('Treasure.id'=>$treasure_id))));
 }

/** 
 *  Remove SH
 *  @access public
 *  @return void
 */
 public function admin_delete()
 {
  if ( $this->Treasure->delete($this->request->data['Treasure']['id']) ):  
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/treasures/listing');
 }

/**
 *  Edit linked Kandie
 *  @access public
 *  @param integer $treasure_id
 *  @param integer $status
 *  @return void
 */
 public function admin_ekandie() 
 {
   $this->layout = 'ajax';
   $this->request->data = $this->Treasure->TreasureVclassroom->read(null, $this->request->data['TreasureVclassroom']['id']);
   $this->render('admin_ekandie', 'ajax');
 }

/**
 *  Update linked Kandie
 *  @access public
 *  @param integer $treasure_id
 *  @param integer $status
 *  @return void
 */
 public function admin_update() 
 {
  $this->layout = 'ajax';
  if ( $this->Treasure->TreasureVclassroom->save($this->request->data) ):
      $msg = __('Data updated');
  else:
      $msg = __('Data NOT updated');
  endif; 
  $this->msgFlash($msg, '/admin/vclassrooms/dide/'.$this->request->data['TreasureVclassroom']['vclassroom_id']);
 }
}
# ? > EOF
