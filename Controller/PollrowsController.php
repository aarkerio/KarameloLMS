<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package polls
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /app/controllers/PollrowsController.php

App::uses('Sanitize', 'Utility');

class PollrowsController extends AppController {


 public function beforeFilter() 
 {
   parent::beforeFilter();
   $this->Auth->allow(array('vote'));
 }

 public function vote() 
 {
  $this->layout = 'ajax';
    
  # adds new vote to database
  if (!empty($this->request->data['Pollrow'])):  
      # die(print_r($this->request->data));
      $vote  = $this->Pollrow->field('vote', array('Pollrow.id' => $this->request->data['Pollrow']['id']));
      #die(var_dump($vote));     
      $vote += 1;
      
      #exit("votes " . $vote);
      $this->Pollrow->id = $this->request->data['Pollrow']['id'];
      
      if ( $this->Pollrow->saveField('vote',$vote) ):  # add the Poll vote
           $this->Session->write('poll_id',  $this->request->data['Pollrow']['poll_id']); # set session, only one vote per session       
           $params = array('conditions' => array('Poll.id' => $this->request->data['Pollrow']['poll_id']));
           $this->set('poll', $this->Pollrow->Poll->find('first', $params));
           $this->render('results', 'ajax');
      endif;   
  endif;
 }

 /*== ADMIN METHODS ==*/  
 public function admin_add() 
 {
   if (!empty($this->request->data['Pollrow'])):
      if ($this->Pollrow->save($this->request->data)):   //save the Poll vote
          $params =array(
                         'conditions' => array('poll_id' => $this->request->data['Pollrow']['poll_id'], 'GROUP BY'=> 'answer, color'),
                         'fields'     => array('id', 'answer', 'color'),
                         'order'      => 'Pollrow.vote ASC'
                         );
          $this->set('data', $this->Pollrow->find('all', $params));  
	      $this->render('results', 'ajax');
      endif;		
  endif;	
 }
 
 public function admin_edit($id)
 {
  if (empty($this->request->data)):
        $this->layout = 'admin';
        
        $this->Pollrow->poll_id = $id;
              
        $this->request->data = $this->Pollrow->read();
  else:
      if ($this->Message->save($this->request->data)):
            $this->redirect('/polls/listing');
        endif;
  endif;
 }
   
 public function admin_delete($pollrow_id, $poll_id)
 {
   # deletes from database
   if ($this->Pollrow->delete($pollrow_id)):
	 $this->msgFlash(__('Data removed', true), '/admin/polls/view/'.$poll_id);
   endif;
 }
}
# ? > EOF
