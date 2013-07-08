<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package plugins
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : APP/Controller/PluginsController.php

App::uses('Sanitize', 'Utility');

class PluginsController extends AppController {


 public  $components = array('Edublog');

 public function beforeFilter() 
 {
   parent::beforeFilter();
   $this->Auth->allow(array('admin_listing'));
 }
 
 public function display($username)
 {
   $data = $this->Knet->findKnets($username);
   $this->set('data', $data);
 }
  
  /**== ADMIN METHODS==**/
 public function admin_listing()
 {
   $this->layout = 'admin';
   $plugins = Configure::listObjects('plugin');
   Configure::load('plugin_descriptions');
   $result = array();
   foreach ($plugins as $plugin):
         $result[$plugin] = Configure::read($plugin);
         #unset($result[$plugin]['id'],$result[$plugin]['name'],$result[$plugin]['active']);
   endforeach;

   die(debug($result));
   #$data = $this->Knet->findKnets($username);
   #$this->set('data', $data);
 }

}
# ? > EOF
