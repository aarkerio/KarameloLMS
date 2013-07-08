<?php
/**
 *  @copyright  2009-2012,  Chipotle Software(c)
 *  @license	http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License Version 3
 */

App::uses('Sanitize', 'Utility');

class ScormsController extends ScormAppController {

 public $uses = array('Scorm.Scorm');

/**
 *  CakePHP
 *  @access public
 *  @var array
 */
 public  $components = array('Edublog');

/**
 *  CakePHP
 *  @access public
 *  @var array
 */ 
public  $helpers    = array('Js','Time');
 
/**
 *  Auth Component permisssions
 *  @access public
 *  @return void 
 */ 
public function beforeFilter() 
 {
   parent::beforeFilter();
   $actions = array('display', 'index');
   if ( $this->Auth->user('id') ):
      array_push($actions, 'view', 'loadsco', 'loadapi', 'save', 'finish');
   endif;
   $this->Auth->allow($actions);
 }

/**
 *   Load and view SCORM as Kandie
 *   @access public
 *   @param integer $scorm_id
 *   @param string  $username
 *   @param integer $vclassroom_id
 *   @return void 
 */
 public function view($scorm_id, $username, $vclassroom_id)
 {
   $this->Edublog->setUserId($username);
   $this->Edublog->checkPermissions($vclassroom_id, $scorm_id, 'Scorm', $this->Auth->user('id'));
   if ( !$scorm_id ):
       $this->msgFlash(__('Invalid Scorm'), '/blog/'.$username);
   endif;
   $this->layout = 'scorm';
   $params = array('conditions' => array('Scorm.id'=>$scorm_id),
                   'contain'    => array('ScormsSco',
                                         'ScormVclassroom'=>array('conditions'=>array('scorm_id'=>$scorm_id, 'vclassroom_id'=>$vclassroom_id))
                  ));
   $data = $this->Scorm->find('first', $params);
   #die(debug($data));
   $this->set('vclassroom_id', $vclassroom_id);
   $this->set('data', $data);
 }

/**
 *   Load SCO in iframe
 *   @access public
 *   @param integer $sco_id
 *   @param integer $vclassroom_id
 *   @param integer $scorm_id
 *   @return void 
 */
 public function loadapi($sco_id, $vclassroom_id, $scorm_id, $api) 
 {
   $this->layout = False;
   $this->set('api', $api);
   $this->__initializeElements($sco_id, $vclassroom_id, $scorm_id);
 }

/**
 *   Load SCO in iframe
 *   @access public
 *   @param integer $scoid
 *   @return void 
 */
 public function loadsco($sco_id, $vclassroom_id) 
 {
   $this->viewClass = 'Scorm.Scorm';
   $params = array('conditions'=>array('ScormsSco.id' => $sco_id));
   $data   = $this->Scorm->ScormsSco->find('first', $params);
   #die(debug($data));
   $path   = $this->Scorm->field('Scorm.path', array('Scorm.id' => $data['ScormsSco']['scorm_id']));  # system path
   #die(debug($path));
   $this->set('data',$data);
   $this->set('path', $path);
 }

/**
 *  Initialize SCORM
 *  @access private
 *  @return void
 */
 private function __initializeElements($sco_id, $vclassroom_id, $scorm_id) 
 {
   # data to save info in ResultScorm model 
   $this->request->data['ResultScorm']['vclassroom_id'] = (int) $vclassroom_id;
   $this->request->data['ResultScorm']['sco_id']        = (int) $sco_id;
   $this->request->data['ResultScorm']['scorm_id']      = (int) $scorm_id;
   $this->request->data['ResultScorm']['user_id']       = (int) $this->Auth->user('id');
 
   # elements that tell the SCO which other elements are supported by this API
   $initVals = array('cmi.core.score.raw'  => '');
   $initVals['cmi.core.score.max']         =  '';
   $initVals['cmi.core.score.min']         =  '';
   $initVals['cmi.comments']               =  '';

   $comments_from_lms = (string) $this->Scorm->ScormsSco->field('datafromlms', array('ScormsSco.id'=>$sco_id));   # Get from LMS
   if (  !$comments_from_lms ):
       $initVals['cmi.comments_from_lms'] = '';
   else:
       $initVals['cmi.comments_from_lms'] =  $comments_from_lms;
   endif; 

   # student information
   $initVals['cmi.core.student_name'] = (string) $this->Auth->user('username');   # Get from LMS
   $initVals['cmi.core.student_id']   = (int) $this->Auth->user('id');            # Get from LMS
   
   # mastery test score from IMS manifest XML file
   $initVals['cmi.student_data.mastery_score']     = $this->Scorm->ScormsSco->field('masteryscore', array('ScormsSco.id'=>$sco_id));  # Get from LMS
   $initVals['cmi.student_data.max_time_allowed']  = $this->Scorm->ScormsSco->field('maxtimeallowed', array('ScormsSco.id'=>$sco_id));
   $initVals['cmi.student_data.time_limit_action'] = $this->Scorm->ScormsSco->field('timelimitaction', array('ScormsSco.id'=>$sco_id));

   $this->Scorm->ResultScorm->conditions = array('sco_id'=>$sco_id, 'vclassroom_id'=>$vclassroom_id, 'user_id' => $initVals['cmi.core.student_id']); 
   # SCO launch data from IMS manifest file 
   # If not set, cmi.launch_data should be set to either
   # a value from the IMS manifest file (adlcp:datafromlms), or an empty string
   $cmi_launch_data = (string) $this->Scorm->ScormsSco->field('datafromlms', array('ScormsSco.id'=>$sco_id));   # Get from LMS
   if (  !$cmi_launch_data ):
       $initVals['cmi.launch_data'] = '';
   else:
       $initVals['cmi.launch_data'] =  $cmi_launch_data;
   endif;
   
   # progress and completion tracking
   $initVals['cmi.core.credit']        = 'credit';   # Get from LMS. In Karamelo: always is 'credit'  
   
   # Lesson status 
   $lesson_status = $this->Scorm->ResultScorm->getValue('cmi.core.lesson_status');
   if (  !$lesson_status ):
       $initVals['cmi.core.lesson_status'] = 'not attempted'; # passed, completed, failed, incomplete,  browsed,  not attempted   # Get from LMS
   else:
       $initVals['cmi.core.lesson_status'] = $lesson_status;
   endif;
   
   # entry
   $entry = $this->Scorm->ResultScorm->getValue('cmi.core.entry');
   if (  !$entry ):
       $initVals['cmi.core.entry'] = 'ab initio'; # passed, completed, failed, incomplete,  browsed,  not attempted   # Get from LMS
   else:
       $initVals['cmi.core.entry'] = $entry;
   endif;
   # Location 
   $initVals['cmi.core.lesson_location']  = '';  # ab initio or resume
  
  # core.exi
   $core_exit = $this->Scorm->ResultScorm->getValue('cmi.core.exit');
   if ( !$core_exit ):
       $initVals['cmi.core.exit'] = ''; 
   else:
       $initVals['cmi.core.exit'] = $core_exit; # "time-out", "logout", "suspend", or and empty string.
   endif;

   # total seat time        http://www.vsscorm.net/2009/07/14/step-17-cmi-core-total_time-and-cmi-core-session_time/
   $total_time = (string) $this->Scorm->ResultScorm->getValue('cmi.core.total_time');
   if ( !$total_time ):
       $initVals['cmi.core.total_time'] = '0000:00:00';
   else:
       $initVals['cmi.core.total_time'] = $total_time;
   endif;
   
   # new session so clear pre-existing session time
   $session_time = (string) $this->Scorm->ResultScorm->getValue('cmi.core.session_time');
   if ( !$total_time ):
       $initVals['cmi.core.session_time'] = '0000:00:00';
   else:
       $initVals['cmi.core.session_time'] = $session_time;
   endif;
  
  # Lesson mode
   $lesson_mode = (string) $this->Scorm->ResultScorm->getValue('cmi.core.lesson_mode');
   if ( !$lesson_mode ):
       $initVals['cmi.core.lesson_mode'] = 'normal';
   else:
       $initVals['cmi.core.lesson_mode'] = $lesson_mode;
   endif;
    
   #suspend data
   $suspend_data = (string) $this->Scorm->ResultScorm->getValue('cmi.suspend_data');
   if ( !$suspend_data ):
       $initVals['cmi.suspend_data'] = ''; 
   else:
       $initVals['cmi.suspend_data'] = $suspend_data; # "time-out", "logout", "suspend", or and empty string.
   endif;

   $initVals['sco_id']        = (int) $sco_id;
   $initVals['scorm_id']      = (int) $scorm_id;
   $initVals['vclassroom_id'] = (int) $vclassroom_id;

   #die(debug($initVals));
   $this->set('initVals',  $initVals);
}

/**
 *  Save student data and result
 *  @access public
 *  @return void 
 */ 
  /** Save SCORM */
 public function save() 
 {
  #die(debug($this->request));
/*
      lesson_location=" + datamodel['cmi.core.lesson_location'];
      sco_id,
      'code',
      lesson_status="   + datamodel['cmi.core.score.lesson_status'].defaultvalue;
      entry="           + datamodel['cmi.core.entry'].defaultvalue;
      raw="             + datamodel['cmi.core.score.raw'].defaultvalue;
      credit="          + datamodel['cmi.core.credit'].defaultvalue;
      mastery_score ="  + datamodel['cmi.student_data.mastery_score'].defaultvalue;
      total_time="      + datamodel['cmi.core.total_time'].defaultvalue;
      session_time="    + datamodel['cmi.core.session_time'].defaultvalue;
      suspend_data="    + datamodel['cmi.suspend_data'].defaultvalue;
      scoreMin="        + datamodel['cmi.core.score.min'].defaultvalue;
      scoreMax="        + datamodel */
  $this->autoRender = False;
  $arrayData = array();
  $arrayData['ResultScorm']['user_id']       = (int) $this->Auth->user('id');     # student id
  $arrayData['ResultScorm']['scorm_id']      = $this->request->data['scorm_id'];
  $arrayData['ResultScorm']['sco_id']        = $this->request->data['sco_id'];
  $arrayData['ResultScorm']['vclassroom_id'] = $this->request->data['vclassroom_id'];
  foreach ($this->request->data as $key => $value):
      $arrayData['ResultScorm']['varname']       = $key;
      $arrayData['ResultScorm']['varvalue']      = $value;
      #die(pr($this->request->data['ResultScorm']));
      $this->Scorm->ResultScorm->create();
      if ($this->Scorm->ResultScorm->save($arrayData)):
          $this->Session->setFlash(__('The Scorm saved'));
      else:
	        $this->Session->setFlash(__('The Scorm could not be saved. Please, report to SysAdmin.'));
      endif;
   endforeach; 
 }

/**
 *  Finish
 *  @access public
 *  @return void 
 */ 
public function finish()
{
  $this->layout= Null;
}
/*== ADMIN METHODS ==*/

/**
 *  Display all SCORMs
 *  @access public
 *  @return void
 */
 public	function admin_listing() 
 {
  $this->layout = 'admin';
  $params = array('conditions'   => array('Scorm.user_id'=>$this->Auth->user('id')),
                  'fields'       => array('Scorm.id', 'Scorm.name', 'Scorm.popup', 'Scorm.status'),
                  'limit'        => 20,
                  'order'        => 'Scorm.id DESC',
                  'contain'      => False);
  $this->set('data', $this->Scorm->find('all', $params));
 }

/**
 *  Display form to import SCORM
 *  @access public
 *  @return void
 */
 public function admin_import() 
 {
  $this->layout = 'admin';
 }

/**
 *   Import scorm from zip file uploaded by teacher
 *   @access public
 *   @return void 
 */
 public	function admin_add() 
 {
   $this->layout = 'admin';
   if ($this->request->data['Scorm']['file']['error'] == 1):
       $this->flash(__('Error uploading file'), '/admin/scorm/scorms/listing');
       return False;
   endif;
   $this->Scorm->userId  = (int) $this->Auth->user('id');   # teacher id
   $this->Scorm->passData($this->request->data['Scorm']);   # pass data to model
   $this->Scorm->unZip();
   if ( !$this->Scorm->importManifest() ):
       die('Error!');
   else:
       $this->msgFlash(__('SCORM Added'), '/admin/scorm/scorms/listing');
   endif;
 }

/**
 *  Edit all SCORM info
 *  @access public
 *  @param integer $scorm_id
 *  @return void
 */
 public function admin_edit($scorm_id = Null) 
 {
   if (!$scorm_id && empty($this->request->data)):
       $this->msgFlash(__('Invalid Scorm'), '/admin/scorm/scorms/listing');
   endif;

   if (!empty($this->request->data)):
      if ($this->Scorm->save($this->request->data)):
          $this->msgFlash(__('Data saved'), '/admin/scorm/scorms/listing');
      else:
          $this->msgFlash(__('Problem saving'), '/admin/scorm/scorms/listing');	      
      endif;
   endif;
   if (empty($this->request->data)):
       $this->request->data = $this->Scorm->read(Null, $scorm_id);
   endif;
 }
 
/**
 * Change status enabled/disabled actived
 * @access public
 * @param integer $scorm_id
 * @param integer $status
 * @return void 
 */
 public function admin_change($scorm_id, $status)
 { 
   $new_status      = ($status == 0 ) ? 1 : 0;     
   $this->Scorm->id = (int) $scorm_id;
   if ($this->Scorm->saveField('status', $new_status)):
       $this->msgFlash(__('Status modified'), '/admin/scorm/scorms/listing');
   endif;
 } 

/**
 *  Return gaps owned by teacher
 *  @access public
 *  @return void
 */
 public function admin_get($vclassroom_id) 
 {
   return $this->Scorm->getScorms($this->Auth->user('id'), $vclassroom_id);
 } 

/**
 * Change view way
 * @access public
 * @param integer $scorm_id
 * @param integer $status
 * @return void 
 */
 public function admin_view($scorm_id, $status)
 { 
  $new_status      = ($status == 0 ) ? 1 : 0;     
  $this->Scorm->id = (int) $scorm_id;
  if ($this->Scorm->saveField('popup', $new_status)):
      $this->msgFlash(__('Status modified'), '/admin/scorm/scorms/listing');
  endif;
 }

/**
 *  Link to vClassroom
 *  @access public
 *  @return void
 */
 public function admin_link2class() 
 {
  $this->layout    = 'admin';
  if ( !empty($this->request->data['ScormVclassroom']) ):
      $this->request->data['ScormVclassroom'] = Sanitize::clean($this->request->data['ScormVclassroom']);
      if ( $this->Scorm->ScormVclassroom->save($this->request->data)):
          if ( isset($this->request->data['ScormVclassroom']['popup']) ):
              $return = (string) '/admin/vclassrooms/dide/'.$this->request->data['ScormVclassroom']['vclassroom_id'];
          else:
              $return = (string) '/admin/scorms/vclassrooms/'.$this->request->data['ScormVclassroom']['scorm_id'];
          endif;
          $this->msgFlash(__('Scorm Filling linked'), $return);
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
  if ( !empty($this->request->data['ScormVclassroom']) ):
      #die(debug($this->request->data));
      if ( $this->Scorm->ScormVclassroom->delete($this->request->data['ScormVclassroom']['id'])):
          if (isset($this->request->data['ScormVclassroom']['popup'])):
              $return =  '/admin/vclassrooms/dide/'.$this->request->data['ScormVclassroom']['vclassroom_id'];
          else:
              $return =  '/admin/scorms/vclassrooms/'.$this->request->data['ScormVclassroom']['scorm_id'];
          endif;
          $this->msgFlash(__('Kandie unlinked'), $return);
      endif;
  endif;
 }

/**
 *  Edit linked Kandie to vClassroom
 *  @access public
 *  @return void
 */
 public function admin_ekandie() 
 {
   $this->layout = 'ajax';
   $this->request->data = $this->Scorm->ScormVclassroom->read(Null, $this->request->data['ScormVclassroom']['id']);
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
   if ( $this->Scorm->ScormVclassroom->save($this->request->data) ):
       $msg = __('Data saved');
   else:
       $msg = __('Data NOT saved');
   endif; 
   $this->msgFlash($msg, '/admin/vclassrooms/dide/'.$this->request->data['ScormVclassroom']['vclassroom_id']);
  }

/**
 * Remove SCORM
 * @access public
 * @param integer $scorm_id
 * @return void 
 */
 public	function admin_delete($scorm_id) 
 {
  if ($this->Scorm->delete($scorm_id)):
      # $path = $this->Scorm->field('Scorm.path', array('Scorm.id'=>$scorm_id)); 
      # $this->Scorm->rmdirr($path);
      $this->msgFlash(__('Data removed', True), '/admin/scorm/scorms/listing');
  endif;
 }
}

# ? > EOF
