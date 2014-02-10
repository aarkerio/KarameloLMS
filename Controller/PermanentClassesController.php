<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package blog
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Controller/PermanentClassController.php

/**
 *  Include files
 */
App::uses('Sanitize', 'Utility');

class PermanentClassesController extends AppController {

/**
 *  CakePHP Helpers
 *  @var array
 *  @access public
 */  
 public $helpers      = array('User');

/**
 *  Cake Helpers
 *  @var array
 *  @access public
 */  
 public $paginate      = Null;

/**
 *  Cake Components
 *  @var array
 *  @access public
 */ 
 public $components   = array('Edublog', 'RequestHandler');

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */ 
 public function beforeFilter() 
 {
    parent::beforeFilter();
 }
 
/** === ADMIN METHODS === ***/
/**
 * Manage in backend
 * @access public
 * @return void
 */
 public function admin_listing($archived=0)
 {
  $this->layout    = 'admin'; 
        
  $params = array('conditions' => array('user_id'=> $this->Auth->user('id'), 'archived'=>$archived),
                  'fields'     => array('id', 'title', 'description', 'created', 'archived'),
                  'order'      => 'id DESC',
                  'limit'      => 50,
                  'contain'    => False
                 );
  $this->set('data', $this->PermanentClass->find('all', $params));
 }

/**
 * Manage in backend
 * @access public
 * @return void
 */
 public function admin_record($pc_id)
 {
  $this->layout    = 'admin';
  $params = array('conditions' => array('user_id'=>$this->Auth->user('id'),'id'=>$pc_id),
                  'contain'    => False);
  $data['Pc'] = $this->PermanentClass->find('first', $params);
  $data['S']  = $this->PermanentClass->getStudents($this->Auth->user('id'), $pc_id);
  $this->set('data',$data);
 }

 /**
  *  Add student to vclassroom manually
  *  @access public
  *  @param integer $pc_id
  *  @return void
  */
 public function admin_items($pc_id=null)
 {
  $this->layout = 'ajax';

  if ( !empty($this->request->data['PcStudent'])):
      #die(debug($this->request->data));
      $url =  '/admin/permanent_classes/record/'.$this->request->data['PcStudent']['pc_id'];
      $this->request->data['PcStudent']['user_id'] = (int) $this->Auth->user('id');
      $this->request->data['PcStudent']['student_id']  = (int) $this->PermanentClass->User->field('id', array('active'=>1,'username'=>trim($this->request->data['PcStudent']['username'])));
     if ( $this->request->data['PcStudent']['student_id']):
         $conditions = array('PcStudent.pc_id'=> $this->request->data['PcStudent']['pc_id'], 
                             'PcStudent.student_id'  => $this->request->data['PcStudent']['student_id']);
         $chk = $this->PermanentClass->PcStudent->field('id', $conditions);
         #die(var_dump($conditions));
         if ( $chk ):
             $msg = __('User already enrolled in this classroom'); 
         else:
             if ($this->PermanentClass->PcStudent->save($this->request->data)):
                 $msg = __('Student succesfully enrolled');
             endif;
         endif;  
     else:
         $msg = __('User not exist or is disabled'); 
     endif;
     $this->msgFlash($msg, $url);
     return;
 else:
     $this->set('pc_id',  $pc_id);
     $this->render('admin_items', 'ajax');
 endif;
 }

/**
 *  Add/Edit method
 *  @access public
 *  @param mixed integer $acquaintance_id or False
 *  @return void
 */
 public function admin_edit($permanent_class_id=False)
 {
  $this->layout    = 'admin'; 
  if ( !empty($this->request->data['PermanentClass']) ):
      $this->request->data['PermanentClass']['user_id'] = (int) $this->Auth->user('id');
      if ($this->PermanentClass->save($this->request->data)):
          $this->msgFlash(__('Data saved'), '/admin/permanent_classes/listing');
      endif;
  elseif($permanent_class_id !=False and intval($permanent_class_id)):
      $this->PermanentClass->id = $permanent_class_id;
      $this->request->data = $this->PermanentClass->read();
  endif;
 }

/**
 *  Add/Edit method
 *  @access public
 *  @param mixed integer $acquaintance_id or False
 *  @return void
 */
 public function admin_new($vclassroom_id=False)
 {
  $this->layout    = 'ajax'; 
  if ( !empty($this->request->data['PermanentClass']) ):
      $user_id = (int) $this->Auth->user('id');
      $this->request->data['PermanentClass']['user_id'] = $user_id;
      if ($this->PermanentClass->save($this->request->data)):
          $pc_id = $this->PermanentClass->getInsertID();
          if ($this->PermanentClass->addList($user_id, $this->request->data['PermanentClass']['vclassroom_id'], $pc_id)):
              $this->msgFlash(__('New list created'), '/admin/vclassrooms/members/'.$this->request->data['PermanentClass']['vclassroom_id']);
          endif;
      endif;
  else:
      $this->set('vclassroom_id', $vclassroom_id);
      $this->render('admin_new', 'ajax');
  endif;
 }

/**
 *  Display lists of students in order to import to Virtual Classroom 
 *  @access public
 *  @param mixed integer $vclassroom_id or False
 *  @return void
 */
 public function admin_get($vclassroom_id=False)
 {
  $this->layout    = 'ajax'; 
  $user_id = (int) $this->Auth->user('id');
  if ( !empty($this->request->data['PermanentClass']) ):
       $pc_id         = $this->request->data['PermanentClass']['pc_id'];
       $vclassroom_id = $this->request->data['PermanentClass']['vclassroom_id'];
       $data = $this->PermanentClass->insertList($user_id, $vclassroom_id, $pc_id);
       $msg = __('Students inserted').': '.$data['inserted'] .' '.  __('already in Virtual Classroom').': '.$data['already'] ;
       $this->msgFlash($msg, '/admin/vclassrooms/members/'.$this->request->data['PermanentClass']['vclassroom_id']);
  else:
      $params = array('conditions' => array('user_id'=>$user_id, 'archived'=>0),
                      'order'      => 'title');
      $this->set('pcs',$this->PermanentClass->find('list',$params));
      $this->set('vclassroom_id', $vclassroom_id);
      $this->render('admin_get', 'ajax');
  endif;
 }

/**
 *  Remove acquaintance
 *  @access public
 *  @param mixed integer $permanent_class_id
 *  @return void
 */
 public function admin_unlink($ps_id, $permanent_class_id)
 {
  if ($this->PermanentClass->PcStudent->delete($ps_id)):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/permanent_classes/record/'.$permanent_class_id); 
 }


/**
 *  Remove acquaintance
 *  @access public
 *  @param mixed integer $permanent_class_id
 *  @return void
 */
 public function admin_delete($permanent_class_id)
 {
  if ($this->PermanentClass->delete($permanent_class_id)):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/permanent_classes/listing');
 }
}

# ? > EOF
