<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package users
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : app/controller/groups_controller.php
 
App::uses('Sanitize', 'Utility');

class GroupsController extends AppController {

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */    
  public function beforeFilter() 
  {
     parent::beforeFilter();
  }

 /**   === ADMIN METHODS ===  **/ 
 public function admin_listing() 
 {
   $this->layout = 'admin';
   $this->set('data', $this->Group->find('all', array('order'=>'Group.name')));
 }

 public function admin_edit($group_id = null)
 {
    $this->layout = 'admin';

    if (empty($this->request->data['Group'])):
         $this->request->data = $this->Group->read(null, $group_id);
    else:
       $this->request->data['Group']['code'] = Sanitize::paranoid($this->request->data['Group']['code']);
       if ($this->Group->save($this->request->data['Group'])):
            $this->msgFlash(__('Data saved', true),'/admin/groups/listing');
        endif;
    endif;
 }

 /* public function admin_delete($group_id)
 {
  if ( $this->Group->delete($group_id) ):
     $this->msgFlash(__('Data removed', true),'/admin/groups/listing');
  endif;
  } 
  */
}
?>
