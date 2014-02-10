<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package tests
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : APP/Controller/ResultsController.php

App::uses('Sanitize', 'Utility');

class ResultsController extends AppController {
 
/**
 *  Load CakePHP Helpers
 *  @access public
 *  @var array
 */
 public $helpers       = array('Ck');
 
/**
 *  Load CakePHP Components
 *  @access public
 *  @var array
 */  
 public $components    = array('Edublog');

/**
 *  Auth Component defining permissions
 *  @access public
 *  @var array
 */  
 public function beforeFilter() 
 {
    parent::beforeFilter();
    $this->Auth->allow(array('result'));
 }

/**
 *  Display answers after save answers
 *  @access public
 *  @var array
 */  
 public function result()
 { 
  # die(debug($this->request->data));
  $this->layout    = $this->Edublog->layout($this->request->data['Result']['blogger_id']); 
  $this->Edublog->blog($this->request->data['Result']['blogger_id']); # set edublog components    
 
  $params = array(
              'conditions' => array('Result.status'=>1, 'Result.user_id'=>$user_id),
              'fields'     => array('Result.id', 'Result.title', 'Result.created', 'Result.body', 'Result.subject_id', 'Result.user_id', 'User.username'),
              'order'           => 'Result.id DESC',
              'limit'           => 20
                 );
  $this->set('data', $this->Result->find('all', $params));
 }
}

# ? > EOF
