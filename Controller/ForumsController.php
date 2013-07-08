<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package forums
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : APP/Controller/ForumsController.php

App::uses('Sanitize', 'Utility');

class ForumsController extends AppController
{

/**
 *  CakePHP Helpers
 *  @var array
 *  @access public
 */ 
 public $helpers       = array('Time');
 
/**
 *  CakePHP Components
 *  @var array
 *  @access public
 */ 
 public $components    = array('Edublog', 'Email');


/**
 *  Auth Component permisssions
 *  @access public
 *  @return void 
 */ 
 public function beforeFilter() 
 {
    parent::beforeFilter();
    if ($this->Auth->User()):
        $this->Auth->allow(array('display', 'discussion', 'view', 'index'));
    endif;
 }

/**
 *   
 *  @access public
 *  @return void
 */ 
 public function index($username) 
 {
  $this->Edublog->setUserId($username); # blogger elements
  $params = array('conditions' => array('Forum.user_id'=> $this->Edublog->userId, 'Forum.status'=>1));
  #$fields     = array('Forum.title', 'Forum.id', 'Forum.user_id', 'Forum.description', 'Forum.catforum_id', 'Topic.id'); 
  $data       = $this->Forum->find('all', $params);
  if ( !$data ):
      $this->msgFlash(__('No such forum'), '/');
  endif;
  $this->set('data', $data);
 }
 
/**
 *  Show all forum threads
 *  @param string  $username
 *  @param integer $forum_id
 *  @param integer $vclassroom_id
 *  @access public
 *  @return void
 */
 public function display($username, $forum_id, $vclassroom_id) 
 {      
  # student belongst to this class?
  $this->set('belongs', $this->Forum->Vclassroom->UserVclassroom->belongs($this->Auth->user('id'), $vclassroom_id));
  $this->Edublog->setUserId($username);
  $params = array(
       'conditions' => array('Forum.id'=>$forum_id, 'Forum.status'=>1),
       'fields'     => array('Forum.title', 'Forum.id', 'Forum.user_id', 'Forum.description', 'Forum.catforum_id', 'Forum.vclassroom_id'),
       'recursive'  =>2
       );
  # This is a mess, please refactor it using Containable behaviour... 
  $this->Forum->Vclassroom->unbindModel(array('belongsTo'=>array('Ecourse', 'User'), 'hasAndBelongsToMany'=>array('User', 'Test', 'Webquest', 'Treasure'),'hasMany'=>array('Forum', 'Participation')));
  $this->Forum->Catforum->unbindModel(array('hasMany'=>array('Forum'), 'belongsTo'=>array('User')));
  $this->Forum->Catforum->User->unbindModel(array('belongsTo'=>array('Group'), 'hasMany'=>array('Lesson', 'Entry')));
  $this->Forum->Topic->unbindModel(array('belongsTo'=>array('Forum')));

  $data       = $this->Forum->find('first', $params);
 
  $this->set('data', $data);
 }
 
/**
 *  Show discussion
 *  @param string $
 *  @param integer $
 *  @param integer $
 *  @access public
 *  @return void
 */
 public function discussion($username, $forum_id, $topic_id)
 {      
   #$fields     = null; array'Forum.title', "Forum.id", "Forum.user_id", "Forum.description", "Forum.catforum_id");
   $params = array('conditions' => array("Topic.id = $topic_id OR Topic.topic_id=$topic_id"));
   $this->Forum->Topic->User->contain(False);
   $data = $this->Forum->Topic->find('all', $params);
   $this->set('data', $data);
   $this->Edublog->setUserId($username); # blogger elements 
 }
 
/* === ADMIN METHODS == */
/**
 *  
 *  @access public
 *  @return void
 */
 public function admin_listing() 
 {  
    $this->layout = 'admin';
    $params = array('conditions'=> array('Forum.user_id'=>$this->Auth->user('id')));
    $this->set('data', $this->Forum->find('all', $params));
 }

/**
 *  
 *  @access public
 *  @return void
 */
 public function admin_topics($forum_id)
 {
    if ( !is_int($forum_id) ):
       $this->redirect('/');
       return false;
    endif;
    
    $this->layout = 'admin';  
    $params = array('conditions' => array('Forum.user_id'=>$this->Auth->user('id'), 'Forum.id'=>$forum_id));
    $this->set('data', $this->Forum->find('first', $params));
 }
 
/**
 *  
 *  @access public
 *  @return void
 */
 public function admin_edit($catforum_id = null, $forum_id = null)
 {
   $this->layout = 'admin';
   $this->set('vclassrooms', $this->Forum->User->getVclassrooms($this->Auth->user('id'), True));
  
   if (!empty($this->request->data['Forum'])):
        if ( !isset($this->request->data['Forum']['id']) ):
            $this->request->data['Forum']['user_id'] = (int) $this->Auth->user('id');
        endif;
        $this->request->data['Forum']['title']   = Sanitize::paranoid($this->request->data['Forum']['title'], $this->para_allowed);
        $this->request->data['Forum']['user_id'] = (int) $this->Auth->user('id');
        if ($this->Forum->save($this->request->data)):
	        if ($this->request->data['Forum']['end'] == 0 && !isset($this->request->data['Forum']['id'])):
                $id = $this->Forum->getLastInsertID();
                $return = '/admin/forums/edit/'.$this->request->data['Forum']['catforum_id'].'/'.$id;    
            elseif ($this->request->data['Forum']['end'] == 0 && isset($this->request->data['Forum']['id'])):
                $return = '/admin/forums/edit/'.$this->request->data['Forum']['catforum_id'].'/'.$this->request->data['Forum']['id'];
	        elseif ($this->request->data['Forum']['end'] == 1 ):
	             $return = '/admin/catforums/listing';
	        endif;
            $this->msgFlash(__('Data saved', true),$return);
	    endif;
   elseif($forum_id != null && intval($forum_id)):
        $this->request->data = $this->Forum->read(null, $forum_id);
   elseif($catforum_id != null && intval($catforum_id)):
        $this->set('catforum_id', $catforum_id);
   endif;
 }


/**
 *  Change status published/draft 
 *  @access public
 *  @return void
 */
 public function admin_change($status, $forum_id)
 {  
    if ( !is_numeric($status)  ||  !intval($forum_id) ): 
        $this->redirect('/');
        return False;
    endif;
    $new_status = ($status == 0 ) ? 1 : 0;
     
    $this->Forum->id = (int) $forum_id;
     
    if ($this->Forum->saveField('status', $new_status)):
	    $this->msgFlash(__('Status modified'), '/admin/catforums/listing');
    endif;
 }
 
/**
 *  Remove forum  
 *  @access public
 *  @return void
 */
 public function admin_delete($forum_id)
 {
  if ( $this->Forum->delete($forum_id) ):           
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/catforums/listing');
 }
}
# ? > EOF
