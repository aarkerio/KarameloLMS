<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright 2006-2012, Chipotle Software(c)
*  @version 0.7
*  @package faqs
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : APP/Controller/FaqsController.php
 

# Import libraries
App::uses('Sanitize', 'Utility');

class FaqsController extends AppController {

/**
 *  Cake Helpers
 *  @var array
 *  @access public
 */ 
 public $helpers       = array('Ck');

/**
 *  Cake components
 *  @var array
 *  @access public
 */
 public $components   = array('Edublog');

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */  
 public function beforeFilter() 
 {
   parent::beforeFilter();
   $this->Auth->allow(array('tetris'));
 }

 public function tetris()
 {
   return True;  #eastern egg
 }

 /** ==== ADMIN METHODS  **/

/**
 * Display list
 * @access public
 * @param integer $catfaq_id
 * @return void
 */
 public function admin_listing($catfaq_id)
 {
   $this->layout = 'admin';
   $conditions = array('Faq.catfaq_id'=>$catfaq_id);

   if ( !$this->Auth->user('username') ): # user is not logged
       $conditions['Faq.access'] = 0; 
   endif;
   
   $params = array(
        'conditions'=> $conditions,
        'fields'    => array('Faq.id', 'Faq.catfaq_id', 'Faq.question', 'Faq.display', 'Faq.status', 'Faq.answer', 'Catfaq.title'),
        'order'     => 'Faq.display ASC',
        'contain'   => False); 

   $this->set('data',  $this->Faq->find('all', $params));
   $params2 = array('conditions' => array('Catfaq.id'=>$catfaq_id), 
                    'fields'     => array('id', 'title'),
                    'contain'    => False); 
   $this->set('catfaq', $this->Faq->Catfaq->find('first', $params2));
 }
   
/**
 * Update FAQ
 * @access public
 * @param mixed integer or Null
 * @return void
 */ 
 public function admin_edit($faq_id = Null)
 {
  $this->layout = 'admin';
    
  if (empty($this->request->data['Faq'])):
      $this->Faq->contain(False);
      $this->request->data = $this->Faq->read(Null, $faq_id);
  else:
      if ($this->Faq->save($this->request->data)):
	      if ( $this->request->data['Faq']['end'] == 1 ):
              $this->msgFlash(__('Data saved'),'/admin/faqs/listing/'.$this->request->data['Faq']['catfaq_id']);
	      else:
	          $this->msgFlash(__('Data saved'),'/admin/faqs/edit/'.$this->request->data['Faq']['id']);
	      endif;
      endif;
  endif;
 }

/**
 * Update Faq order
 * Get two rows and change order
 * @access public
 * @return void
 * @param string $sense
 * @param integer $faq_id
 * @param integer $order
 * @param integer $catfaq_id
 * @return void
 */ 
 public function admin_order($sense, $faq_id, $order, $catfaq_id)
 {
  if ($sense == 'up'):
      $conditions = array('Faq.display <= ' .$order, 'Faq.catfaq_id'=>$catfaq_id);
      $order      =  'display DESC';
  else:
      $conditions = array('Faq.display >= '.$order, 'Faq.catfaq_id'=>$catfaq_id);
      $order      =  'display ASC'; 
  endif;  

  $params = array(
                  'conditions' => $conditions,
                  'order'      => $order,
                  'fields'     => array('id', 'display'),
                  'limit'      => 2);
 $data = $this->Faq->find('all', $params);
  # die(debug($data));
  for($i=0;$i < 2;$i++):
      if ($i == 0):
          $this->Faq->id = $data[0]['Faq']['id'];
          $new_order = $data[1]['Faq']['display'];
      else:
          $this->Faq->id = $data[1]['Faq']['id'];
          $new_order = $data[0]['Faq']['display'];
      endif;
      $this->Faq->saveField('display', $new_order);
  endfor;
  $this->msgFlash(__('Data saved'), '/admin/faqs/listing/'.$catfaq_id.'#dv'.$faq_id);
 }


/**
 *  Change status enabled/disabled FAQ
 *  @access public
 *  @param integer $faq_id
 *  @param integer $catfaq_id
 *  @param integer $catfaq_id
 *  @return void
 */
 public function admin_change($faq_id, $catfaq_id, $status)
 { 
   $new_status  = ($status == 0 ) ? 1 : 0;
    
   $this->Faq->id = (int) $faq_id;
      
   if ($this->Faq->saveField('status', $new_status)):
       $this->msgFlash(__('Status modified'), '/admin/faqs/listing/'.$catfaq_id);
   endif;
 }

/**
 *  Remove entry
 *  @access public
 *  @param mixed integer $catfaq_id or Null
 *  @return void
 */
 public function admin_add($catfaq_id=Null)
 {
  $this->layout = 'ajax';
    
  if (!empty($this->request->data['Faq'])):
      $this->request->data['Faq']['user_id'] = (int) $this->Auth->user('id');
      $conditions = array('Faq.catfaq_id'=>$this->request->data['Faq']['catfaq_id']);
      $order      =  'display DESC';
        
      $display = $this->Faq->field('Faq.display', $conditions, $order);
      #die(debug($display));
      if ($display):
          $this->request->data['Faq']['display'] = (int) ($display+1);
      else:
          $this->request->data['Faq']['display'] = (int) 1;
      endif;

      if ($this->Faq->save($this->request->data)):
           $this->msgFlash(__('Data saved'), '/admin/faqs/listing/'.$this->request->data['Faq']['catfaq_id']);
	  endif;
   else:
       $this->set('catfaq_id', $catfaq_id );
   endif;
 }

/**
 *  Remove FAQ
 *  @access public
 *  @param integer $faq_id
 *  @param integer $catfaq_id
 *  @return void
 */
 public function admin_delete($faq_id, $catfaq_id)
 {
  if ($this->Faq->delete($faq_id)):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/faqs/listing/'.$catfaq_id);
 }
}
# ? > EOF
