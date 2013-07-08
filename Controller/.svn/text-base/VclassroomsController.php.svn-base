<?php
/**
 *  Karamelo e-Learning Platform
 *  GNU Affero General Public License V3
 *  @copyright Copyright 2006-2012, Chipotle Software(c)
 *  @version 0.7
 *  @package vclassroom
 *  @license http://www.gnu.org/licenses/agpl.html
 */
# file : app/Controller/VclassroomsController.php 

/**
 * Import files
 */
App::uses('Sanitize', 'Utility');

class VclassroomsController extends AppController {

/**
 *  CakePHP Class Name
 *  @var array
 *  @access public
 */
  public $name = 'Vclassrooms';

/**
 *  CakePHP Helpers
 *  @var array
 *  @access public
 */
 public  $helpers      = array('Ck', 'Fpdf', 'Csv', 'Time');

/**
 *  CakePHP components
 *  @var array
 *  @access public
 */
 public  $components    = array('Edublog');

/**
 *  Relationship
 *  @var array
 *  @access private
 */
 private $_ping         = array('hasMany'=>array('Ping'));

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */   
 public function beforeFilter()
 {
   $perms = array('show', 'jointoclass', 'aboutme', 'display', 'index');
   
   parent::beforeFilter();
   if ( $this->Auth->user() ):
       array_push($perms,  'participation', 'upload', 'description', 'chat', 'savemessage', 'ping',  'autocomplete', 'myVclassrooms', 'diploma', 'meeting');
   endif;
   $this->Auth->allow($perms);
 }
 
/** 
 *  Get all actives VCs in portal
 *  @access public
 *  @return void
 */
 public function index()
 {
  $params = array(
          'conditions'=>array('Vclassroom.status'=>1,'Vclassroom.historical'=>0, 'Vclassroom.fdate >= CURRENT_DATE','Vclassroom.sdate <= CURRENT_DATE'),
          'contain'   =>array('Ecourse' => array('fields'=>array('Ecourse.title', 'Ecourse.id', 'Ecourse.user_id'), 
          'User'      =>array('fields'=>array('User.username', 'User.name'))))
          );
  $data = $this->Vclassroom->find('all', $params);
  #die(debug($data));
  $this->set('data',$data);
 }
 
 public function autocomplete()
 {
   $this->layout = 'ajax';
   #Partial strings will come from the autocomplete field as
   $this->Vclassroom->User->contain();
   #die(debug($this->request->data));
   $this->set('users', $this->Vclassroom->User->find('all', array('fields'=>array('User.id', 'User.username'), 'conditions'=>"(username ILIKE '%{$this->request->data['UserVclassroom']['username']}%' or username ILIKE '%{$this->request->data['UserVclassroom']['username']}%')")));
 }
/*
 *  MyVclassrooms
 *  Get stundent current vclassrooms
 */
 public function myVclassrooms()
 {
  if ($this->Auth->user()):
      return $this->Vclassroom->studentVclassrooms($this->Auth->user('id'));
  else:
      return False;
  endif;
 }
 

/**
 * get teacher VC
 * @access public
 * @return  void
 */  
 public function display($user_id)
 {
  $data = $this->Vclassroom->vcOnBlog($user_id);
  if ( isset( $this->params['requested']) ):  # called from element
      return $data;
  endif;
  $this->set('data',$data);
 }
 
/**
 * Display pop-up chat window  
 * @access public
 * @return  void
 */  
 public function chat($username, $vclassroom_id) 
 {
  $this->layout    = 'popup';
  $this->Edublog->setUserId($username, False);
  $belongs = $this->Vclassroom->UserVclassroom->belongs($this->Auth->user('id'), $vclassroom_id);
  # student belongs to this class?
  if ($belongs):
      $this->Vclassroom->contain(False);
      $this->set('belongs', $belongs);
      $this->Vclassroom->bindModel(array(
          'hasMany'=>array(
                              'Chat' =>
                                   array('className'     => 'Chat',
			                             'conditions'    => null,
			                             'order'         => null,
			                             'limit'         => 15,
			                             'foreignKey'    => 'vclassroom_id'
			     ))));
      $params = array('conditions' => array('Vclassroom.id'=>$vclassroom_id,  'Vclassroom.status'=>1),
                      'fields'     => array('Vclassroom.id', 'Vclassroom.name',  'Vclassroom.streaming', 'Vclassroom.videoconference'),
                      'contain'    => False);
      $this->set('data', $this->Vclassroom->find('first', $params));
      
      $params = array('conditions' => array('Chat.vclassroom_id'=>$vclassroom_id, 'Chat.status'=>1),
                      'fields'     => array('Chat.message', 'Chat.created', 'User.username', 'User.id'),
                      'order'      => 'Chat.id DESC',
                      'limit'      => 15);
      $this->set('msgs', $this->Vclassroom->Chat->find('all', $params));
  else:
      $this->set('belongs', False);
  endif;
 }

/**
 *  Save messages on chat
 *  @access public
 *  @return void
 */
 public function savemessage()
 {
   $this->layout = 'ajax';
 
   if ( !empty($this->request->data['Chat'])):     
       $this->request->data['Chat']['status'] = 1; # Just to be sure 
       $this->Vclassroom->Chat->save($this->request->data);
       $params = array('conditions' => array('Chat.status'=>1, 'Chat.vclassroom_id'=>$this->request->data['Chat']['vclassroom_id']),
                       'fields'     => array('Chat.message', 'Chat.created', 'User.username', 'User.id'),
                       'order'      => 'Chat.id DESC',
                       'limit'      => 15);
       $this->set('msgs', $this->Vclassroom->Chat->find('all', $params));
       $this->render('messages');
   endif;
 }

/**
 * Keeps current chatters avatars in chat
 * @access public
 * @return void
 */
 public function ping()
 {
   $vclassroom_id = $_POST['vclassroom_id'];
   $this->layout = 'ajax';
   #deb ($vclassroom_id);
   if ( intval($vclassroom_id) ):
       $user_id = (int) $this->Auth->user('id');
       $this->Vclassroom->bindModel($this->_ping);
       $dbkind = $this->getDbKind();
       $this->set('data', $this->Vclassroom->Ping->handlePings($vclassroom_id, $user_id,  $dbkind));
       $this->render('chatters', 'ajax');
   endif;
 }
 
/**
 * Show user information
 * @access public
 * @param string $username
 * @return void
 */
 public function aboutme($username) 
 {
  $this->Edublog->setUserId($username);   # blogger elements
  $params = array('conditions' => array('User.username'=>trim($username)),
                  'contain'    => 'Profile'
                 );
  $data = $this->Vclassroom->UserVclassroom->User->find('first',$params);
  #die(debug($data));
  $this->set('data', $data);
 }

/**
 * Ajax description in vClassroom
 * @access public
 * @param integer $ecourse_id
 * @return void
 */
 public function description($ecourse_id) 
 {
   $this->set('description', $this->Vclassroom->Ecourse->field('description', array('Ecourse.id'=>$ecourse_id)));
   $this->set('minutes',     $this->Vclassroom->Ecourse->getMinutes($ecourse_id));
   $this->render('description', 'ajax');
 }

/**
 * Core method: show vClassroom, ecourse details and Kandies linked
 * @access public
 * @param string $username
 * @param integer $vclassroom_id
 * @return void
 */
 public function show($username, $vclassroom_id) 
 {
   $this->Edublog->oneSession();         # only one student by IP
   $this->Edublog->setUserId($username); # set edublog stuff
   # Student belongs to this class?
   $this->set('belongs', $this->Vclassroom->UserVclassroom->belongs($this->Auth->user('id'), $vclassroom_id));
   $this->set('student_points', $this->Vclassroom->totalPoints($this->Auth->user('id'), $vclassroom_id));
   # Get the Vclassroom linked elements
   $this->set('data', $this->Vclassroom->classElements($vclassroom_id));
 }
 
/**
 * Ajax form to participation
 * @access public
 * @return void
 */
 public function participation()
 {
   $this->layout = 'ajax';
   $ecourse_id = $this->Vclassroom->field('Vclassroom.ecourse_id', array('Vclassroom.id'=> $this->request->data['Participation']['vclassroom_id']));
   $params     = array('conditions'=>array('Activity.ecourse_id'=>$ecourse_id, 'Activity.status'=>1), 'order'=>'Activity.order ASC', 'fields'=>array('id', 'title') );
   $activities = $this->Vclassroom->Ecourse->Activity->find('list', $params);
   if ( !empty($this->request->data['Participation']) ):  
       $this->set('activities', $activities);
       $this->set('vclassroom_id', $this->request->data['Participation']['vclassroom_id']);
       $this->set('blogger_id', $this->request->data['Participation']['blogger_id']);
       $this->set('blogger_username', $this->request->data['Participation']['blogger_username']);
       $this->render('participation', 'ajax');
   endif;
 }

/**
 * Ajax form to upload file, data saved in Report model
 * @access public
 * @return void
 */
 public function upload()
 {
   $this->layout = 'ajax';
   $ecourse_id = $this->Vclassroom->field('Vclassroom.ecourse_id', array('Vclassroom.id'=> $this->request->data['Upload']['vclassroom_id']));
   $params     = array('conditions'=>array('Activity.ecourse_id'=>$ecourse_id, 'Activity.status'=>1), 'order'=>'Activity.order ASC', 'fields'=>array('id', 'title') );
   $activities = $this->Vclassroom->Ecourse->Activity->find('list', $params);
   if ( !empty($this->request->data['Upload']) ):
       $this->set('activities', $activities);
       $this->set('vclassroom_id', $this->request->data['Upload']['vclassroom_id']);
       $this->set('blogger_id', $this->request->data['Upload']['blogger_id']);
       $this->set('blogger_username', $this->request->data['Upload']['blogger_username']);
       $this->render('upload', 'ajax');
   endif;
 }

/**
 * Link student to vClassroom
 * @access public
 * @return void
 */
 public function jointoclass()
 {
  if (!empty($this->request->data['UserVclassroom'])): 
      # get the secret code by this classroom 
      $code = $this->Vclassroom->field('secret', array('Vclassroom.id'=>$this->request->data['UserVclassroom']['vclassroom_id']));
        
      if ($code != $this->request->data['UserVclassroom']['code'] || $code == Null): # code is correct ?
          $this->set('msg', __('Code is incorrect'));
          $this->render('jointoclass', 'ajax'); 
      elseif($this->Vclassroom->chkMember($this->request->data['UserVclassroom']['vclassroom_id'], $this->Auth->user('id'))):
          # the student is already member in this class?     
          $this->set('msg', __('You are already member of this class'));
          $this->render('jointoclass', 'ajax');
      else:
          $this->request->data['UserVclassroom']['user_id']   = (int) $this->Auth->user('id');
          # $this->request->data['UserVclassroom']['group_id']  = (int) $this->Auth->user('group_id');  # deprecated
          $this->request->data['UserVclassroom']['kind']      = (int) 0; # register as student
	      if ($this->Vclassroom->UserVclassroom->save($this->request->data)):
              $this->set('msg', __('You have joined to this class succesfully, please press F5 key or reload this page'));
              $this->render('jointoclass', 'ajax');
	      endif;
       endif;
  endif;
 }

/**
 * Generate diploma
 * @access public
 * @param integer $vclassroom_id
 * @return boolean
 */
 public function diploma($vclassroom_id)
 {
  if ( !$this->Vclassroom->UserVclassroom->belongs($this->Auth->user('id'), $vclassroom_id) ):
       $this->msgflash(__('You do not belong to this vClassroom'), '/');
       return False;
   else:
       $this->autoRender = False;
       $data = array();
   endif;
   #$data['points'] = (int) $this->Vclassroom->totalPoints($this->Auth->user('id'), $vclassroom_id);
   $data['name'] = $this->Auth->user('name');
   $params = array(
                   'conditions' => array('Vclassroom.id' => $vclassroom_id),
                   'fields'     => array('Vclassroom.id', 'Ecourse.title'),
                   'contain'    => 'Ecourse'
         );
   $data['e'] = $this->Vclassroom->find('first', $params);
   #die(debug($data));
   $this->Vclassroom->Ecourse->diploma($data);
   return True;
 }
 /***   == ADMIN METHODS === ***/   

/**
 * Generate diploma
 * @access public
 * @param boolean $historic
 * @return void
 */
 public function admin_listing($historic = False)
 {
  $this->layout    = 'admin';
 
  $this->set('data', $this->Vclassroom->getVclassrooms($historic, $this->Auth->user('id')));
 
  if ($historic === 'historic'):
      $this->set('historic', True);
  else:
      $this->set('historic', False);
  endif;
 }

/**
 * Ajax call in admin_share in order to share Vclassroom with others teachers
 * @access public
 * @param integer $vclassroom_id
 * @return void
 */
 public function admin_teachers($vclassroom_id)
 {
  $this->layout    = 'ajax';
  $teachers = $this->Vclassroom->vcShared($vclassroom_id, $this->Auth->user('id')); # Model call
  $this->set('teachers', $teachers);
  $this->set('vclassroom_id', $vclassroom_id);
  $this->render('admin_teachers', 'ajax');
 }

/**
 * Share vclassroom with other teachers wich will become tuthors in this virtual classroom
 * @access public
 * @param integer $vclassroom_id
 * @return boolean
 */
 public function admin_share($vclassroom_id=Null)
 {
  $this->layout    = 'admin';
  if ( !isset($this->request->data['UserVclassroom']) ):
      $this->set('vc', $this->Vclassroom->find('first', array('conditions'=>array('Vclassroom.id'=>$vclassroom_id), 'fields'=>array('Vclassroom.id', 'Vclassroom.name'))));
      $this->set('data', $this->Vclassroom->currentVclassroom($vclassroom_id, $this->Auth->user('id')));
  else:
     $this->request->data['UserVclassroom']['group_id']  = (int) 2;  # 2 = teachers groups
     #kind: Owner 1, tuthor 2, or student 0
     $this->request->data['UserVclassroom']['kind']      = (int) 2; # tuthor, can participate in class and grade student but not edit class
	 if ($this->Vclassroom->UserVclassroom->save($this->request->data)):  
         $this->msgFlash(__('Shared'), '/admin/vclassrooms/share/'.$this->request->data['UserVclassroom']['vclassroom_id']);
     else:
         die(debug($this->Vclassroom->UserVclassroom->validationErrors));
     endif;
  endif;
 }

/**
 * Unshare
 * @access public
 * @param integer $vclassroom_id
 * @return void
 */
 public function admin_unshare($users_vclassroom_id, $vclassroom_id)
 {
  $this->layout    = 'admin';
  if ($this->Vclassroom->UserVclassroom->delete($users_vclassroom_id)):  
       $this->msgFlash(__('Unlinked'), '/admin/vclassrooms/share/'.$vclassroom_id);
  endif;
 }

/**
 * Generate PDF report  
 * @access public
 * @param integer $vclassroom_id
 * @return void
 */
 public function admin_export($vclassroom_id) 
 {
   $this->layout = 'pdf';
   $params = array(
                   'conditions'   => array('Vclassroom.id'=>$vclassroom_id),
                   'fields'       => array('Vclassroom.name', 'Vclassroom.created'),
                   'contain'      => False
                  );
   $this->set('group',$this->Vclassroom->find('first', $params));
   $this->set('data', $this->Vclassroom->recordClass($vclassroom_id));
 }

/** 
 * Export to Spreadsheet
 * @access public
 * @param integer $vclassroom_id
 * @return void
 */
 public function admin_spexport($vclassroom_id) 
 {
   $this->layout = Null;
   $this->autoLayout = false;
   $params = array('conditions' => array('Vclassroom.id'=>$vclassroom_id), 
                   'fields'     => array('Vclassroom.name', 'Vclassroom.created'),
                   'contain'    => False);
   $this->set('vclass', $this->Vclassroom->find('first', $params));
   $this->set('data',   $this->Vclassroom->recordClass($vclassroom_id));
 }

/**
 *  Popup to add EDI 
 *  @access public
 *  @param integer $vclassroom_id
 *  @return void
 */
 public function admin_dide($vclassroom_id)
 {
  $this->layout = 'popup';
  $this->set('vclassroom_id',  $vclassroom_id);
 }

/**
 *  Add student to vclassroom manually
 *  @access public
 *  @param integer $vclassroom_id
 *  @return void
 */
 public function admin_items($vclassroom_id=null)
 {
   $this->layout = 'ajax';

   if ( !empty($this->request->data['UserVclassroom'])):  
       #die(debug($this->request->data));
       $url =  '/admin/vclassrooms/members/'. $this->request->data['UserVclassroom']['vclassroom_id'];
       $this->request->data['UserVclassroom']['user_id']   = (int) $this->Vclassroom->UserVclassroom->User->field('id', array('active'=>1,'username'=>$this->request->data['UserVclassroom']['username']));
       if ( $this->request->data['UserVclassroom']['user_id']):
           $conditions = array('UserVclassroom.vclassroom_id'=> $this->request->data['UserVclassroom']['vclassroom_id'], 
                               'UserVclassroom.user_id'      => $this->request->data['UserVclassroom']['user_id']);  #'UserVclassroom.user_id' =>0
           $chk = $this->Vclassroom->UserVclassroom->field('id', $conditions);
           #die(var_dump($conditions));
           if ( $chk ):
               $msg = __('User already enrolled in this classroom'); 
           else:
               $this->request->data['UserVclassroom']['group_id']  = (int) 3; # student
               $this->request->data['UserVclassroom']['kind']      = (int) 0; # student  
               if ($this->Vclassroom->UserVclassroom->save($this->request->data)):
                   $msg = __('Student succesfully enrolled');
               endif;
           endif;  
       else:
           $msg = __('User not exist or is disabled'); 
       endif;
       $this->msgFlash($msg, $url);
       return;
   else:
       $this->set('vclassroom_id',  $vclassroom_id);
       $this->render('admin_items', 'ajax');
   endif;
 }

/**
 * Get Kandie type to attach Kandie->to->Vclassroom
 * @access public
 * @return void
 */
 public function admin_type()
 {
  #die(debug($this->request->data));
  $this->layout = 'ajax';
  $this->set('data', $this->__getEdi($this->request->data['Vclassroom']['type'], $this->request->data['Vclassroom']['id']));
  $this->render('admin_type', 'ajax');
 }

/**
 * Get didactic elements (Kandie)
 * @access private
 * @return mixed array or null
 */
 private function __getEdi($type, $vclassroom_id)
 {
  $data = array();
  switch($type):
      #Quizz Test
      case 0:
          $data['Test'] = $this->requestAction('/admin/tests/get/'.$vclassroom_id);  
          $data['Type'] = 'Test';
          break;
      #Webquest 
      case 1:
          $data['Webquest'] = $this->requestAction('/admin/webquests/getWq/'.$vclassroom_id);  
          $data['Type'] = 'Webquest';
          break;
      #Scavenger Hunt 
      case 2:
          $data['Treasure'] = $this->requestAction('/admin/treasures/getScaven/'.$vclassroom_id);
          $data['Type'] = 'Treasure';
          break;
      #Gap filling 
      case 3:
          $data['Gap']  = $this->requestAction('/admin/gaps/get/'.$vclassroom_id);  
          $data['Type'] = 'Gap';
          break;
      #SCORM
      case 4: 
          $data['Scorm'] = $this->requestAction('/admin/scorm/scorms/get/'.$vclassroom_id); 
          $data['Type']  = 'SCORM';
         break;
  endswitch;
  $data['vclassroom_id'] = $vclassroom_id;
  return $data;
  #die(debug($data));
 }

 public function admin_members($vclassroom_id)
 {
  $this->layout = 'admin';
  $this->set('data',  $this->Vclassroom->membersDetails($vclassroom_id));
 }

/**
 * link vclasrroom to test
 * @param
 */
 public function admin_tests($vclassroom_id)
 {
  $this->layout = 'popup';
  $params = array('conditions' => array('Vclassroom.user_id'=>$this->Auth->user('id'), 'Vclassroom.id'=>$vclassroom_id));
  $this->set('data', $this->Vclassroom->find('first', $params));    
  $this->Vclassroom->Test->unbindModel(array('hasMany'=>array('Question', 'Result'), 'belongsTo'=>array('User')));
  $params = array('conditions'=>array('Test.user_id'=>$this->Auth->user('id'), 'Test.status'=>1));
  $this->set('test', $this->Vclassroom->Test->find('all', $params));
 }

/*
 * link test to vClassroom 
 * 
 */
 public function admin_linktest()
 {
   if (!empty($this->request->data['TestVclassroom'])):
        #Sanitize::clean($this->request->data['TestVclassroom']); 
        unset($this->Vclassroom->TestVclassroom->id);
        if ( $this->Vclassroom->TestVclassroom->save($this->request->data)):
            $this->msgFlash(__('Test linked'), '/admin/vclassrooms/tests/'.$this->request->data['TestVclassroom']['vclassroom_id']);
	    endif;
   endif;
 }

/**
 * link webquest to classroom
 *
 */
 public function admin_webquest($vclassroom_id)
 {
   $this->layout = 'popup';
   $params = array('conditions' => array('Vclassroom.user_id'=>$this->Auth->user('id'), 'Vclassroom.id'=>$vclassroom_id));      
   $this->set('data', $this->Vclassroom->find('first', $conditions));
   $params = array('conditions' => array('Webquest.user_id'=>$this->Auth->user('id'), 'Webquest.status'=>1));
   $this->set('webquest', $this->Vclassroom->Webquest->find('all', $params));
 }

/**
 * link treasure to classroom
 *
 */
 public function admin_treasure($vclassroom_id)
 {
  $this->layout = 'popup';
  $params = array('conditions' => array('Vclassroom.user_id'=>$this->Auth->user('id'), 'Vclassroom.id'=>$vclassroom_id));
  $this->set('data', $this->Vclassroom->find('first', $params));
  $this->set('treasure', $this->Vclassroom->Treasure->find('all', array('conditions'=>array('Treasure.user_id'=>$this->Auth->user('id'), 'Treasure.status'=>1))));
 }

/**
 *  Show all reports sent by students in this VC
 *  @access public
 *  @param integer $vclassroom_id
 *  @return void
 */
 public function admin_start($vclassroom_id)
 {
  $this->layout = 'admin';
  $params = array('conditions' => array('Vclassroom.user_id'=>$this->Auth->user('id'), 'Vclassroom.id'=>$vclassroom_id));
  $this->set('data', $this->Vclassroom->Report->find('all', $params));
 }
 

/**
 *  Unlink student to VC
 *  @access public
 *  @param integer $user_id
 *  @param integer $vclassroom_id
 *  @return void
 */
 public function admin_unlink($user_id, $vclassroom_id)
 { 
   $users_vclassroom_id = $this->Vclassroom->UserVclassroom->field('id', 
                                                array('UserVclassroom.user_id'=>$user_id,'UserVclassroom.vclassroom_id'=>$vclassroom_id)); 
   if ( $this->Vclassroom->UserVclassroom->delete($users_vclassroom_id) ):
       $msg = __('Student unlinked');
   else:
       $msg = __('Problem founded');
   endif;
   $this->msgFlash($msg,'/admin/vclassrooms/members/'.$vclassroom_id);
 }


/**
 *  Link test to VC
 *  @access public
 *  @return void
 */
 public function admin_addtest() 
 {
  if (!empty($this->request->data)):
      #exit(var_dump($this->request->data));
      $this->request->data['Vclassroom'] = Sanitize::clean($this->request->data['Vclassroom']);
      if ($this->Vclassroom->addAssoc('Test', $this->request->data['Test']['id'], $this->request->data['Vclassroom']['id'])): //link vclassrooms_tests
          $this->msgFlash(__('Test linked'), '/');
      else:
          echo 'Problem please report bug';
      endif;
  endif;
 }

/**
 *  Show student record 
 *  @access public
 *  @param integer $student_id
 *  @param integer $vclassroom_id
 *  @return void
 */
 public function admin_record($student_id, $vclassroom_id) 
 {
   $this->layout    = 'admin';
   $this->set('data', $this->Vclassroom->studentRecord($student_id, $vclassroom_id));
 }

  
/**
 *  Send student his/her own record 
 *  @access public
 *  @param integer $student_id
 *  @param integer $vclassroom_id
 *  @return void
 */
 public function admin_add($student_id, $vclassroom_id) 
 {
   $this->layout    = 'ajax';
   $data = $this->Vclassroom->sendRecord($student_id, $vclassroom_id);
   $this->render('admin_add');
 }

/**
 *  Get student points in this vclassroom
 *  @access public
 *  @param integer $student_id
 *  @param integer $vclassroom_id
 *  @return void
 */
 public function admin_points($student_id, $vclassroom_id) 
 {
   $this->layout    = 'ajax';   
   $this->set('points', $this->Vclassroom->totalPoints($student_id, $vclassroom_id));
   $this->render('points', 'ajax');
 }

/**
 *  Add/Update vclassroom
 *  @access public
 *  @param mixed $ecourse_id
 *  @param mixed $vclassroom_id
 *  @return void
 */
 public function admin_edit($ecourse_id=Null, $vclassroom_id=Null)
 {
  $this->Vclassroom->Ecourse->contain();
  $this->set('ecourse', $this->Vclassroom->Ecourse->read(array('id', 'title'), $ecourse_id));
  $this->layout = 'admin';
  if (!empty($this->request->data['Vclassroom'])):
      if ( !isset($this->request->data['Vclassroom']['id']) ): # new VC
          $this->request->data['Vclassroom']['user_id']  = (int) $this->Auth->user('id');
      endif;
	
	  if (!empty($this->request->data['Vclassroom']['name'])):
   	      if ($this->Vclassroom->save($this->request->data)):
		      if ( !isset($this->request->data['Vclassroom']['id']) ):
		          $vclassroom_id  = $this->Vclassroom->getLastInsertID();
		          $this->request->data['UserVclassroom']['vclassroom_id'] = (int) $vclassroom_id;
		          $this->request->data['UserVclassroom']['user_id']       = (int) $this->Auth->user('id');
		          $this->request->data['UserVclassroom']['group_id']      = (int) $this->Auth->user('group_id');
		          # kind   | smallint | not null default 0  | Owner 1, tuthor 2, or student 0
		          $this->request->data['UserVclassroom']['kind']          = (int) 1; # teacher and owner
		          $this->Vclassroom->UserVclassroom->save($this->request->data);
		      endif;
		      #die('Saved');
		      if ( $this->request->data['Vclassroom']['end'] == 1 ):
		        $url = (string) '/admin/ecourses/vclassrooms/'. $this->request->data['Vclassroom']['ecourse_id'];
		      else:
		        $vclassroom_id = isset($this->request->data['Vclassroom']['id']) ? $this->request->data['Vclassroom']['id'] : $vclassroom_id;
		        $url = (string) '/admin/vclassrooms/edit/'.$this->request->data['Vclassroom']['ecourse_id'].'/'.$vclassroom_id;
		     endif;    
			 $this->msgFlash(__('Data saved'), $url);    
		 endif;
      endif;
  elseif($vclassroom_id != Null && intval($vclassroom_id)):
      $this->request->data = $this->Vclassroom->read(Null, $vclassroom_id);
  endif;
 }


/**
 *  Change status published/draft 
 *  @access public
 *  @param integer $vclassroom_id
 *  @param integer $status
 *  @param integer $ecourse_id
 *  @param integer $compact
 *  @return void
 */
 public function admin_change($vclassroom_id, $status, $ecourse_id, $compact=null)
 {
    $new_status = ($status == 0 ) ? 1 : 0;
    
    $this->Vclassroom->id   = (int) $vclassroom_id;
    
    if ($this->Vclassroom->saveField('status', $new_status)):
        if ($compact == null):
            $return = (string) '/admin/ecourses/vclassrooms/'.$ecourse_id;
        else:
            $return = (string) '/admin/vclassrooms/listing'; # compact view
        endif;
        $this->msgFlash(__('Status modified'),$return);
    endif;
 }

/**
 *  Disable little message in show.ctp view
 *  @access public
 *  @param integer $vclassroom_id
 *  @param string  $username
 *  @return void
 */
 public function admin_hide($vclassroom_id, $username)
 { 
   if ($this->Vclassroom->saveField('message', False)):
       $this->msgFlash(__('Data saved'), '/vclassrooms/show/'. $username.'/'.$vclassroom_id);
   endif;
 }

/**
 *  Enable/disable chat in vclassroom
 *  @access public
 *  @param integer $vclassroom_id
 *  @param integer $vclassroom_id
 *  @return void
 */
 public function admin_chat($vclassroom_id, $chat)
 {
  $new_chat   = ($chat == 0 ) ? 1 : 0;
  $this->Vclassroom->id = (int) $vclassroom_id;
  if ($this->Vclassroom->saveField('chat', $new_chat)):
      $this->msgFlash(__('Status modified'), '/admin/chats/record/'.$vclassroom_id);
  endif;
 }

/**
 *  Enable/disable videconference in vclassroom
 *  @access public
 *  @param integer $vclassroom_id
 *  @param integer $vclassroom_id
 *  @return void
 */
 public function admin_edactivity($vclassroom_id, $videoconference)
 {
  $new_videoconference  = ( $videoconference == 0 ) ? 1 : 0;
  $this->Vclassroom->id = (int) $vclassroom_id;
  if ($this->Vclassroom->saveField('videoconference', $new_videoconference)):
      $this->msgFlash(__('Status modified'), '/admin/chats/record/'.$vclassroom_id);
  endif;
 }

/**
 *  Remove vclassroom
 *  @access public
 *  @param integer $vclassroom_id
 *  @param integer $ecourse_id
 *  @return void
 */
 public function admin_delete($vclassroom_id, $ecourse_id)
 {
  if ($this->Vclassroom->delete($vclassroom_id)):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif;
  $this->msgFlash($msg,'/admin/ecourses/vclassrooms/'.$ecourse_id);
 }

/**
 *  Show possible Kandies to be linked to current vClassroom (Ajax call)
 *  @access public
 *  @param integer $vclassroom_id
 *  @return void
 */
 public function admin_newkm($vclassroom_id)
 {
   $this->layout = 'ajax';
   $this->set('vclassroom_id', $vclassroom_id);
   $this->render('admin_newkm', 'ajax');
 }

/**
 *  Show Kandies currently linked to current vClassroom
 *  @access public
 *  @param integer $vclassroom_id
 *  @return void
 */
 public function admin_ekm($vclassroom_id)
 {
   $this->layout = 'ajax';
   $this->set('data', $this->Vclassroom->getKandies($vclassroom_id));
   $this->render('admin_ekm', 'ajax');
 }
}

# ? > EOF
