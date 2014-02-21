<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package newsletters
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Controller/NewslettersController.php

/**
 *  Include files
 */
App::uses('Sanitize', 'Utility');

class NewslettersController extends AppController{

/**
 *  Cake Helpers
 *  @var array
 *  @access public
 */  
 public $helpers    = array('Ck', 'Fpdf');

/**
 *  Cake Helpers
 *  @var array
 *  @access public
 */  
 public $components = array('Mailer', 'Email');

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */ 
  public function beforeFilter()
  {
    parent::beforeFilter();
    $this->Auth->allow(array('view', 'display', 'subscribe', 'renderpdf'));
  }
 
/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */ 
  public function subscribe()
  {
    $this->layout    = 'portal';
  }

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */
 public function display()
 {  
  $this->layout = 'portal';
  if ( $this->Auth->user() ):
      $conditions   = array('Newsletter.status'=>1);
  else:
      $conditions   = array('Newsletter.status'=>1, 'Newsletter.public'=>1);  # get only public NL
  endif;

  $params = array(
                  'conditions' => $conditions,
                  'fields'     => array('Newsletter.id', 'Newsletter.title', 'Newsletter.created', 'Newsletter.public'),
                  'order'      => 'Newsletter.id DESC',
                  'limit'      => 40
                 );
  $this->set('data', $this->Newsletter->find('all', $params)); 
  }

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */ 
  public function view($newsletter_id)
  {
   $params = array(
                   'conditions' => array('Newsletter.status'=>1, 'Newsletter.id'=>$newsletter_id),
                   'fields'     => array('Newsletter.id', 'Newsletter.title', 'Newsletter.body', 'Newsletter.created', 'Newsletter.public')
                  );
   $data       = $this->Newsletter->find('first', $params);

   if ($data['Newsletter']['public'] == 0 && !$this->Auth->user()):
       $this->redirect('/newsletters/display');
       return False;
   else:
       $this->layout = 'portal';
       $this->set('data', $data);     
   endif;
  }

/**
 *  Render Entry as PDF Document
 *  Using TCPDF Class and Component Pdf 
 *  @access public 
 *  @param string $username 
 *  @param integer $entry_id
 *  @return void 
 */
 public function renderpdf($newsletter_id)
 {
   $this->layout = 'pdf';
   $params = array(
                  'conditions'=> array('Newsletter.status'=>1, 'Newsletter.id'=>$newsletter_id),
                  'fields'    => array('Newsletter.title', 'Newsletter.body', 'Newsletter.created', 'Newsletter.user_id')
                  );
   $this->Newsletter->User->contain(); # detach
   $this->set('data',$this->Newsletter->find('first', $params));
 }

/***  === ADMIN METHODS ***/ 

/**
 *  Display all newsletters
 *  @access public
 *  @return void 
 */ 
 public function admin_listing()
 {
  $this->layout    = 'admin'; 
        
  $params = array('conditions' => Null,
                  'fields'     => array('id', 'title', 'body', 'created', 'status', 'delivered', 'public'),
                  'order'      => 'Newsletter.id DESC',
                  'limit'      => 20
                  );
  $this->set('data', $this->Newsletter->find('all', $params)); 
 }

/**
 *  Edit NL
 *  @access public
 *  @return void 
 */ 
 public function admin_edit($newsletter_id=null)
 {
  $this->layout = 'admin';
  if (!empty($this->request->data['Newsletter'])):
      $this->request->data['Newsletter']['user_id'] = (int) $this->Auth->user('id');   
      if ($this->Newsletter->save($this->request->data)):
            if ($this->request->data['Newsletter']['end'] == 0 && !isset($this->request->data['Newsletter']['id'])):
                $id = $this->Newsletter->getLastInsertID();
                $return = '/admin/newsletters/edit/'.$id;    
            elseif ($this->request->data['Newsletter']['end'] == 0 && isset($this->request->data['Newsletter']['id'])):
                $return = '/admin/newsletters/edit/'.$this->request->data['Newsletter']['id'];
	        elseif ($this->request->data['Newsletter']['end'] == 1 ):
	            $return = '/admin/newsletters/listing';
	        endif;
            $this->msgFlash(__('Data saved'),$return);
      endif;
  elseif($newsletter_id != null && intval($newsletter_id)):   
       $this->request->data  = $this->Newsletter->read(null, $newsletter_id);
  endif;
 }

/**
 *  Send Newsletter
 *  @access public
 *  @param  integer $newsletter_id
 *  @return void 
 */ 
 public function admin_share($newsletter_id)
 {
  if ( !intval($newsletter_id) ):
      $this->flash('Something was wrong!', '/');
      return False;
  endif;

  $this->layout = 'admin';
  $this->set('number', $this->__sendNewsletter($newsletter_id));
 }

/**
 *  Send Newsletter to users
 *  @access private
 *  @param  integer $newsletter_id
 *  @return void 
 */ 
  private function __sendNewsletter($newsletter_id)
  {
   $params = array('conditions'   => array('Newsletter.status' => 1, 'Newsletter.id' => $newsletter_id),
                   'fields'       => array('id', 'title', 'body', 'created', 'status')
                  );  
   $data   = $this->Newsletter->find('first', $params);
   $this->Newsletter->User->unbindModel(array('hasMany'=>array('Entry', 'Lesson', 'Faq', 'Vclassroom', 'Acquaintance')));
   $users = $this->Newsletter->User->find('all', array(
                                                     'contain'    => array('Profile'),
                                                     'conditions' => array('User.active'=>1, 'Profile.newsletter'=>1),
                                                     'fields'     => array('User.name', 'User.email')
                                                    )
                                          );
   $i = (int) 0;    
   foreach ($users as $user):
         $this->Email->sender      = '::Karamelo Newsletter::';
         $this->Email->to          = $user['User']['email'];
         $this->Email->subject     = $data['Newsletter']['title'];
	     $this->Email->sendAs      = 'txt';
         $this->Email->template    = null;
         $this->Email->from        = 'noreply@chipotle-software.com';
	     if ( $this->Email->send($data['Newsletter']['body']) ):
	         $i++;
         else:
	         exit('Error sending email!!');
	     endif;
   endforeach;
   return $i;
 }


/**
 *  Change status enabled/disabled
 *  @access public
 *  @param  integer $newsletter_id
 *  @param  integer $status
 *  @return void
 */
 public function admin_change($newsletter_id, $status)
 { 
   $new_status = ($status == 0 ) ? 1 : 0;    
   $this->Newsletter->id = (int) $newsletter_id;
   
   if ($this->Newsletter->saveField('status', $new_status)):
	   $this->msgFlash(__('Status modified'), '/admin/newsletters/listing');
   endif;
 }

/**
 *  Change public / no  public
 *  @access public
 *  @return void
 */
 public function admin_public($newsletter_id, $public)
 { 
   $new_public = ($public == 0 ) ? 1 : 0;
   $this->Newsletter->id    = (int) $newsletter_id;
   if ($this->Newsletter->saveField('public', $new_public)):
	   $this->msgFlash(__('Status modified'), '/admin/newsletters/listing');
   endif;
 }

/**
 *  Remove Newsletter
 *  @access public
 *  @param integer $newsletter_id
 *  @return void
 */
 public function admin_delete($newsletter_id) 
 {
   if ( $this->Newsletter->delete($newsletter_id) ):
       $this->msgFlash(__('Data removed'), '/admin/newsletters/listing');
   endif;
  }
}

# ? > EOF
