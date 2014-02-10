<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package users
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /APP/Controller/ConfirmsController.php

/**
 * Load libraries
 */
App::uses('Sanitize', 'Utility');

class ConfirmsController extends AppController {

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */  
 public function beforeFilter() 
 {
    parent::beforeFilter();
    $this->Auth->allow(array('signup'));
 }

/**
 *  Confirm registration email
 *  @access public
 *  @param string $secret
 *  @return void 
 */
 public function signup($secret = Null)
 { 
  $params = array(
                   'conditions'      => array('secret' => $secret),
                   'fields'          => array('id', 'user_id',
                   'contain'         => False)
                  );
  $data  = $this->Confirm->find('first', $params);   
  # die(var_dump($data));
  if ($data != Null):
      $this->Confirm->User->id  = (int) $data['Confirm']['user_id'];
      if ($this->Confirm->User->saveField('active', '1') && $this->Confirm->delete($data['Confirm']['id'])):
          $this->flash(__('Your account has been activated'), '/', 2);
      endif;
  else:
      $this->flash(__('There is not such account'), '/', 2);
  endif;
 }
}

# ? > EOF

