<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package news
*  @license http://www.gnu.org/licenses/agpl.html
*/
#file:  APP/Controller/NewsController.php

App::uses('Sanitize', 'Utility');

class NewsController extends AppController {

/**
 *  CakePHP Helpers
 *  @var array
 *  @access public
 */ 
 public $helpers  = array('Ck', 'News', 'Time', 'Text', 'Rss');
 

/**
 *  CakePHP Paginate
 *  @var array
 *  @access public
 */ 
  public $paginate = array();

/**
 *  CakePHP Auth allowed actions
 *  @var array
 *  @access public
 */
 private $_allowed =  array('view', 'display', 'rss', 'category');

/**
 *  Auth Component permisssions
 *  @access public
 *  @return void 
 */  
 public function beforeFilter() 
 {
  parent::beforeFilter();
  $this->Auth->allow($this->_allowed);
 }
 
/**
 *  Karamelo frontend (see routes.php)
 *  @access public
 *  @return void
 */
 public function display() 
 {
  # Karamelo Installer
  if ( !file_exists('../Config/installed.txt') ):
	  header('Location: /install/installs/index');
      die;
  endif;
  $this->layout = 'portal';
  $this->paginate['limit'] = 8; 
  $this->paginate['order'] = array('News.id' => 'DESC');
  $this->paginate['conditions'] = array('News.status = 1');
  $this->paginate['fields'] = array('News.id', 'News.title', 'News.body','News.created','News.theme_id', 'News.reference', 'User.username',                                     'Theme.theme',  'Theme.img', 'Theme.description');
  $data = $this->paginate('News');
  $this->set(compact('data')); 
 }
 
/**
 *  Display one new
 *  @param integer $new_id
 *  @access public
 *  @return void
 */
 public function view($new_id)
 {
  if ( $new_id == Null or !intval($new_id) ):
      $this->redirect('/');
  endif;
  $this->layout = 'portal';

  $this->News->User->contain(False); 
  $this->News->Discussion->unbindModel(array('belongsTo'=>array('News')));

  $params = array('conditions' => array('News.status'=>1, 'News.id'=>$new_id),
                   'fields'    => array('News.id','News.title','News.comments', 'News.body', 'News.created', 'News.reference', 
                                         'News.theme_id', 'News.user_id', 'Theme.img', 'Theme.theme', 'User.username'),
                   'recursive' => 2
                   );
  $data =  $this->News->find('first', $params);
  #die(debug($data));
  $this->set('data', $data);
 }
  
/**
 * Create an rss feed of the 15 last uploaded uses the RSS component
 * @access public
 * @return void
 */
 public function rss() 
 {
  $channelData = array('title'        => 'Karamelo eLearning Portal ',
		                'link'        => array('controller' => 'news', 'action' => 'display'),
                        'description' => 'Latest news on Karamelo',
		                'language'    => 'en-us'
		               );     
  $params = array('conditions'  => array('News.status'=>1),
                   'fields'     => array('News.id', 'News.title', 'News.body', 'News.created', 'News.theme_id', 'News.user_id'),
                   'order'      => 'News.id DESC',
                   'limit'      => 15,
                   'contain'    => False);
  $newss = $this->News->find('all', $params);
  #die(debug($newss));
  $this->set(compact('newss'));
  #$this->set(compact('channelData', 'newss'));
 }

/**
 * Display category news
 * @access public
 * @return void
 */
 public function category($theme_id) 
 {  
   $this->layout = 'portal';
   if ($theme_id == null):
       $this->redirect('/');
       return False;
   endif;
   $this->paginate['conditions']   = array('News.status'=>1, 'Theme.id' => $theme_id);
   $this->paginate['fields']       = array('News.id', 'News.title', 'Theme.theme', 'Theme.img');
   $this->paginate['order']        = 'News.id DESC';
   $this->paginate['limit']        = 30;
   $data = $this->paginate('News');
   $this->set(compact('data'));
  }
  
/*** ======ADMIN METHODS === *****/
/**
 * News manager
 * @access public
 * @return void
 */
 public function admin_listing() 
 {
  $this->layout = 'admin';
  $this->News->unbindModel(array('hasMany'=>array('Discussion')));  
  $this->paginate['conditions']   = Null;
  $this->paginate['fields']       = array('News.id', 'News.title', 'News.created', 'News.status',  'News.user_id', 'User.username');
  $this->paginate['order']        = 'News.id DESC';
  $this->paginate['limit']        = 20;
  $data = $this->paginate('News');
  $this->set(compact('data'));
 }
  
/**
 * Change user status actived/no actived
 * @access public
 * @return void
 */
 public function admin_change($status, $news_id)
 {  
   $new_status     = ($status == 0 ) ? 1 : 0;  
   $this->News->id = (int) $news_id;  
   if ($this->News->saveField('status', $new_status)):
       $this->msgFlash(__('Status modified'), '/admin/news/listing');
   endif;
 }

/**
 * Change user status actived/no actived
 * @access public
 * @return void
 */
 public function admin_edit($news_id=Null)
 {
  $this->layout    = 'admin';
  $this->set('themes', Set::combine($this->News->Theme->find('all', array('order'=>'theme')),"{n}.Theme.id","{n}.Theme.theme"));
 
  if ( !empty($this->request->data['News']) ):
      $this->request->data['News']['user_id']   = (int) $this->Auth->user('id');
      if ($this->News->save($this->request->data)):
          if ( $this->request->data['News']['end'] == 0 && !isset($this->request->data['News']['id']) ):
              $id = $this->News->getLastInsertID();
              $this->msgFlash(__('Data saved'), '/admin/news/edit/'.$id);
          elseif ($this->request->data['News']['end'] == 0 && isset($this->request->data['News']['id']) ): 
              $this->msgFlash(__('Data saved'), '/admin/news/edit/'.$this->request->data['News']['id']);
          elseif($this->request->data['News']['end'] == 1):
              $this->msgFlash(__('Data saved'), '/admin/news/listing');
	      endif;
	  endif;
  elseif( $news_id != Null && intval($news_id)):
      $this->request->data  = $this->News->read(Null, $news_id);
  endif;
 }

/**
 * Delete news
 * @access public
 * @return void
 */  
 public function admin_delete($news_id) 
 {   
   if ( $this->News->delete($news_id) ):
       $this->msgFlash(__('Data removed'), '/admin/news/listing/');
   endif; 
 }
}

# ? > EOF
