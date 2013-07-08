<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package galleries
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : APP/Controller/GalleriesController.php
 
App::uses('Sanitize', 'Utility');

class GalleriesController extends AppController {

/**
 *  Auth component stuff
 *  @access public
 *  @return void
 */
 public function beforeFilter() 
 {
    parent::beforeFilter();
    $this->Auth->allow(array('display', 'discussion', 'view', 'index'));
 }
 
 public function index($id = null)
 {
  $this->set('data', $this->User->find('all')); 
  $this->set('color', 'blue');
 }
    
 public function listview()
 {         
  $this->layout    = 'popup';
  $params = array(
                  'conditions' => array('user_id'=>$this->Auth->user('id')),
                  'fields'     => array('id', 'file', 'user_id'),
                  'order'      => 'Gallery.id DESC',
                  'limit'      => 20
                 );
  $this->set('data',  $this->Gallery->find('all', $params));
  $this->set('listview');
 }
    
/**    ===== ADMIN METHODS ======    */
 public function admin_listing()
 {      
  $this->layout    = 'admin';
  $params = array('conditions' => array('user_id'=>$this->Auth->user('id')),
                  'fields'     => array('id', 'title', 'user_id', 'status'),
                  'order'      => 'Gallery.title ASC');        
  $this->set('data', $this->Gallery->find('all', $params));
 }
  
 public function admin_add() 
 {    
   $this->layout    = 'admin'; 
   if (!empty($this->request->data['Gallery']) )
    {
      /** Database stuff  **/
      $this->request->data['Gallery']['user_id'] = (int) $this->Auth->user('id');
      
      if ($this->Gallery->save($this->request->data))
      {
        $this->msgFlash('Your gallery has been saved.', '/admin/galleries/listing');
      }
    }
 }
 
/**
 * DELETE  
 *
 */ 
 public function admin_delete($id, $imgfile)
 {
  if ( $this->Gallery->delete($id) ):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif;   
  $this->msgFlash($msg, '/admin/galleries/listing');
 }
}
# ? > EOF
