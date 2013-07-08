<?php 
/**
 * Edublog component By Chipotle Software(c). 2008-2012
 * @author aarkerio
 * @version 0.7
 * @license GNU Affero General Public License V3
 */
App::uses('Debugger', 'Utility');
App::import('Model','User');
App::uses('Component', 'Controller');

class EdublogComponent extends Component {

/**
 *  User Id
 */
 public $userId       = Null;
 
/**
 * belongs to Vclassroom
 * @access public
 * @var    string
 */
 public $inVclassroom = False;

/**
 * belongs to Vclassroom
 * @access public
 * @var    string
 */
 private $_User    = Null;

/**
 * Component Constructor
 * @access public
 * @return void
 */ 
 public function __construct(ComponentCollection $collection, $settings = array()) 
 {
     $this->Controller = $collection->getController();
     parent::__construct($collection, $settings);
 }

/**
 *  The initialize method is called before the controller’s beforeFilter method.
 *  @access public
 *  @param Controller $controller A reference to the instantiating controller object
 *  @return void
 */
 public function initialize(Controller $controller) 
 {
    $this->request = $controller->request;
	$this->response = $controller->response;
	$this->_methods = $controller->methods;
    $this->_User = new User;
 }

/**
 * @param 
 * @access public
 * @return void
 */
 public function setUserId($username, $setLayout=True, $setBD = True)
 {
  $this->userId = (int) $this->_User->field('User.id', array('User.username'=>$username));
  if ( !$this->userId ):
      $this->controller->msgFlash(__('User does not exist or not enabled'), '/');
      return False;  
  endif;

  if ( $setBD ):
      $this->setBloggerData();
  endif;

  if ( $setLayout ):
      $this->setLayout();
  endif;
 }
 
/**
 * 
 * @access public
 * @return void
 */
 public function getUserId()
 {
   return $this->userId; 
 } 
 
/**
 * 
 * @access public
 * @return void
 */
 public function setLayout() 
 {       
  $layout = $this->_User->Profile->field('Profile.layout', array('Profile.user_id' => $this->userId));
        
  if ($layout == Null):
      $layout = 'basic';
  endif;

  if ($this->inVclassroom ):
      $layout = 'vclassroom'; #experimental
  endif;
 
  $this->Controller->layout = $layout;
 }
 
/**
 * Set blogger (aka teacher) info
 * @access public
 * @return void
 */
 public function setBloggerData()
 {
     $params = array('conditions' => array('User.id'=>$this->userId, 'User.active'=>1),
                     'fields'     => array('User.id','User.avatar','User.name','User.username', 
                                           'Profile.cv', 'Profile.layout', 'Profile.name_blog', 'Profile.quote'),
                     'contain'    => array('Profile')
                 );
  $data  =  $this->_User->find('first', $params);
  #die(debug($data));
  $this->Controller->set('blogger', $data);
 }

/**
 * Check if user belongs to any active vclassroom
 *  @access public 
 *  @param integer $user_id
 *  @return void
 */
 public function generalBelongs($user_id)
 {
   $gBelongs  = $this->_User->UserVclassroom->generalBelongs($user_id);
   #die(var_dump($gBelongs));
   return $gBelongs;
 }

/**
 *  checkPermissions -- check if student belongs to this class, if already had answered this kandie 
 *  and if date is correct to show it 
 *  @access public 
 *  @param integer $vclassroom_id
 *  @param integer $kandie_id
 *  @param string  $kandie_model
 *  @param integer $student_id 
 *  @return void
 */
 public function checkPermissions($vclassroom_id, $kandie_id, $kandie_model='Scorm', $student_id, $set=True)
 {
   $permissions = array();
   # student belongst to this vclassroom?
   $permissions['belongs'] =  (bool)  $this->__checkBelongs($student_id, $vclassroom_id,  $kandie_model);
   # student already answered this Kandie?
   $permissions['already'] =  (bool) $this->_User->UserVclassroom->Vclassroom->chkAlready($kandie_id, $student_id, $vclassroom_id, $kandie_model);
   #check kandie dates ands hours
   $permissions['chkdate'] =  (bool) $this->_User->UserVclassroom->Vclassroom->chkDateKandie($kandie_id, $vclassroom_id, $kandie_model);
   $this->Controller->set('permissions',  $permissions);
 }
 
/**
 *  Check if studen velongs to the vClassroom
 *  @access public
 *  @return mixed
 */
 private function __checkBelongs($student_id, $vclassroom_id, $kandie_model)
 {
   return $this->_User->UserVclassroom->belongs($student_id, $vclassroom_id);
 }

/**
 *  Only one session by IP
 *  @access public
 *  @return mixed
 */
 public function oneSession()
 {
   $user_id = $this->Controller->Auth->user('id');
   if ( !$user_id ):
       return False;
   endif;
   $session_auth = $this->Controller->Auth->user('current_visit');
   $session_db   = $this->_User->field('current_visit', array('id'=>$user_id));
   if ($session_auth != $session_db):
       $this->Controller->flash(__('Looks like there is another person using your account, logout and login again to recover your session'), '/users/logout', 5);
       return False;
   endif;
 }

}

# ? > EOF
