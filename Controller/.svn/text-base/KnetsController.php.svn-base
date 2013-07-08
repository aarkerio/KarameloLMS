<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package knet
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : app/controller/knets_controller.php

App::uses('Sanitize', 'Utility');

class KnetsController extends AppController {

/**
 * CakePHP helpers
 * @access public
 * @var array
 */
 public  $helpers    = array('Xml');

/**
 * CakePHP components
 * @access public
 * @var array
 */
 public  $components = array('RequestHandler');

/**
 *  Change status publis *  @access public
 *  @acces public
 *  @return void
 */ 
 public function beforeFilter() 
 {
  parent::beforeFilter();
  $this->Auth->allow(array('index', 'view'));
 } 

/**
 *  Kandies in this site
 *  @access public
 *  @return void
 */
 public function index()
 {
   $knets = $this->Knet->User->findKnets();
   #$this->set('data', $data);
   #$this->set('kandies', $this->Knet->User->kandies);
   $this->set(compact('knets'));
 }
  
/**== ADMIN METHODS==**/
/**
 *  Display Kandies
 *  @access public
 *  @return void
 */
 public function admin_listing()
 {
   $this->layout = 'admin';
   $data = $this->Knet->User->findKnets();
   $this->set('data', $data);
   $this->set('kandies', $this->Knet->User->kandies);
 }

/**
 *  Import Knet
 *  @access public
 *  @return void
 */
 public function admin_import($model, $knet_id)
 {
  $data = $this->Knet->findKnets($this->Auth->user('id'));
  $this->layout = 'admin';
  $this->set('data', $data);
 }

/**
 *  Export Knet
 *  @access public
 *  @return void
 */
 public function admin_export($model, $knet_id)
 {
  $this->Knet->bindModel(array('hasOne'=>array("{$model}")));
  $data = $this->Knet->{$model}->findKnet($knet_id, $this->Auth->user('id'));
  $this->layout = 'ajax';
  $this->set('data', $data);
 }
}
# ? > EOF
