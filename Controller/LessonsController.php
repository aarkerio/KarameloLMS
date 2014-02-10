<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package lessons
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : app/Controller/LessonsController.php
 
/**
 *  Include files
 */
App::uses('Sanitize', 'Utility');

class LessonsController extends AppController {

/**
 *  Cake helpers
 *  @var array
 *  @access public
 */
 public $helpers       = array('Ck', 'Time');

/**
 *  Cake components
 *  @var array
 *  @access public
 */
 public $components    = array('Edublog', 'Captcha');

/**
 *  Cake Paginate
 *  @var array
 *  @access public
 */
 public $paginate = array('limit' => 20, 'page' => 1);

/**
 *  Auth Component permisssions
 *  @access public
 *  @return void 
 */ 
 public function beforeFilter() 
 {
    parent::beforeFilter();
    $this->Auth->allow(array('view', 'display', 'blogElement', 'captcha', 'contribution', 'autosave', 'selfprint'));
 }
 
/**
 *  Charge element in blog 
 *  @access public
 *  @return void 
 *  @param integer $user_id
 */
 public function blogElement($user_id) 
 {
  $params = array('conditions' => array('Lesson.user_id'=>$user_id, 'Lesson.status'=>1, 'Lesson.public'=>1),
                     'fields'  => array('Lesson.id', 'Lesson.title'),
                     'order'   => 'Lesson.modified DESC',
                     'limit'   => 10
                 );
  $this->Lesson->contain();
  return $this->Lesson->find('all', $params); 
 }


/**
 *  Comment in lessons 
 *  @access public
 *  @return void 
 */
 public function contribution()
 {
  if ($this->request->data['Contribution']['captcha'] != $this->Session->read('captcha') or strlen($this->request->data['Contribution']['captcha']) < 3):
     $this->flash(__('Captcha is wrong'), $this->request->data['Contribution']['redirect_to'].'/#comments');
     $this->Session->delete('captcha');
     return False;
  endif;

  if (!empty($this->request->data['Contribution'])):
      $this->request->data['Contribution']['type'] = 2;
      if ($this->Lesson->Contribution->save($this->request->data)):
          $this->Session->delete('captcha');
          $this->msgFlash(__('Comment saved'), $this->request->data['Contribution']['redirect_to'].'/#comments');
      endif;
  endif;
 }
 
/**
 *  View lesson in blog
 *  @access public
 *  @return void 
 */
 public function view($username, $lesson_id)
 {
  try
  {
    $this->__visits($lesson_id); # sum 1 to visits
    $conditions = array('Lesson.id'=>$lesson_id, 'Lesson.status'=>1);
    if ( !$this->Auth->user('username') ): # user is not logged
        $conditions['Lesson.public'] = 1; # lesson must be public
    endif;
    $this->Edublog->setUserId($username); # blogger elements

    # Next lines: show enabled/dissbled comments to teacher
    if ( $this->Auth->user() && $this->Auth->user('id') ==  $this->Edublog->userId): # user is owner
        $conditions  = array('Lesson.id'=>$lesson_id);
        $annoConditi = array('Annotation.status <'=>2);
    else:
        $annoConditi = array('Annotation.status'=>1);
    endif;
  
    $params =array('conditions'=> $conditions,
                   'recursive' => 2, 
                    'contain'  => array('User'=>array('fields'=>array('User.username', 'User.avatar')),
                                        'Annotation'=>array('User', 'conditions'=>$annoConditi,
                                                            'fields'=>array('Annotation.id', 'Annotation.comment', 'Annotation.created', 'Annotation.user_id','Annotation.email', 
                                                             'Annotation.status', 'Annotation.website', 'Annotation.username'))),
                    'fields'    => array('Lesson.id', 'Lesson.title', 'Lesson.body', 'Lesson.created', 'Lesson.disc', 'Lesson.modified', 
                                      'Lesson.user_id', 'Lesson.visits')
                 );
    $data = $this->Lesson->find('first', $params);
  
    if ( !$data ):
        throw new NotFoundException('Could not find that lesson');
    endif;
    $this->set('data', $data);
  }
  catch(Exception $e)
  {
    echo $e->getMessage();
    exit();
  }
 }

/**
 *  Print lesson
 *  @access public
 *  @return void 
 */
 public function selfprint($lesson_id)
 {
  try
  {
    $this->layout = 'popup';
    $conditions = array('Lesson.id'=>$lesson_id, 'Lesson.status'=>1);

    if ( !$this->Auth->user('username') ): # user is not logged
        $conditions['Lesson.public'] = 1; # lesson must be public
    endif;

    $params = array('conditions' => $conditions,
                    'fields'     =>array('Lesson.title', 'Lesson.body'),
                    'contain'    => False);
    $data = $this->Lesson->find('first',$params);
  
    if ( !$data ):
      throw new NotFoundException('Could not find that lesson');
    endif;
    $this->set('data', $data);
  }
  catch(Exception $e)
  {
    echo $e->getMessage();
    exit();
  }
 }

/**
 *  Print captcha
 *  @access public
 *  @return void 
 */
 public function captcha()
 {
   return $this->Captcha->render();
 }


/**
 *  sum 1 to visits 
 *  @access public
 *  @return void 
 */
 private function __visits($lesson_id)
 {
   if ( $this->Session->read('Lesson.id') == $lesson_id):
      return; 
   else:
      $this->Lesson->addVisit($lesson_id);
      $this->Session->write('Lesson.id', $lesson_id);
   endif;
 }
 
/**
 *  List lessons in edublog
 *  @access public
 *  @return void 
 */
 public function display($username) 
 { 
   $this->Edublog->setUserId($username); # blogger elements
   $conditions =  array('Lesson.status'=>1, 'Lesson.user_id'=>$this->Edublog->userId);
   if ( !$this->Auth->user('username') ): # user is not logged
       $conditions['Lesson.public'] = 1;  # lesson must be public 
   endif;
   #die(debug($conditions));
   $this->paginate['conditions']  = $conditions;
   $this->paginate['fields']      = array('id', 'title', 'created', 'user_id');
   $this->paginate['order']       = array('Lesson.title' => 'DESC');
   $data = $this->paginate('Lesson');
   $this->set(compact('data'));
 }
    
 /***   === ADMIN METHODS   ****/
/**
 *  Display lessons in admin
 *  @access public
 *  @return void 
 */
 public function admin_listing()
 {   
   $this->layout    = 'admin';
   $this->paginate = array('conditions' => array('Lesson.user_id'=>$this->Auth->user('id')),
                           'fields'     => array('id', 'title', 'created', 'user_id', 'status', 'public'),
                           'order'      => array('Lesson.id' => 'DESC')
                           );
   $data = $this->paginate('Lesson');
   $this->set(compact('data'));
 }

/**
 *  View comments in lessons
 *  @access public
 *  @return void 
 */
 public function admin_comments($ord=1)
 { 
   $this->layout = 'admin';
   $order = ($ord == 1) ? 'Annotation.id DESC' : 'Lesson.title DESC';
   #$this->set('data', $this->Lesson->getComments($this->Auth->user('id')));
   $this->Lesson->Annotation->bindModel(array('belongsTo'=>
                                              array('Lesson'=>array('fields'=>'title, id, created')))
                                       );
   $params= array(
                  'conditions'=> array('Annotation.blogger_id'=>$this->Auth->user('id')),
                  'order'     =>$order,
                  'contain'   => array('Lesson', 'User')
        );
   $this->set('data', $this->Lesson->Annotation->find('all', $params));
 }
 
/**
 * Edit lesson
 * @access public
 * @param $lesson_id integer
 * @return void
 */
 public function admin_edit($lesson_id=null)
 {
  $this->layout    = 'admin';
  $this->set('subjects', Set::combine($this->Lesson->Subject->find('all', array('order' => 'title')), "{n}.Subject.id","{n}.Subject.title"));
  if ( !empty( $this->request->data['Lesson'] ) ):
      if ( !isset($this->request->data['Lesson']['id']) ):
          $this->request->data['Lesson']['user_id']  = (int) $this->Auth->user('id');
      else:
          $this->request->data['Lesson']['modified'] = (string) 'now()';
      endif;
      
      if ($this->Lesson->save($this->request->data)):
           if ( $this->request->data['Lesson']['end'] == 0 && !isset($this->request->data['Lesson']['id']) ):
               $id = $this->Lesson->getLastInsertID();
               $this->msgFlash(__('Data saved'), '/admin/lessons/edit/'.$id);
	       elseif ( $this->request->data['Lesson']['end'] == 0 && isset($this->request->data['Lesson']['id']) ):
               $this->msgFlash(__('Data saved'), '/admin/lessons/edit/'.$this->request->data['Lesson']['id']);
	       elseif ( $this->request->data['Lesson']['end'] == 1 ):
               $this->msgFlash(__('Data saved'), '/admin/lessons/listing');
	       endif;
      endif;
  elseif( $lesson_id != null && intval($lesson_id)):
      $this->Lesson->contain('Subject');
      $this->Lesson->id = $lesson_id;
      $this->request->data  = $this->Lesson->read();
  else:
      #Created draft Entry
	  $this->request->data['Lesson']['user_id'] = (int) $this->Auth->user('id');
 	  $this->request->data['Lesson']['title']   = 'draft';
	  $this->request->data['Lesson']['body']    = 'draft';
	  $this->request->data['Lesson']['subject_id'] = 1; 
	  if ($this->Lesson->save($this->request->data, False)):  #Save register without validation 
	      # $this->Session->setFlash('Borrador');
		  # Clean array data		
		  $this->request->data['Lesson']['title'] = '';
		  $this->request->data['Lesson']['body']  = '';
		  # Get last insert id
		  $this->request->data['Lesson']['id']= $this->Lesson->id;
      endif; 
  endif;
 }
 
/**
 * Change status
 * @access public
 * @param integer $lesson_id
 * @param integer $status
 * @return void
 */
 public function admin_change($lesson_id, $status)
 {  
   $new_status       = ($status == 0 ) ? 1 : 0;
     
   $this->Lesson->id = (int) $lesson_id;
     
   if ($this->Lesson->saveField('status', $new_status)):
	   $this->msgFlash(__('Status modified'), $this->referer());
   endif;
 }

/**
 * Public or restringged
 * @access public
 * @return void
 */
 public function admin_public($lesson_id, $public)
 {
   $new_public       = ($public == 0 ) ? 1 : 0;
     
   $this->Lesson->id = (int) $lesson_id;
     
   if ($this->Lesson->saveField('public', $new_public)):
	   $this->msgFlash(__('Status modified'), $this->referer());
   endif;
 }

/**
 * Remove lesson
 * @access public
 * @return void
 */
 public function admin_delete($lesson_id)
 {
  if ($this->Lesson->delete($lesson_id)):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, $this->referer());
 }
 
/**
 * Using for ajax autosave $this->Lesson->save($this->request->data)
 * @access public
 * @return void 
 */
 public function autosave()
 {
  $this->autoRender = False; 
  $this->layout = 'ajax';
  $this->request->data['Lesson']['body']=(string) $this->request->data['Lesson']['body']; 
  if ( !isset($this->request->data['Lesson']['id']) ):
      $this->request->data['Lesson']['user_id'] = (int) $this->Auth->user('id');
  endif;

  if ($this->Lesson->save($this->request->data)):
	  $this->Session->setFlash('Draft Saved');  
  else:
      $this->Session->setFlash('Connection error');  
  endif; 
 }
}
# ? > EOF
