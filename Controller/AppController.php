<?php
/**   
*  Karamelo e-Learning Platform
*  Chipotle Software(c) 2006-2014
*  GNU Affero General Public License V3
*  @version 0.7
*  @package Karamelo
*  @license http://www.gnu.org/licenses/agpl.html
*/
#file: APP/Controller/AppController.php

App::import('Core', 'Debugger');
App::uses('Controller', 'Controller');

class AppController extends Controller {

/**
 *  CakePHP Helpers
 *  @var array
 *  @access public
 */ 
 public  $helpers        = array('Html', 'Form', 'Session', 'Gags', 'Js' => array('Jquery')); # 'Cache' <-- this later

/**
 *  CakePHP Helpers
 *  @var array
 *  @access public
 */
 public $components = array('Acl', 'Session', 'Auth'=>array('authorize' => 'Crud'), 'Cookie', 'RequestHandler'); 

/**
 * Karamelo current availables langs
 * @access public
 * @var  array
 */
 public  $languages      = array('es','en'); # 'nah' for nahuatl
 protected $_loginAction = False;
 public  $html_allowed   = array('.',',','-','_', '@', ' ','(',')',"\n","ñ","Ñ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", '"', "'");
 # allowed characters in paranoid Sanitize
 public  $para_allowed  = array("\\","/",'.', ',', '-','_','@',' ','(', ')',"+","\n", "ñ", "á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", '"',"'");
 # Use :  Sanitize::paranoid($this->request->data['Model']['title'], $this->para_allowed);

/**
 *  Set Auth component and lang
 *  @access public
 *  @return void  
 */
 public function beforeFilter()
 { 
  $this->Auth->authenticate = array(AuthComponent::ALL => array('userModel'=>'Users.User', 'fields' => array('username'=>'email', 'password'=>'pwd')),
                                    'Form');
  # This mess happend because ACL was installed later, will fix this in the next months
  $this->Auth->mapActions(array('read'  => array('admin_listing','admin_finish','admin_activities','admin_questions', 'admin_wizard','admin_start', 'admin_export', 
                                                 'display', 'admin_new', 'admin_items', 'admin_get','admin_members','admin_display', 'admin_dide','admin_details', 
                                                 'admin_vclassrooms', 'admin_spexport', 'admin_view', 'admin_answers','admin_import', 'admin_show','admin_record', 
                                                 'admin_reply', 'admin_download', 'admin_comments', 'admin_newkm', 'admin_type', 'admin_getWq', 'admin_getScaven',
                                                 'revision','admin_search','admin_allclass','admin_newticket','admin_see'),
                               'update' => array('admin_hide', 'admin_order','admin_edactivity','admin_unshare','admin_change','admin_changeactivity','admin_edit',
                                                 'admin_avatar','admin_chat','admin_logo','admin_public', 'admin_points','admin_ekm', 'admin_unlink2class',
                                                 'admin_update', 'admin_ekandie'),
                               'create' => array('admin_newactivity', 'admin_add' => 'create','admin_share', 'admin_teachers','admin_general','admin_compose',
                                                 'admin_backup',   'admin_link2class', 'admin_send2class'), 
                               'delete' => array('admin_unlink','admin_delactivity', 'admin_delete')));
   #die(debug($this->request));
   #die('PWD hashed: '. AuthComponent::password($this->request->data['User']['pwd']));  # if you change Configure::salt string see before hash 
   #set locale
   $this->__setLocale();
   #Auth configuration
   # log try login
   if ( isset($this->request->data['User']['email']) && !isset($this->request->data['User']['id'])):
       $this->log('Logged '.$_SERVER['REMOTE_ADDR'].' '. date('l jS \of F Y h:i:s A').' '. $this->request->data['User']['email'], 'logged');
   endif;
   $this->Auth->loginAction    = array('plugin' => False,'controller' => 'users', 'action'   => 'login');
   $this->Auth->loginRedirect  = array('plugin' => False,'controller' => 'news', 'action'    => 'display');
   $this->Auth->logoutRedirect = array('plugin' => False,'controller' => 'news', 'action'    => 'display');
   $this->Auth->loginError     = __('wrong_pass_or_email');
   $this->Auth->authError      = __('You are not authorized to access this page');
   # Pass settings in
   $this->Auth->authorize = array('Crud' => array('actionPath' => 'controllers'));
 }

/**
 * Just set a message in Session and redirect user 
 * @access public
 * @param string $msg
 * @param string $to
 * @return boolean
 */
 public function msgFlash($msg, $to)
 {
   $this->Session->setFlash($msg);  # http://book.cakephp.org/view/173/Sessions
   $this->redirect($to);       
   return True;
 }

/**
 * Load a layout if the Request is not an Ajax Object, otherwise load only the view
 * @access public
 * @param string $layout
 * @return void
 */
 public function isAjaxRequest($layout)
 {
   if(!$this->RequestHandler->isAjax()):
       $this->layout= $layout;
       $this->set('notAjax', False);
   endif;
 }

/**
 *  Get Database kind for dataSource
 *  @access public
 *  @param  string $dataSource
 *  @return string 
 */
 public function getDbKind($dataSource='default')
 {
   $db     = ConnectionManager::getDataSource($dataSource);
   #die(debug($db->config));
   $dbkind = '';
   switch ($db->description):
       case 'PostgreSQL DBO Driver':
          $dbkind = 'PGSQL';
          break;
       case 'Mysqli DBO Driver':
           $dbkind = 'MYSQL';
           break;
       case 'MySQL DBO Driver':
           $dbkind = 'MYSQL';
           break;
       default:
           $dbkind = 'PGSQL';    
   endswitch;

   return $dbkind;
 }

/**
 * Set language   see:  http://book.cakephp.org/view/162/Localizing-Your-Application
 * @access  private
 * @return void
 */
 private function __setLocale()
 {
     
   if ( $this->Auth->user() ):  # user is logged in
       $pre_lang = $this->Auth->user('lang');  
   else:
       $pre_lang = 'en';
   endif;

   # Double check
   if ( in_array($pre_lang, $this->languages) ):
       $lang = $pre_lang;
   else:
       $lang = 'en';
   endif; 
   #$this->L10n->get($lang);
   Configure::write('Config.language', $lang);
 }

/**
 *  If error load 404
 *  @access protected
 *  @return void
 */
 public function setError() 
 {
  if ($this->name == 'CakeError'):
      $this->cakeError('error404');
  endif;
 }
/**
 *  If error.... Get support with us!!
 *  @access protected
 *  @return void
 */
 protected function __getSupport()
 {
   $this->flash(__('An error has been encountered, please ask Chipotle Software (www.chipotle-software.com) for support'),'/',15);
 } 
}

# ? > EOF
