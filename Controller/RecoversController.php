<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package users
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Controller/RecoversController.php
 
App::uses('Sanitize', 'Utility');

class RecoversController extends AppController {
 
 public $helpers       = array('Ck');
 
 public $components    = array('Mailer', 'Adds');

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */   
 public function beforeFilter() 
 {
    parent::beforeFilter();
    $this->Auth->allow(array('confirm', 'newpwd', 'recover'));
 }
 
/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */
 public function recover()
 {
  if ( $this->Auth->user() ):
      $this->msgFlash(__('You are logged'), '/');
      return False;
  endif;

  $this->layout    = 'portal';
 }

/**
 *  Recover password check, method to check if email exist and send email 
 *  @access public
 *  @return void 
 */  
 public function confirm()
 { 
  if ( isset( $this->request->data['User']['email'] ) ):
       $this->request->data['User']['email'] = Sanitize::paranoid($this->request->data['User']['email'], $this->para_allowed);
       $user_id = $this->Recover->User->field('User.id', array('User.email' => $this->request->data['User']['email'], 'User.active'=>1));
       if ($user_id == null):
               $this->set('error_message', 'Error: email <b>' . $this->request->data['User']['email'] . '</b> '.__('does not exist on database'));
               $this->render('check', 'ajax');
       else:  # email exist 
           $this->Recover->deleteAll(array('Recover.user_id' => $user_id));  # remove previous recovers process   
	       $this->request->data['Recover']['user_id']  = (int) $user_id;   # the user id
           $this->request->data['Recover']['random']   = $this->Adds->genPassword(20);
           if ( $this->Recover->save($this->request->data) ):
               $this->Mailer->view    = 'recover';
               $this->Mailer->subject =  __('Karamelo::Recovering password');
               $this->Mailer->set('random',  $this->request->data['Recover']['random']);
		       if ( $this->Mailer->send($this->request->data['User']['email'])):
                   $this->set('message', __('Success. An email has been sent to').': <b>'.$this->request->data['User']['email']) . '</b>';
                   $this->render('check', 'ajax');
		       endif;
	       endif;
	endif;
   endif;   
 }

/**       
 * Generate new pwd
 * @access public
 * @return void
 */
 public function newpwd($random = null)
 {  
   if ( $random == Null ):
        redirect('/');
   endif;
      
   $this->layout = 'popup';
   $params = array(
                   'conditions' => array('Recover.random' => $random),
                   'fields'     => array('Recover.id', 'Recover.user_id')
                   );
   $data = $this->Recover->find('first', $params);
      
   if ( $data == Null ):
       $this->redirect('/');
   else:
       $this->Recover->User->id = (int) $data['Recover']['user_id'];
       $pwd            = $this->Adds->genPassword(8);
       if ( $this->Recover->User->saveField('pwd', $pwd) ):
           $this->set('pwd', $pwd);
           $this->Recover->deleteAll(array('Recover.user_id'=>$data['Recover']['user_id']));  # del row(s)
       endif;
   endif;
 }
}
# ? > EOF
