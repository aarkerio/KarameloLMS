<?php
/* Karamelo
 * @copyright		Copyright 2009-2011, Chipotle Software (c)
 * @author          Manuel Montoya <mmontoya_at_chipotle-software_PUNTO_com
 * @link			http://www.chipotle-software.com/
 * @package			org.karamelo
 * @subpackage		org.karamelo.app
 * @since			Version 2.0 
 * @version			$Revision: 1590 $
 * @modifiedby		$LastChangedBy: aarkerio $
 * @lastmodified	$Date: 2010-01-30  $
 * @license			http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License Version 3
 */

class WquestsController extends KsuiteAppController 
{ 
 public   $uses   = array('Ksuite.Wquest');
 private  $_userID;
 public   $me     = Null; # Me!!
 private  $_model = 'Wquest';
 
/**
 * Name: beforeFilter
 * Desc: Performs necessary steps and function calls prior to executing
 *       any view function calls.
 * See: APP/plugins/facebook/facebook_app_controller.php
 */
 public function beforeFilter() 
 {
  parent::beforeFilter();
  $this->Auth->allowedActions = array('index', 'delete',  'add', 'edit', 'save', 'help', 'listing');
 }

/**
 * Name: help
 * Desc: Show app help messages
 * @access public
 * @return void 
 */
 public function help() 
 {
  $this->layout  = 'facebook';
 }

/**
 * Name: index
 * Desc: Display the friends index page. Is like admin_listing
 * @access public
 * @return void 
 */
 public function index() 
 {
  $this->layout  = 'facebook';
  
  $user = array('session' => $this->facebook->getSession());
  
  if ($user['session']):
      try {
          $user['appid'] = $this->facebook->getAppId();
          $user['uid']   = $this->facebook->getUser();
          $user['me']    = $this->facebook->api('/me');
      } catch (FacebookApiException $e) {
          error_log($e);
      }
      # login or logout url will be needed depending on current user state.
      if ( $user['me'] ):
          $user['login']  = $this->facebook->getLogoutUrl();
      else:
          $user['login']  = $this->facebook->getLoginUrl();
      endif;
  endif;

  #debug($user);
  $this->set('user', $user);
 }

/**
 * Name: listing
 * Desc: Display the Wquest. Is like admin_listing
 * @access public
 * @return void 
 */
 public function listing() 
 {
  $this->layout = 'facebook';
  $params = array(
                  'conditions' => array('Wquest.user_id' => $this->facebook->getUser()),
                  'fields'     => array('Wquest.id', 'Wquest.title', 'Wquest.status', 'Wquest.points'),
                  'order'      => 'Wquest.id DESC',
                  'limit'      => 12
                 );
  $this->set('data', $this->Wquest->find('all', $params));
 }

/**
 * Name: listing
 * Desc: Display the Wquest. Is like admin_listing
 * @access public
 * @return void 
 */
 public function view($wquest_id)
 {
  $this->layout = 'facebook';
  $params = array(
                  'conditions' => array('Wquest.user_id' =>$wquest_id,'Wquest.user_id' => $this->facebook->getUser()),
                  'fields'     => array('Wquest.id', 'Wquest.title', 'Wquest.status', 'Wquest.points')
                 );
  $this->set('data', $this->Wquest->find('first', $params));
 }

/**
 * Name: add
 * Desc: Add new Wquest
 * @access public
 * @return void 
 */
 public function add() 
 {
  try{
   $this->layout  = 'facebook';
  }
  catch (FacebookRestClientException $ex) {
      echo "<p>ERROR! code: ".$ex->getCode()."</p>";
      echo $ex->getMessage();
  }
 }

/**
 * Name: Save add and edit data
 * Desc: Add new Wquest
 * @access public
 * @return void 
 */
 public function save() 
 {
  try{
   $this->layout  = 'facebook';
   $this->data['Wquest']['user_id'] = $this->facebook->getUser();
   
   #die(debug($this->data['Wquest']));
   if ( !empty($this->data['Wquest']) ):
       if ( $this->Wquest->save($this->data) ):
           $this->redirect('index');
       endif;
   endif;
  }
  catch (FacebookRestClientException $ex) {
      echo "<p>ERROR! code: ".$ex->getCode()."</p>";
      echo $ex->getMessage();
  }
 }

/**
 * Name: edit
 * Desc: Edit Wquest
 * @access public
 * @return void 
 */
 public function edit() 
 {
  try{
  # Create array using array statement
  $data = array('name'=>'value');
  # Get object id. You can't retrive object unless you know its id. So you MUST get it and save.
  $params = array('title'=>$title,  'points'=>$title, 'introduction'=>$title, 'tasks'=>$title, 'process'=>$title, 'roles'=>$title, 'evaluation'=>$title, 'conclusion'=>$title);
  #$objectID = $this->facebook->api_client->data_updateObject($this->_model,$params);
  # Set association between created object and logged in user to store object id
  #$facebook->api_client->data_setAssociation('assocname', $user, $obj);
 }
  catch (FacebookRestClientException $ex) {
      echo "<p>ERROR! code: ".$ex->getCode()."</p>";
      echo $ex->getMessage();
  }
 }

/**
 * Name: delete
 * Desc: Remove Wquest
 * @access public
 * @return void 
 */
 public function delete() 
 {
  try{
   #die(debug($this->data));
   $this->layout  = 'facebook';
   $this->Wquest->delete($this->data['Wquest']['id']);
   $this->redirect('listing');
  }
  catch (FacebookRestClientException $ex) {
      echo "<p>ERROR! code: ".$ex->getCode()."</p>";
      echo $ex->getMessage();
  }
 }

/**
 * Name: friends
 * Desc: Display the friends index page.
 * @access public
 * @return void 
 */
 public function friends() 
 {
  $this->layout = False; #'portal';
  $friends = $this->facebook->api_client->friends_get();
  #die(debug($friends));
  $this->set('user_id', $this->user_id);
  $this->set('friends', $friends);
 }
}
# ? >  EOF