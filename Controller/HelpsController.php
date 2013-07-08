<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package helps
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : app/Controller/HelpsController.php

App::uses('Sanitize', 'Utility');

class HelpsController extends AppController
{  

/**
 *  Auth component permissions
 *  @access public
 *  @return void
 */
 public $helpers       = array('Ck');
   
/**
 *  Auth component permissions
 *  @access public
 *  @return void
 */

 public $components    = array('Edublog', 'Mailer');

/**
 *  Auth component permissions
 *  @access public
 *  @return void
 */
 public function beforeFilter() 
 { 
  parent::beforeFilter();
  $this->Auth->allow(array('display', 'tour', 'index', 'view'));
 }
 
/**
 *  Tour to new users
 *  @access public
 *  @param mixed integer or Null $help_id
 *  @return void
 */
 public function tour() 
 {
   $this->layout    = 'tour';
 }

/**
 *  Display one help using url
 *  @access public
 *  @param mixed integer or Null $help_id
 *  @return void
 */
 public function display($a, $b, $c = False)
 {
   if ( !$c ):
        $url  = (string) '/'.$a .'/'.$b;
   else:
        $url  = (string) '/'.$a .'/'.$b .'/'.$c;
   endif;
   
   $this->layout    = 'help';
  
   $lang = $this->Auth->user('lang') ? $this->Auth->user('lang') : 'es'; # get lang logged user
   $params = array(
                   'conditions' => array('url'=>$url, 'lang' => $lang),
                   'fields'     => array('help', 'title', 'url', 'lang')
                    ); 
   $this->set('data', $this->Help->find('first',$params));
 }

/**
 *  Display all helps
 *  @access public
 *  @param mixed integer or Null $help_id
 *  @return void
 */
 public function index($set=null) 
 {
  $lang = (Configure::read('Config.language')) ?  Configure::read('Config.language') : 'en';
  $this->layout    = ( isset($set) ) ? 'admin' : 'help'; # small window or admin panel?
  $params = array(
                  'conditions'  => array('lang'=>$lang),
                  'fields'      => array('id','title','url'),
                  'order'       => 'title'
                 );
  $this->set('data', $this->Help->find('all', $params));
 }

/**
 *  Display one help
 *  @access public
 *  @param mixed integer or Null $help_id
 *  @return void
 */
 public function view($help_id, $set = null) 
 {
  $lang = (Configure::read('Config.language')) ?  Configure::read('Config.language') : 'en';
  $this->layout    = ( $set !==  Null) ? 'admin' : 'help';    #small window or admin panel?
  $params = array('conditions' => array('Help.id'=>$help_id),
                  'fields'     => array('id','title', 'help', 'lang'));
  $this->set('data', $this->Help->find('first', $params));
 }
 
 /**  === ADMIN METHODS === **/
/**
 *  Bug report
 *  @access public
 *  @param mixed integer or Null $help_id
 *  @return void
 */
 public function admin_newticket() 
 {
  if ( !empty( $this->request->data['Help'] ) ):
      $this->request->data['Help']['report'] = Sanitize::paranoid($this->request->data['Help']['report']);
      $report  = $this->Auth->user('username') .' with email '. $this->Auth->user('email') .', IP:'.$_SERVER['REMOTE_ADDR']." wrote:\n";
      $report .= $this->request->data['Help']['report'] .".\n  Kind: " . $this->request->data['Help']['kind'];
      $this->Mailer->template = 'report';   # note no '.ctp'
      $this->Mailer->subject  =  'Bug report';
      $this->Mailer->set('message', $report);
      if ( $this->Mailer->send('mmontoya@gmail.com') ):
          $this->msgFlash(__('Email sent, Thanks!'), '/admin/entries/start'); 
          return True;
      endif;
  endif;
  $this->layout    = 'admin';
  $params = array(
                  'conditions'  => array('lang'=>'en'),
                  'fields'      => array('help', 'url', 'lang')
                 );
  $this->set('data', $this->Help->find('all', $params));
 }

/**== ADMIN METHODS ==**/
/**
 *  Edit help
 *  @access public
 *  @param mixed integer or Null $help_id
 *  @return void
 */
 public function admin_listing()
 {
  $this->layout = 'admin';
  $params = array('fields' => array('id', 'url', 'lang', 'title'),
                  'order'  => 'url');
  $this->set('data', $this->Help->find('all', $params));
 }
 
/**
 *  Edit help
 *  @access public
 *  @param mixed integer or Null $help_id
 *  @return void
 */
 public function admin_edit($help_id = Null)
 {
   $this->layout = 'admin'; 
   if (!empty($this->request->data['Help'])):
       if ( $this->Help->save($this->request->data) ):
           if ($this->request->data['Help']['end'] == 0 && !isset($this->request->data['Help']['id'])):
               $id = $this->Help->getLastInsertID();
               $return = '/admin/helps/edit/'.$id;
	       elseif ($this->request->data['Help']['end'] == 0 && isset($this->request->data['Help']['id'])):
               $return = '/admin/helps/edit/'.$this->request->data['Help']['id'];
	       elseif($this->request->data['Help']['end'] == 1):
               $return = '/admin/helps/listing'; 
	       endif;
           $this->msgFlash(__('Data saved'), $return);    
       endif;
    elseif($help_id != Null && intval($help_id)):        
        $this->request->data = $this->Help->read(null, $help_id);
    endif;
 }
 
/**
 *  Delete help
 *  @access public
 *  @param integer  $help_id
 *  @return void
 */
 public function admin_delete($help_id)
 {
   if ( $this->Help->delete($help_id) ):
       $this->msgFlash(__('Data removed'),'/admin/helps/listing');
   endif;
 }
}
# ? > EOF

