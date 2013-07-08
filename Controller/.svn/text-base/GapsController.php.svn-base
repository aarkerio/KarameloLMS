<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package Gaps
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: /APP/Controller/GapsController.php

/**
 *  Include files
 */
App::uses('Sanitize', 'Utility');

class GapsController extends AppController {

/**
 *  Cake Helpers
 *  @var array
 *  @access public
 */
 public $helpers    = array('Gags');  

/**
 *  Cake components
 *  @var array
 *  @access public
 */
 public $components = array('Edublog', 'RequestHandler', 'Mailer');
 
/**
 *  Cake paginate
 *  @var array
 *  @access public
 */
 public $paginate = array('limit' => 10, 'page' => 1, 'order' => array('Gap.id' => 'DESC'), 'fields'=> array('Gap.title',  'Gap.id'));
 
/**
 *  Auth component restrictions
 *  @access public
 */
 public function beforeFilter() 
 {
   parent::beforeFilter();
   if ( $this->Auth->user() ):
       $this->Auth->allow(array('view', 'display', 'result', 'save'));
   endif;
 }

/**
 *  Show gaps to another teachers (DEPRECATED)
 *  @param string $username
 *  @access public
 *  @return void 
 */
 public function display($username)
 {
  $this->Edublog->setUserId($username);
  $params = array('conditions' => array('Gap.user_id'=>$this->Edublog->userId, 'Gap.status'=>1));
  $this->set('data', $this->Gap->find('all', $params));
 }

/**
 *  View Gap
 *  @access public
 *  @param string  $username
 *  @param integer $gap_id
 *  @param integer $vclassroom_id
 *  @return void
 */
 public function view($username, $gap_id, $vclassroom_id)
 {
  $this->Edublog->setUserId($username); # set edublog components
  $this->Edublog->checkPermissions($vclassroom_id, $gap_id, 'Gap', $this->Auth->user('id')); # set permissions

  $data = $this->Gap->buildGaps($gap_id);
  if ( !$data ):
      throw new NotFoundException('Could not find that gap');
  endif;
  $params    = array('conditions'=>array('GapVclassroom.gap_id'=>$gap_id, 'GapVclassroom.vclassroom_id'=>$vclassroom_id),
                     'fields'=>array('GapVclassroom.vclassroom_id',  'GapVclassroom.fdate',  'GapVclassroom.sdate'),'recursive'=>0);
  $data['t'] =  $this->Gap->GapVclassroom->find('first', $params);
  $this->set('data',$data);
 }

/**
 *  Save result
 *  @access public
 *  @return void 
 */
 public function result()
 { 
  if ( !$this->Auth->user() ):
      $this->redirect('/');
  endif; 

  try {
    # die(debug($this->request->data['Gap'])); 
    $this->request->data['Gap'] = Sanitize::clean($this->request->data['Gap']);    
    $this->Gap->contain();
    
    $Gaps = $this->Gap->buildGaps($this->request->data['Gap']['id'], False);
    $data = array();
    $i    = (int) 0;
    foreach($Gaps as $gap):
        $i++;
        $data[$i]['s1'] = $gap['secret'];
        $data[$i]['s2'] = $this->request->data['Gap']['try'.$i];
    endforeach;
    $xtradata = array('vclassroom_id'=>$this->request->data['Gap']['vclassroom_id'], 'gap_id'=>$this->request->data['Gap']['id'], 'blogger'=>$this->request->data['Gap']['blogger'], 'blogger_id'=>$this->request->data['Gap']['blogger_id']);
    $this->set('xtradata', $xtradata);
    $this->set('data', $data);
    $this->render('result', 'ajax');
  }
  catch (Exception $e) 
  {
      echo "Caught my exception\n" . $e;
  }   
 }

/**
 *  Save result
 *  @access public
 *  @return void 
 */
 public function save() 
 {
   if (!empty($this->request->data['ResultGap'])):
           $this->request->data['ResultGap'] = Sanitize::clean($this->request->data['ResultGap']);
           $this->request->data['ResultGap']['user_id'] = (int) $this->Auth->user('id');  
           if ( $this->Gap->ResultGap->save($this->request->data)):
                $this->flash(__('Good work!, your answers ha ben saved succesfully'), 
                              '/vclassrooms/show/'.$this->request->data['ResultGap']['blogger'].'/'.$this->request->data['ResultGap']['vclassroom_id'], 3);
                # Send email teacher(s) section STARTS
                $teachers = $this->Gap->User->getTeachers($this->request->data['ResultGap']['vclassroom_id']);
                $title = $this->Gap->field('title', array('Gap.id'=>$this->request->data['ResultGap']['gap_id']));
                # Send email to teacher
                $sendArray = array(
                        'subject' => __('Gap filling answered'),
                        'message' => __('Student').' '.$this->Auth->user('username').' '.__('has answered the kandie'). ': '.$title);
                $this->Mailer->sendMany($sendArray, $teachers);
                # Send email teacher(s) section  ENDS
           endif;
   endif;
 }
 
 /**   === ADMIN METHODS ====  **/

/**
 *  gap_id, user_id vclassroom_id
 *  @access public
 *  @return void
 */
 public function admin_tempo()
 {     
   $data  = $this->Gap->getPoints(2, 4, 2);
 }
 
/**
 *  List gaps
 *  @access public
 *  @return void
 */
 public function admin_listing()
 {   
   $this->layout                 = 'admin';
   $this->paginate['conditions'] = array('Gap.user_id'=>$this->Auth->user('id'));
   $this->paginate['fields']     = array('Gap.id', 'Gap.user_id', 'Gap.title', 'Gap.status');
   $this->paginate['order']      = 'Gap.title DESC';
   $this->paginate['contain']    = False;
   $data = $this->paginate('Gap');
   $this->set(compact('data'));
 }


/**
 *  Select classrooms to link
 *  @access public
 *  @param integer $gap_id
 *  @return void
 */
 public function admin_vclassrooms($gap_id)
 { 
   $this->layout = 'admin';
   $params = array('conditions' => array('Vclassroom.user_id'=>$this->Auth->user('id'), 'Vclassroom.status'=>1));
   $this->set('data', $this->Gap->Vclassroom->find('all', $params));
   $this->set('gaps',$this->Gap->GapVclassroom->find('all', array('contains'=>False,'conditions'=>array('GapVclassroom.gap_id' => $gap_id))));
   $this->set('gap_id', $gap_id);
 }
  
/**
 *  Link to vClassroom
 *  @access public
 *  @return void
 */
 public function admin_link2class() 
 {
  $this->layout    = 'admin';
  if ( !empty($this->request->data['GapVclassroom']) ):
        $this->request->data['GapVclassroom'] = Sanitize::clean($this->request->data['GapVclassroom']);
        if ( $this->Gap->GapVclassroom->save($this->request->data)):
            if ( isset($this->request->data['GapVclassroom']['popup']) ):
                $return = (string) '/admin/vclassrooms/dide/'.$this->request->data['GapVclassroom']['vclassroom_id'];
            else:
                $return = (string) '/admin/gaps/vclassrooms/'.$this->request->data['GapVclassroom']['gap_id'];
            endif;
            $this->msgFlash(__('Gap Filling linked'), $return);
        endif;
  endif;
 }

/**
 *  Unlink to vClassroom
 *  @access public
 *  @return void
 */
 public function admin_unlink2class() 
 {
  $this->layout    = 'admin';

  if ( !empty($this->request->data['GapVclassroom']) ):
      $this->request->data['GapVclassroom'] = Sanitize::clean($this->request->data['GapVclassroom']);

      if ( $this->Gap->GapVclassroom->delete($this->request->data['GapVclassroom']['id'])):
           if (isset($this->request->data['GapVclassroom']['popup'])):
               $return =  '/admin/vclassrooms/dide/'.$this->request->data['GapVclassroom']['vclassroom_id'];
           else:
               $return =  '/admin/gaps/vclassrooms/'.$this->request->data['GapVclassroom']['gap_id'];
           endif;
           $this->msgFlash(__('Kandie unlinked', true), $return);
      endif;
  endif;
 }

/**
 *  Return gaps owned by teacher
 *  @access public
 *  @return void
 */
 public function admin_get($vclassroom_id) 
 {
   return $this->Gap->getGaps($this->Auth->user('id'), $vclassroom_id);
 } 

/**
 *  Edit/add gap
 *  @access public
 *  @param integer $id
 *  @param integer $status
 *  @return void
 */
 public function admin_edit($gap_id=null) 
 {
   $this->layout    = 'admin';
  
   if (!empty($this->request->data['Gap'])):   # insert or update
       if ( !isset($this->request->data['Gap']['id']) ):
           $this->request->data['Gap']['user_id'] = (int) $this->Auth->user('id');
       endif;
	   if ( $this->Gap->save($this->request->data)):
	       if ($this->request->data['Gap']['end'] == 0 && !isset($this->request->data['Gap']['id'])):
	           $id = $this->Gap->getLastInsertID();
	           $return = '/admin/gaps/edit/'.$id;   
	       elseif ($this->request->data['Gap']['end'] == 0 && isset($this->request->data['Gap']['id'])):
	           $return = '/admin/gaps/edit/'.$this->request->data['Gap']['id'];
	       elseif ($this->request->data['Gap']['end'] == 1 ):
	           $return = '/admin/gaps/listing';
	       endif;
	       $this->msgFlash(__('Data saved'),$return);
       endif;
   elseif (intval($gap_id) && $gap_id != null): # populate form 
       $this->Gap->contain(False);
	   $this->request->data = $this->Gap->read(null, $gap_id);
   endif;
 }
 

/**
 *  See Gap as student see
 *  @access public
 *  @return void
 */
 public function admin_see($user_id, $gap_id, $vclassroom_id)
 { 
   $this->layout = 'popup';
   $this->set('data', $this->Gap->getGap($user_id, $gap_id, $vclassroom_id));
 }
 
/**
 *  Change status published/draft
 *  @access public
 *  @param integer $id
 *  @param integer $status
 *  @return void
 */
 public function admin_change($gap_id, $status)
 { 
   $news_status   = ($status == 0 ) ? 1 : 0;
   $this->Gap->id = $gap_id;
   if ($this->Gap->saveField('status', $news_status)):
       $this->msgFlash(__('Status modified'), '/admin/gaps/listing');
   endif;
 }
 
/**
 *  Remove Gap
 *  @access public
 *  @return void
 */
 public function admin_delete($gap_id) 
 {
   if ( $this->Gap->delete($gap_id) ):
       $this->msgFlash(__('Data removed', true), '/admin/gaps/listing');
   endif; 
 }

/**
 * Edit linked Kandie
 *  @access public
 *  @return void
 */
 public function admin_ekandie() 
 {
   $this->layout = 'ajax';
   $this->request->data = $this->Gap->GapVclassroom->read(null, $this->request->data['GapVclassroom']['id']);
   $this->render('admin_ekandie', 'ajax');
 }

/**
 *  Update linked Kandie
 *  @access public
 *  @return void
 */
 public function admin_update() 
 {
  $this->layout = 'ajax';
  if ( $this->Gap->GapVclassroom->save($this->request->data) ):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/vclassrooms/dide/'.$this->request->data['GapVclassroom']['vclassroom_id']);
 }
}
# ? > EOF
