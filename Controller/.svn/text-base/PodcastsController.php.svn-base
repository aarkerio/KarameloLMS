<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package podcasts
*  @license http://www.gnu.org/licenses/agpl.html
*  Check ftp://chipotle-software.com/pub/karamelo/INSTALL.txt
*/
# file: APP/Controller/PodcastsController.php

App::import('Vendor', 'CMP3File',  array('file' => 'CMP3File.php'));

/**
 * Import libraries
 */
App::uses('Sanitize', 'Utility');

class PodcastsController extends AppController {
      
/**
 * CakePHP Helpers
 * @access public
 * @var array
 */
 public $helpers    = array('User', 'Text');

/**
 * CakePHP Components
 * @access public
 * @var array
 */
 public $components = array('Mailer', 'Edublog', 'Adds');

/**
 * Auth component
 * @access public
 * @return void
 */
 public function beforeFilter() 
 {
   parent::beforeFilter();
   $this->Auth->allow(array('display', 'rss', 'show', 'recent', 'funny', 'blogElement'));   
 }

/**
 * charge element in edublog
 * @access public
 * @return void
 */
 public function blogElement($user_id) 
 {
  $conditions = array('Podcast.user_id'=>$user_id, 'Podcast.status'=>1);
  if ( !$this->Auth->user() || !$this->Edublog->generalBelongs($this->Auth->user('id'))):
       $conditions['Podcast.public'] = 1;
  endif;

  $params = array('conditions' => $conditions,
                  'fields'     => array('Podcast.id', 'Podcast.title'),
                  'order'      => 'Podcast.id DESC',
                  'limit'      => 10);
  $this->Podcast->contain();
  return $this->Podcast->find('all', $params); 
 }

/**
 * charge element in edublog
 * @access public
 * @return void
 */
 public function display($username)
 { 
  $this->Edublog->setUserId($username); # blogger elements
  $conditions = array('Podcast.user_id'=>$this->Edublog->userId, 'Podcast.status'=>1);
  if ( !$this->Auth->user() || !$this->Edublog->generalBelongs($this->Auth->user('id'))):
       $conditions['Podcast.public'] = 1;
  endif;

  $params = array('conditions' => $conditions,
                   'fields'     => array('Podcast.id','Podcast.title', 'Podcast.description','Podcast.created','Podcast.filename', 'Podcast.length','Podcast.duration', 'User.username'),
                   'order'      => 'Podcast.id DESC',
                   'limit'      => 30);
  $this->Podcast->bindModel(array('belongsTo'=>array('User')));
  $this->set('data', $this->Podcast->find('all', $params));
 }

/**
 * charge element in edublog
 * @access public
 * @return void
 */ 
 public function recent()
 {
   $this->layout    = 'portal';
   $params = array('conditions' => array('Podcast.status'=>1),
                   'fields'     => array('Podcast.id','Podcast.title', 'Podcast.description','Podcast.created','Podcast.filename', 'Podcast.length','Podcast.duration', 'User.username'),
                   'order'      => 'Podcast.id DESC',
                   'limit'      => 20);
   $this->set('data', $this->Podcast->find('all', $params));
 }
 
/**
 * RSS feeder
 * @access public
 * @return void
 */
 public function rss($username) 
 { 
  # blogger data
  $params = array('conditions' => array('username'=>$username),
                  'fields'     => array('User.id', 'User.username','User.name','User.email', 'User.avatar'),
                  'contain'    => False);
  $user = $this->Podcast->User->find('first', $params);
 
  $this->set('user',  $user);

  $params = array('conditions' => array('Podcast.status'=>1, 'Podcast.user_id'=>$user['User']['id']),
                   'fields'     => array('Podcast.id', 'Podcast.title', 'Podcast.filename', 'Podcast.description', 'Podcast.keywords', 'Podcast.created', 'Podcast.duration', 'Podcast.title', 'Podcast.length', 'Podcast.subject_id', 'Subject.title'),
                   'order'      => 'Podcast.created DESC',
                   'limit'      => 12,
                   'contain'    => 'Subject');
   $podcasts = $this->Podcast->find('all', $params);
   #die(debug($podcasts));
   $this->set(compact('podcasts'));
 }

/**
 * Show podcast
 * @access public
 * @return void
 */
 public function show($username, $podcast_id)
 {
  $this->Edublog->setUserId($username); # blogger elements
  $params = array(
                  'conditions' => array('Podcast.id'=>$podcast_id, 'Podcast.status'=>1),
                  'fields'     => array('id', 'title', 'description', 'created', 'filename', 'length', 'duration')
                 );
  $this->set('data', $this->Podcast->find('first', $params));
 }


 public function  funny()
 { #eastern egg
   return True;
 }
    
/****** ====ADMIN METHODS==== ***/    

/**
 * 
 * @access public
 * @return void
 */
 public function admin_listing()
 {           
  $this->layout = 'admin';      
  $params = array('conditions' => array('Podcast.user_id'=>$this->Auth->user('id')),
                  'fields'     => array('id', 'title', 'description', 'created', 'length', 'status', 'filename'),
                  'order'      => 'Podcast.id DESC',
                  'limit'      => 12,
                  'contain'    => False);
    $this->set('data', $this->Podcast->find('all', $params)); 
 }
    
 public function admin_add() 
 {
  $this->layout    = 'admin';
  $this->set('subjects', Set::combine($this->Podcast->Subject->find('all', array('order' => 'title')), "{n}.Subject.id","{n}.Subject.title"));
  if (!empty($this->request->data) && is_uploaded_file($this->request->data['Podcast']['file']['tmp_name'])):
      /* SUBMITTED INFORMATION - use what you need
       *  temporary filename (pointer): $podfile
       *  original filename           : $podfile_name
       *  size of uploaded file       : $podfile_size
       *  mime-type of uploaded file  : $podfile_type
       */
      /** uploaddir:  directory relative to where script is runing */
      $uploaddir    = '..'.DS.'webroot'.DS.'files'.DS.'podcasts';
      $maxfilesize  = 41943040; # 40 MB max size
      $podfile_name = $this->request->data['Podcast']['file']['name'];
      $podfile_size = $this->request->data['Podcast']['file']['size'];
      $podfile      = $this->request->data['Podcast']['file']['tmp_name'];
      $type         = $this->request->data['Podcast']['file']['type'];

      /** Security: checks to see if file is an image, if not do not allow upload ==*/
      $types = array('audio/mpeg', 'audio/x-mp3',  'audio/mp3');
      
      if ( !in_array($type, $types) ):  # valid file ??
          $err = "ERROR the file $podfile_name is not valid. Only .mp3 files. The current type file: " . $type;
          unlink($podfile);  # delete uploaded file 
          $this->flash($err,'/admin/podcasts/add/', 3);
          return False;
      endif;
    
      if ( $podfile_size > $maxfilesize):
          unlink($podfile);
          $this->flash(__('The audio file is too big. Bigger than 40.0 MB'),'/admin/podcasts/edit', 3);
          return False;
      endif;
          
      $field       = 'id';
      $conditions  = array('user_id' =>  $this->Auth->user('id'));
      $order       = 'Podcast.id DESC';
      $current_id  = $this->Podcast->field($field, $conditions, $order);
      $next_id     = ($current_id + 1);
      $extension   = $this->Adds->last3chars($podfile_name);   # get the file extesion
      #die( 'Next ID '. $next_id );
      if ($extension != 'mp3'):
          unlink($podfile);
          $this->flash( __('This file does not look like one MP3 file'), '/admin/podcasts/edit', 3);
          return False;
      endif;
      $Name  = $this->Auth->user('username') . "_" . $next_id . '.'. $extension;
	 
      /** setup final file location and name */
      /** change spaces to underscores in filename  */
      $final_filename = str_replace(" ", "_", $Name);
      $newfile = $uploaddir . "/" . $final_filename;
    
      /** do extra security check to prevent malicious abuse */
      if (is_uploaded_file($podfile)):
          /** move file to proper directory ==*/
          if (!move_uploaded_file($podfile, $newfile)):
               /** if an error occurs the file could not
               be written, read or possibly does not exist ==*/
               $this->flash('Error Uploading File.', '/admin/podcasts/listing/', 3);
               return False;
          endif;
      endif;
  
      $mp3file = new CMP3File;  
      $infoFile = $mp3file->getid3($newfile);
  
      /** The database stuff  **/
      $this->request->data['Podcast']['filename']    = $final_filename;
      $this->request->data['Podcast']['length']      = $infoFile['size'];
      $this->request->data['Podcast']['duration']    = $infoFile['duration'];
      $this->request->data['Podcast']['user_id']     = $this->Auth->user('id');
      if ($this->Podcast->save($this->request->data)):
          $this->msgFlash(__('Data saved'),'/admin/podcasts/listing');
      endif;
  endif;
 }

/**
 * charge element in edublog
 * @access publi
 * @return void
 */
 public function admin_edit($podcast_id=null)
 {     
  $this->layout = 'admin';
  $this->set('subjects', Set::combine($this->Podcast->Subject->find('all',array('order'=>'title')),'{n}.Subject.id','{n}.Subject.title'));
  
  if (empty($this->request->data['Podcast'])):
      $this->request->data = $this->Podcast->read(null, $podcast_id);
  else:
      $this->request->data['Podcast']['title'] = Sanitize::paranoid($this->request->data['Podcast']['title'], $this->para_allowed);
      if ($this->Podcast->save($this->request->data)):
          $this->msgFlash(__('Data saved'),'/admin/podcasts/listing'); 
      endif;
  endif;
 }
 
/**
 * Change status enabled/disabled actived 
 * @access public
 * @return void
 */
 public function admin_change($podcast_id, $status)
 {
   $new_status          = ($status == 0 ) ? 1 : 0;
   $this->Podcast->id   = (int) $podcast_id;
   
   if ($this->Podcast->saveField('status', $new_status)):
        $this->msgFlash(__('Status modified'), '/admin/podcasts/listing');
   endif;
 }

/**
 * charge element in edublog
 * @access publi
 * @return void
 */
 public function admin_delete($podcast_id)
 {
  if ( $this->Podcast->delete( $podcast_id ) ):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/podcasts/listing');
 }
}
# ? > EOF
