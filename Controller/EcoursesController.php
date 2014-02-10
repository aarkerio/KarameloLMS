<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package ecourses
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /APP/Controller/EcoursesController.php

/**
 * load libraries
 */
App::uses('Sanitize', 'Utility');

class EcoursesController extends AppController {

/**
 * Cake helpers
 * @access public
 * @var array
 */

 public  $helpers     = array('Ck', 'Gcalendar', 'Wizard.Wizard');

/**
 * Wizard component need this
 * @access public
 * @var array
 */
 public  $uses        = array('Ecourse');

/**
 * Cake components
 * @access public
 * @var array
 */
 public  $components  = array('Wizard.Wizard', 'Session'); 

/**
 *  Cake paginate
 *  @var array
 *  @access public
 */ 
 public $paginate = Null;
 
/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */  
 public function beforeFilter() 
 {
   $perms = array('display', 'activity', 'description');
   parent::beforeFilter();
   if ($this->Auth->user('group_id') > 2):
        array_push($perms,  '_afterComplete');
   endif;
   $this->Auth->allow($perms);

   # Wizard  Component
   $this->Wizard->WizardAction = 'admin_wizard';
   $this->Wizard->steps        = array('admin_wzdone', 'admin_wzdtwo', 'admin_wzdthree');
   $this->Wizard->completeUrl  = '/admin/ecourses/finish'; 
   $this->Wizard->cancelUrl    = '/admin/ecourses/display'; 
   $this->Wizard->validate     = False;  
 }

/**
 * Active ecourses, loaded in vclassrooms*
 * @access public
 * @return void 
 */
 public function display()
 {
  $this->layout    = 'portal';
  $this->set('data', $this->Ecourse->getEcourses());
 }

/**
 *  Get ecourse details through ajax
 *  @access public
 *  @return void 
 */
 public function description($ecourse_id)
 {
   $conditions = array('Ecourse.id'=>$ecourse_id);
   $this->set('data', $this->Ecourse->field('Ecourse.description', $conditions));
   $this->set('minutes', $this->Ecourse->getMinutes($ecourse_id));
   $this->render('description', 'ajax');
 }

/**
 *   get activity details through ajax
 * @access public
 * @return void 
 */
 public function activity()
 {
  #die(debug($this->request->data));
   $params = array('conditions' => array('Activity.id'=>$this->request->data['Activity']['id']),
                   'fields'     => array('Activity.activity', 'Activity.points', 'Activity.minutes'));
   $this->set('data', $this->Ecourse->Activity->find('first', $params));
   $this->render('activity', 'ajax');
 }

/****===== ADMIN SECTION ========== ****/
/**
 *  Display eCourses
 *  @access public
 *  @return void 
 */
 public function admin_listing()
 {
  $this->layout    = 'admin';
  $this->paginate['Ecourse'] = array(
        'conditions'   =>  array('Ecourse.user_id'=>$this->Auth->user('id')),
        'fields'       =>  array('Ecourse.id', 'Ecourse.title', 'Ecourse.status', 'Ecourse.description'),
        'order'        =>  'Ecourse.title',
        'limit'        =>  30);
  $data = $this->paginate('Ecourse');
  #die(debug($data));
  $this->set(compact('data'));
 }

/**== ACTIVITIES RELATED METHODS --==*/
/**
 *  Display activities in eCourse
 *  @access public
 *  @param integer $ecourse_id
 *  @return void 
 */
 public function admin_activities($ecourse_id)
 {
  $this->layout = 'admin';  
  $data = $this->Ecourse->getActivities($this->Auth->user('id'), $ecourse_id);
  $this->set('data', $data);
 }

/**
 *  Ajax call 
 *  @access public
 *  @param integer $ecourse_id
 *  @return void 
 */
 public function admin_newactivity($ecourse_id)
 {   
  $this->layout = 'ajax';
  $this->set('ecourse_id', $ecourse_id);
  $this->render('admin_edactivity', 'ajax');
 } 

/**
 *  Update activity order select two rows and intrechang order depending sense and order
 *  sense int  up or down
 *  order int  current value in column Activity.order  
 *  Kind a bubble sort  
 *  @access public
 *  @return void
 */
 public function admin_order($sense, $activity_id, $order, $ecourse_id)
 {
  if ($sense == 'up'):
       $conditions = array('Activity.order <= ' .$order, 'Activity.ecourse_id'=>$ecourse_id); # next up
       $order      =  'order DESC';
  else:
       $conditions = array('Activity.order >= '.$order, 'Activity.ecourse_id'=>$ecourse_id);  # next down
       $order      =  'order ASC'; 
  endif;  
  $params = array(
             'conditions' => $conditions,
             'order'      => $order,
             'fields'     => array('id', 'order'),
             'limit'      => 2
             );
  $data = $this->Ecourse->Activity->find('all', $params);
  #die(debug($data));
  for($i=0;$i < 2;$i++):
      if ($i === 0):
         $this->Ecourse->Activity->id = $data[0]['Activity']['id'];
         $new_order = $data[1]['Activity']['order'];
      else:
         $this->Ecourse->Activity->id = $data[1]['Activity']['id'];
         $new_order = $data[0]['Activity']['order'];
      endif;
      $this->Ecourse->Activity->saveField('order', $new_order);    
  endfor;
  $this->msgFlash(__('Data saved'), '/admin/ecourses/activities/'.$ecourse_id.'#mtable');
 }
 
/**
 *  Add/Edit activity 
 *  @access public
 *  @param mixed integer or null $actvity_id
 *  @return void 
 */
 public function admin_edactivity($activity_id=null)
 {
  $this->layout = 'admin';
  #die(debug($this->request->data));
  if (!empty($this->request->data['Activity'])):
      if ( !isset($this->request->data['Activity']['id']) ):
          $this->request->data['Activity']['user_id'] = (int) $this->Auth->user('id');
          $order = $this->Ecourse->Activity->field('order',array('Activity.ecourse_id'=>$this->request->data['Activity']['ecourse_id']),'order DESC');
 	      if ( !$order ):
              $order = (int) 1;
          else:
              $order = (int) $order + 1;
          endif;
         #die(var_dump($order));
         $this->request->data['Activity']['order']   = (int) $order;
      endif;
      if ($this->Ecourse->Activity->save($this->request->data)):
         $msg = (string) __('Data saved');
         if ( $this->request->data['Activity']['end'] == 0):
             if ( !isset($this->request->data['Activity']['id']) ):
                 $id = (int) $this->Ecourse->Activity->getLastInsertID();
                 $url = '/admin/ecourses/edactivity/'.$id;
             else:    
                 $url = '/admin/ecourses/edactivity/'.$this->request->data['Activity']['id'];
             endif;
         else:
             $url = '/admin/ecourses/activities/'.$this->request->data['Activity']['ecourse_id'];
         endif;
         $this->msgFlash($msg, $url);
      endif;
   else:
      $this->Ecourse->Activity->contain(False);
      $this->request->data = $this->Ecourse->Activity->read(Null, $activity_id);
   endif;
 }
 /*== ACTIVITIES ENDS==*/

/**
 *  
 *  @access public
 *  @return void 
 */
 public function admin_vclassrooms($ecourse_id, $historic = null)
 {
  $this->layout = 'admin';
  if ( $historic === 'historic' ):
     $this->Ecourse->filed(); # show filed classrooms
     $this->set('historic');
  endif;
  $params = array(
                 'conditions'=> array('Ecourse.user_id'=>$this->Auth->user('id'), 'Ecourse.id'=>$ecourse_id),
                 'order'     => 'Ecourse.title DESC'
                 );
  $this->set('data', $this->Ecourse->find('first', $params));
 }

/**
 *  Load in edublog  /vclassroom/show   (Ajax Call) 
 *  @access public
 *  @param integer $ecourse_id
 *  @return void 
 */
 public function admin_details($ecourse_id)
 {
     $params = array('conditions' => array('Ecourse.id'=>$ecourse_id),
                     'fields'     => array('description', 'created', 'code'),
                     'contain'    => False);
    $this->set('data', $this->Ecourse->find('first', $params));
    $this->render('admin_details', 'ajax');
  }

/**
 *  
 *  @access public
 *  @return void 
 */
  public function admin_change($ecourse_id, $status)
  {
    $new_status = ($status == 0 ) ? 1 : 0;
    $this->Ecourse->id = (int) $ecourse_id;
    if ($this->Ecourse->saveField('status', $new_status)):
        $this->msgFlash(__('Status modified'), '/admin/ecourses/listing/');
    endif;
 }

/**
 *  
 *  @access public
 *  @return void 
 */
 public function admin_changeactivity($activity_id, $ecourse_id, $status)
 {
    $new_status = ($status == 0 ) ? 1 : 0;
    $this->Ecourse->Activity->id = (int) $activity_id;

    if ($this->Ecourse->Activity->saveField('status', $new_status)):
             $this->msgFlash(__('Status modified'), '/admin/ecourses/activities/'.$ecourse_id);
    endif;
 }

/**
 *  
 *  @access public
 *  @return void 
 */
 public function admin_edit($ecourse_id = null)
 {
    $this->layout = 'admin';
    $this->set('subjects',
                 Set::combine($this->Ecourse->Subject->find('all', array('order' => 'title')), "{n}.Subject.id","{n}.Subject.title"));
    $this->set('langs', Set::combine($this->Ecourse->Lang->find('all', array('order' => 'lang')), "{n}.Lang.id","{n}.Lang.lang"));
    
    if ( !empty($this->request->data) ):
        #die(debug($this->request->data));
        if ( !isset($this->request->data['Ecourse']['id']) ):
           $this->request->data['Ecourse']['user_id'] = (int) $this->Auth->user('id');
        endif;
        if ($this->Ecourse->save($this->request->data)):
            if ($this->request->data['Ecourse']['end'] == 0 && !isset($this->request->data['Ecourse']['id'])):
                $id = $this->Ecourse->getLastInsertID();
                $return = '/admin/ecourses/edit/'.$id;    
            elseif ($this->request->data['Ecourse']['end'] == 0 && isset($this->request->data['Ecourse']['id'])):
                $return = '/admin/ecourses/edit/'.$this->request->data['Ecourse']['id'];
	        elseif ($this->request->data['Ecourse']['end'] == 1 ):
	             $return = '/admin/ecourses/listing';
	        endif;
            $this->msgFlash(__('Data saved',True), $return);
	    endif;
    elseif($ecourse_id != null && intval($ecourse_id)):
        $this->Ecourse->contain();  
        $this->request->data = $this->Ecourse->read(null, $ecourse_id);
    endif;
 }

/**
 *  Remove eCourse 
 *  @access public
 *  @return void 
 */ 
 public function admin_delete($ecourse_id)
 {
  if ( $this->Ecourse->delete($ecourse_id, True)):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/ecourses/listing');
 } 
 
/**
 *  Remove activity  
 *  @access public
 *  @return void 
 */
 public function admin_delactivity($activity_id, $ecourse_id)
 {
  if ( $this->Ecourse->Activity->delete($activity_id)):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/ecourses/activities/'.$ecourse_id);
 }

/**
 *  Display eCourse to Assign a teacher  
 *  @access public
 *  @return void 
 */
 public function admin_assign()
 {
  $this->layout = 'admin';
  $params = array('order'     => 'Ecourse.title', 
                  'conditions'=> array('Ecourse.shared'=>True, 'Ecourse.status'=>1), 
                  'fields'    => array('Ecourse.id', 'Ecourse.title'));
  $this->set('ecourses',$this->Ecourse->find('list',$params));
  $params = array('order'=>'User.username', 
                  'conditions'=> array('User.id !='=>2,'User.active'=>1, 'User.group_id <'=> 3), 'fields'=>array('id', 'username'));
  #die(debug($this->Ecourse->User->find('list',$params)));
  $this->set('users', $this->Ecourse->User->find('list',$params));
 }

/**
 *  Wizard beggins  
 *  @access public
 *  @return void 
 */
 public function admin_wizard($step = null) 
 {
   if ($step =='admin_wzdone'):
       $this->set('subjects', Set::combine($this->Ecourse->Subject->find('all', array('order' => 'title')), 
                      "{n}.Subject.id","{n}.Subject.title"));
       $this->set('langs', Set::combine($this->Ecourse->Lang->find('all', array('order' => 'lang')), "{n}.Lang.id","{n}.Lang.lang"));
   endif;
  
   $this->layout = 'admin'; 
   $this->Wizard->process($step);
 } 

/**
 *  [Wizard Process 1 Callbacks]
 *  @acces public
 *  @return void
 */
 public function _processAdminWzdone() 
 {
  $this->Ecourse->set($this->request->data);
  return True;
 }

/**
 *  [Wizard Process 2 Callbacks]
 *  @acces public
 *  @return void
 */
 public function _processAdminWzdtwo() 
 {
  $this->Ecourse->set($this->request->data);
  return True;
 }

/**
 *  [Wizard 3 Process Callbacks]
 *  @acces public
 *  @return boolean
 */
 public function _processAdminWzdthree() 
 {
  $this->Ecourse->set($this->request->data);
  return True;
 }

/**
 *  [Wizard Process Callbacks] Finish
 *  @acces public
 *  @return void
 */
 public function admin_finish() 
 {
  $this->layout = 'admin';
  $ecourse_id   = (int) $this->Session->read('Ecourse.id');
  $this->set('ecourse_id', $ecourse_id);
 } 
 
 /**
  * [Wizard Completion Callback]
  */
 public function _afterComplete() 
 {
  #die('I am in afterComplete');

  $this->Ecourse->id = null;
  
  $this->request->data['Ecourse']['user_id']     =  (int) $this->Auth->user('id');    
  $this->request->data['Ecourse']['subject_id']  =  (int) $this->Wizard->read('admin_wzdone.Ecourse.subject_id');
  $this->request->data['Ecourse']['percentage']  =  (int) $this->Wizard->read('admin_wzdone.Ecourse.percentage');
  $this->request->data['Ecourse']['lang_id']     =  (int) $this->Wizard->read('admin_wzdone.Ecourse.lang_id');  
  $this->request->data['Ecourse']['kind']        =  (int) $this->Wizard->read('admin_wzdone.Ecourse.kind');
  $this->request->data['Ecourse']['title']       =  trim($this->Wizard->read('admin_wzdone.Ecourse.title'));
  $this->request->data['Ecourse']['status']      =  $this->Wizard->read('admin_wzdthree.Ecourse.status') ? '1' : '0';
  $this->request->data['Ecourse']['code']        =  $this->Wizard->read('admin_wzdtwo.Ecourse.code');    
  
  $description  =  '<h1>'.__('Description') .'</h1>';
  $description .=  nl2br($this->Wizard->read('admin_wzdone.Ecourse.description'));
  $description .=  '<h1>'.__('Learning Outcomes') .'</h1>';
  $description .=  nl2br($this->Wizard->read('admin_wzdtwo.Ecourse.outcomes'));
  $description .=  '<h1>'.__('Prospective Audience') .'</h1>';
  $description .=  nl2br($this->Wizard->read('admin_wzdtwo.Ecourse.audience'));
  $description .=  '<h1>'.__('Syllabus') .'</h1>';
  $description .=  nl2br($this->Wizard->read('admin_wzdthree.Ecourse.syllabus'));
  $description .=  '<h1>'.__('References') .'</h1>';
  $description .=  nl2br($this->Wizard->read('admin_wzdthree.Ecourse.references'));

  $this->request->data['Ecourse']['description'] =  $description;      

  #die(debug($this->request->data));
  if ( $this->Ecourse->save($this->request->data) ):
      $this->Session->write('Ecourse.id',  $this->Ecourse->getLastInsertID());
  endif;
 }
 # Wizard ends

/**
 * Get user Google Calendars
 * @access public
 * @return void 
 */
 public function admin_export($vcname='Vclassroom',  $create=0)
 {
  $this->layout    = 'popup';
  $this->set('vcname', $vcname);
  $this->set('create', $create);
 }
}
# ? > EOF
