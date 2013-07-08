<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright (c) 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package blog
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : APP/Controller/EntriesController.php

/**
 * Include files
 */
App::uses('Sanitize', 'Utility');

class EntriesController extends AppController {
  
/**
 *  CakePHP Helpers
 *  @var array
 *  @access public
 */ 
 public $helpers       = array('Ck', 'Rss', 'Text', 'Cache', 'Fpdf');

/**
 *  CakePHP components
 *  @var array
 *  @access public
 */
 public $components    = array('Mailer', 'Edublog', 'Search', 'Captcha', 'Pdf');

/**
 *  Cake paginate
 *  @var array
 *  @access public
 */ 
 public $paginate = array('limit' => 7, 'page' => 1, 'order' => array('Entry.id' => 'DESC'), 'fields'=> array('Entry.title', 'Entry.body', 'Entry.created', 'Entry.user_id', 'Entry.discussion', 'Entry.subject_id', 'Entry.id', 'User.username', 'Subject.title', 'Subject.id')
  );

 /* 
 # Not yet implemented 
 public $cacheAction = array(
                             'admin_start' => '8 hours',
                             'admin_edit'  => '3 minutes',
                             'view'        => '3 minutes'
                             ); */

/**
 *  Auth Component permisssions
 *  @access public
 *  @return void 
 */
 public function beforeFilter() 
 {
   parent::beforeFilter();
   $this->Auth->allow(array('display', 'view', 'lastEntries', 'rss', 'search', 'renderpdf', 'totalVisits'));
 } 


/**
 *  lastEntries   get last ten published entries to show in FrontPage
 *  @access public
 *  @return mixed   return array entries data or False if query is null
 */
 public function lastEntries() 
 { 
   $params = array('conditions' => array('Entry.status'=>1),
                   'fields'     => array('Entry.title', 'Entry.id', 'Entry.user_id', 'User.username'),
                   'order'      => 'Entry.id DESC',
                   'limit'      => 10
                    );
   return $this->Entry->find('all', $params); 
 }
 
/**
 *  display method.  Get last published entries to this blogger
 *  @access public
 *  @param string $username  blogger username 
 *  @return mixed   return array entries data or False if query is null
 */
 public function display($username) 
 {
  $this->Edublog->setUserId($username); # blogger elements  
  $this->paginate['Entry'] = array(
                                  'contain' => array('Comment'=> array(
                                                                       'conditions' => array('Comment.status'=>1),
                                                                       'fields' =>array('id')
                                                                      ),
                                                      'User'  => array(
                                                                       'fields' => array('username')
                                                                       ),
                                                      'Subject'  => array(
                                                                          'fields' => array('title', 'id')
                                                                      )
                                                    ),
                                   'order'      => 'Entry.order DESC',
                                   'fields'     => array('title', 'body', 'status', 'id', 'discussion', 'user_id', 'created'),
                                   'conditions' => array('Entry.user_id'=>$this->Edublog->userId, 'Entry.status'=>1),
                                   'limit'      => 20
  );
  $data = $this->paginate('Entry'); 
  $this->set(compact('data'));          
 }

/**
 *  view   Get one entrie belonging to this blogger
 *  @access public
 *  @param string  $username  blogger username 
 *  @param integer $entry_id  Entry Id
 *  @return mixed  return array entry data or False if query is null
 */
 public function view($username, $entry_id)
 {
  $this->Edublog->setUserId($username); # blogger elements
    
  $params = array('conditions'=> array('Entry.user_id'=>$this->Edublog->userId, 'Entry.status'=>1, 'Entry.id'=>$entry_id),
                  'fields'    => array('Entry.title', 'Entry.body', 'Entry.created', 'Entry.user_id', 'Entry.discussion', 
                                      'Entry.subject_id', 'Entry.id', 'User.username', 'Subject.title', 'Subject.id'),
                  'recursive' => 2
                  );
  $data = $this->Entry->find('first', $params);

  if ( !$data ):
      throw new NotFoundException('Could not find entry');
  endif;

  $this->set('data',$data);
  }
 
/**
 *  Last entries
 *  @access public
 *  @return void
 *  @param $user_id
 */
 public function totalVisits($user_id) 
 { 
   return $this->Entry->totalVisits($user_id);
 }

/**
 *  rss   Get last published entries to this blogger to create XML output
 *  @access public
 *  @param string $username  blogger username 
 *  @return mixed   return array entries data or False if query is null
 */
 public function rss($username)
 {
  # blogger data
  $params = array('conditions'=>array('username'=>$username),
                  'fields'    => array('User.id', 'User.username','User.name','User.email', 'User.avatar'),
                  'contain'    => False);
  $user = $this->Entry->User->find('first', $params); 
  $this->set('user',  $user);

  $params = array('conditions' => array('Entry.status'=>1, 'Entry.user_id'=>$user['User']['id']),
                  'fields'     => array('Entry.id','Entry.title','Entry.created','Entry.body','Entry.subject_id','Entry.user_id'),
                  'order'      => 'Entry.order DESC',
                  'limit'      => 20,
                  'contain'    => False
                 );
  $entries = $this->Entry->find('all', $params);
  #die(debug($entries));
  $this->set(compact('entries'));
 }
 
/**
 * Search in blog
 * @access public
 * @return void
 */
 public function search() 
 {
  $this->layout    = 'portal';
  $terms = Sanitize::escape($this->request->data['Entry']['terms']); 
  $this->set('data', $this->Search->getRows($terms));
 }

/**
 *  Render Entry as PDF Document
 *  Using TCPDF Class and Component Pdf 
 *  @access public 
 *  @param string $username 
 *  @param integer $entry_id
 *  @return void 
 */
 public function renderpdf($username, $entry_id)
 {
   $this->layout='pdf';
   $this->Edublog->setUserId($username); # blogger elements
    
   $params = array('conditions'=> array('Entry.user_id'=>$this->Edublog->userId, 'Entry.status'=>1, 'Entry.id'=>$entry_id),
                  'fields'    => array('Entry.title', 'Entry.body', 'Entry.created', 'Entry.user_id', 'Entry.discussion', 
                                      'Entry.subject_id', 'Entry.id', 'User.username', 'Subject.title', 'Subject.id'),
                  'recursive' =>2
                  );
   $this->Entry->User->contain(False); # detach
   $data=$this->Entry->find('first', $params);
   $link=$this->Pdf->renderEntry($data);
 }
 
/** ====  ADMIN ACL METHODS ====*/
/**
 * The Magic beggins!
 * @access public
 * @return void
 */
 public function admin_start()
 {  
   $this->layout = 'admin';
   $params = array('conditions' => array('Entry.user_id'=> $this->Auth->user('id')),
                   'fields'     => array('id'));
   $this->set('data', $this->Entry->find('first', $params));
 }

/**
 * Welcome message
 * @access public
 * @return void
 */
 public function admin_general() 
 {
   $this->layout = 'help';
 }
 
/**
 * Display list
 * @access public
 * @return void
 */
 public function admin_listing($ajaxTrue=False) 
 {
  $this->set('ajaxTrue', $ajaxTrue);
  if ( $ajaxTrue == False ):
      $this->layout = 'admin';
  else:     
      $this->layout     = 'ajax';
  endif;
  $this->paginate['Entry'] = array(
                                  'contain' => array('Comment'=> array(
                                                                       'conditions' => array('Comment.status !='=>7),
                                                                       'fields'     => array('id')
                                                                        )),
                                  'order'      => 'Entry.order DESC',
                                  'fields'     => array('title', 'status', 'id', 'created', 'order'),
                                  'conditions' => array('Entry.user_id'=>$this->Auth->user('id')),
                                  'limit'      => 20
                                  );
  $data = $this->paginate('Entry');
  $this->set(compact('data'));
 }

/**
 *  Using for ajax autosave
 *  @access public
 *  @return void
 */
 public function admin_record()
 {
  $this->autoRender = False; 
  $this->layout     = 'ajax';
  
  if ( !isset($this->request->data['Entry']['id']) ):
      $this->request->data['Entry']['user_id'] = (int) $this->Auth->user('id');
  endif;

  if ($this->Entry->save($this->request->data)):
	  $this->Session->setFlash(__('Draft Saved'));  
  else:
  	  $this->Session->setFlash(__('Connection error'));  
  endif;
 }
 
/**
 * Add/Edit entry
 * @access public
 * @param mixed
 * @return void
 */ 
 public function admin_edit($entry_id = Null)
 { 
  $this->layout = 'ajax'; #always is ajax
  $this->set('subjects',Set::combine($this->Entry->Subject->find('all',array('order'=>'title')),"{n}.Subject.id","{n}.Subject.title"));
  if (!empty($this->request->data['Entry'])):
     if ( !isset($this->request->data['Entry']['id']) ):
         $this->request->data['Entry']['user_id'] = (int) $this->Auth->user('id');
     endif;
     if ($this->Entry->save($this->request->data)):
	        if ($this->request->data['Entry']['end'] == 0 && !isset($this->request->data['Entry']['id'])): # new entry
                $id = $this->Entry->getLastInsertID();
                $return = '/admin/entries/edit/'.$id;
            elseif ($this->request->data['Entry']['end'] == 0 && isset($this->request->data['Entry']['id'])):
                $return = '/admin/entries/edit/'.$this->request->data['Entry']['id'];
	        elseif ($this->request->data['Entry']['end'] == 1 ):
	            $return = '/admin/entries/listing/1';
	        endif;
            $this->msgFlash(__('Data saved'), $return);
	 endif;
 elseif($entry_id != null && intval($entry_id)):
     $this->request->data = $this->Entry->read(Null, $entry_id);
 else:
	 #Created draft Entry, this means there never is a "new" entry to save
	 $this->request->data['Entry']['user_id']    = (int) $this->Auth->user('id');
   	 $this->request->data['Entry']['title']      = __('New draft');
     $this->request->data['Entry']['body']       = __('draft');
	 $this->request->data['Entry']['subject_id'] = 1; 
	 if ($this->Entry->save($this->request->data['Entry'], False)):  #Save register without validation 
		 #Clean array data 
		 $this->request->data['Entry']['title']   = '';
		 $this->request->data['Entry']['body']    = '';
		 #Get last insert id
		 $this->request->data['Entry']['id']      = $this->Entry->id;
         $this->set('autosave');
     endif;
 endif;
 }

/**
 *  Update entre order select two rows and intrechang order depending sense and order
 *  @param  sense int  up or down
 *  @param order int  current value in column Entry.order  
 *  @param Kind a bubble sort  
 *  @access public
 *  @return void
 */
 public function admin_order($sense, $entry_id, $order)
 {
  $user_id = (int) $this->Auth->user('id');
  if ($sense == 'down'):
       $conditions = array('Entry.order <= ' .$order, 'Entry.user_id'=>$user_id); # next up
       $order      =  'order DESC';
  else:
       $conditions = array('Entry.order >= '.$order, 'Entry.user_id'=>$user_id);  # next down
       $order      =  'order ASC'; 
  endif; 
  $params = array(
             'conditions' => $conditions,
             'order'      => $order,
             'fields'     => array('id', 'order'),
             'limit'      => 2,
             'contain'    => False
             );
  $data = $this->Entry->find('all', $params);
  #die(debug($data));
  for($i=0;$i < 2;$i++):  # loop changing orders
      if ($i === 0):
         $this->Entry->id = $data[0]['Entry']['id'];
         $new_order = $data[1]['Entry']['order'];
      else:
         $this->Entry->id = $data[1]['Entry']['id'];
         $new_order = $data[0]['Entry']['order'];
      endif;
      $this->Entry->saveField('order', $new_order);
  endfor;
  $this->msgFlash(__('Data saved'), $this->referer());
 }


/**
 *  Change status enabled/disabled actived 
 *  @access public
 *  @param integer $entry_id
 *  @param integer $status
 *  @param integer $current_page
 *  @param string  $sort
 *  @param string  $direction
 *  @return void
 */
 public function admin_change($entry_id, $status, $current_page = 1, $sort = 'id', $direction)
 {  
    if ( $sort == 'id' ):
        $return = '/admin/entries/listing/1/page:'.$current_page;
    else:
        $return = '/admin/entries/listing/1/page:'.$current_page.'/sort:'.$sort.'/direction:'.$direction;
    endif;

    $new_status      = ($status == 0 ) ? 1 : 0;     
    $this->Entry->id = (int) $entry_id;
    if ($this->Entry->saveField('status', $new_status)):
	    $this->msgFlash(__('Status modified'), $return);
    endif;
 }

/**
 * Show comments
 * @access public
 * @return void
 */
 public function admin_comments()
 {    
   $this->layout    = 'admin';
   $this->set('data', $this->Entry->getComments($this->Auth->user('id'))); 
 }

/**
 * 
 * @access public
 * @return void
 */
 public function admin_review()
 {    
   $this->layout = 'admin';
   $this->set('data', $this->Entry->getComments($this->Auth->user('id'))); 
 }
 
/**
 * Remove entry
 * @access public
 * @return void
 */
 public function admin_delete($entry_id)
 {
   if ( $this->Entry->delete($entry_id) ):
       $this->admin_listing(True);
       $this->render('admin_listing');
       $this->Session->setFlash(__('Data removed',True));
   endif;
 }
}
# ? > EOF
