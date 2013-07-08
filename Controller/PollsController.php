<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package polls
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /APP/Controller/PollsController.php

App::uses('Sanitize', 'Utility');

class PollsController extends AppController {
    
/**
 *  
 *  @access public
 *  @return void 
 */
 public function beforeFilter() 
 {
   parent::beforeFilter();
   $this->Auth->allow(array('poll'));
 }

/**
 *  
 *  @access public
 *  @return void 
 */
 public function poll() 
 { 
   $params = array('conditions' => array('Poll.status'=>1),
                   'fields'     => array('Poll.id', 'Poll.question'),
                   'order'      => 'Poll.id DESC',
                   'limit'      => 1);
   return $this->Poll->find('first', $params);
 }
 
/**== ADMIN METHODS **/

/**
 *  
 *  @access public
 *  @return void 
 */
 public function admin_listing()
 {
  $this->layout    = 'admin';
  $params = array('fields'    => array('id', 'question', 'created', 'status'),
                  'order'     => 'created DESC',
                  'recursive' => 2);

  $this->set('data', $this->Poll->find('all', $params));
 }
 
/**
 *  
 *  @access public
 *  @return void 
 */
 public function admin_add() 
 {
  $this->layout    = 'admin';
    
  if (!empty($this->request->data['Poll'])):
    #die(debug($this->request->data));
    $this->request->data['Poll']['user_id'] = (int) $this->Auth->user('id');
	 
    if ( $this->Poll->save($this->request->data)): 
       $this->Poll->id    = False;
       $this->Pollrow->id = False;
       $poll_id           = (int) $this->Poll->getLastInsertID();
       $colors            = array('green', 'blue', 'brown', 'yellow', 'orange', 'red', 'black', 'green', 'blue'); 
       $i                 = (int) 0;
      
       foreach($this->request->data['Pollrow'] as $pollrow):
          if ( strlen($pollrow) > 0 ): 
              $this->request->data['Pollrow'] = array('answer' => $pollrow, 'poll_id' => $poll_id, 'color'=>$colors[$i], 'id'=>false);
              if (!$this->Poll->Pollrow->save($this->request->data)):
                    die("Error " . $pollrow . "<br />" . $poll_id . "<br />");
              endif;
          endif;     
          $i++;
       endforeach;
    endif;
    $this->msgFlash(__('Data saved'), '/admin/polls/listing');
  endif;
 }
 
/**
 *  
 *  @access public
 *  @return void 
 */
 public function admin_edit($poll_id=Null)
 {
   if (empty($this->request->data['Poll'])):
        $this->layout = 'admin';
        $this->request->data = $this->Poll->read(Null, $poll_id);
    else:
        if ($this->Poll->save($this->request->data)):
            $this->msgFlash(__('Data saved'), '/admin/polls/listing');
        endif;
    endif;
 }

/**
 *  Change status enabled/disabled actived  
 *  @access public
 *  @return void 
 */
 public function admin_change($poll_id, $status)
 {
  $new_status = ($status == 0 ) ? 1 : 0;
  $this->Poll->id  = (int) $poll_id;

  if ($this->Poll->saveField('status', $new_status)):
      $this->msgFlash(__('Status modified'), '/admin/polls/listing');
  endif;
 }

/**
 *  
 *  @access public
 *  @return void 
 */
 public function admin_delete($poll_id)
 {
  if ( $this->Poll->delete($poll_id) ):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/polls/listing');
 }
}
# ? > EOF
