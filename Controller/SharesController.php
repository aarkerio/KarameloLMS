<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package shares
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/Controller/SharesController.php

/**
 * Import libraries
 */
App::uses('Sanitize', 'Utility');

class SharesController extends AppController {
   
/**
 * Load helpers
 * @access public
 * @var array
 */
 public  $helpers = array('Mime');

/**
 * Load components
 * @access public
 * @var array
 */
 public  $components = array('Edublog', 'Adds');

/**
 * Load helpers
 * @access public
 * @var string
 */
 public  $paginate = Null;

/**
 * Extension files allowed to upload
 * @access private
 * @var array
 */
 private $_allowed  = array('mht', 'pdf', 'doc', 'xls', 'xcf', 'pptx', 'pps', 'docx', 'xlsx', 'ppt', 'sxw', 'sxi', 'sxc','sxd', 'stw', 'odt', 'odc', 'swf', 'ods', 'odp', 'abw', 'html', 'zip', 'rar', 'gz', 'png', 'jpg', 'gif', 'svg', 'mp3', 'ogg', 'flac', 'txt', 'mpg', 'mpeg', 'flv', 'avi', 'mob', 'ppsx');

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */  
 public function beforeFilter()
 {
  parent::beforeFilter();
  $this->Auth->allow(array('download', 'display'));
 }

/**
 *  Dowload shared file
 *  @access public
 *  @return void 
 */
 public function download($secret)
 { 
  $this->layout    = 'ajax';
  $conditions      = array('Share.secret'=>$secret, 'Share.status'=>1);       
  $username = $this->Auth->user('username');

  if ( !$this->Auth->user() || !$this->Edublog->generalBelongs($this->Auth->user('id'))):
       $conditions['Share.public'] = 1;
  endif;
  $file  =  $this->Share->field('file', $conditions);
        
  if (!$file):
       $this->msgFlash(__('Resource is not public'), $this->referer());
      return False;
  else:
      $this->set('file', 'files/userfiles/'.$file);
  endif;
 }
 
/**
 *  Display shared files in edublog
 *  @access public
 *  @return void 
 */
 public function display($username) 
 {
   $this->Edublog->setUserId($username);
   $gBelongs = 
   $conditions = array('Share.user_id'=>$this->Edublog->userId, 'Share.status'=>1);
   #var_dump($gB);
   if ( !$this->Auth->user() || ! $this->Edublog->generalBelongs($this->Auth->user('id'))):
       $conditions['Share.public'] = 1;
   endif;
   #debug($conditions);
   $this->paginate['Share'] = array('conditions'  => $conditions,
                   'fields'      => array('id', 'file', 'description', 'secret'),
                   'order'       => 'Share.id DESC',
                   'limit'       => 30);
   #$this->set('data', $this->Share->find('all', $params)); 

   $data = $this->paginate('Share'); 
   $this->set(compact('data')); 
 }

 /**   === ADMIN METHOD ===  **/
 public function admin_listing()
 {
  if ( $this->RequestHandler->isAjax() ):
      $this->layout = 'ajax';
      $ajax = True;
  else:
      $this->layout = 'admin';
      $ajax = False;
  endif;   

  $this->set('subjects',Set::combine($this->Share->Subject->find('all',array('order'=>'title')),"{n}.Subject.id","{n}.Subject.title"));
  $this->paginate['limit']   = 20;
  $this->paginate['fields'] = array('Share.id', 'Share.file', 'Share.description', 'Share.created', 'Share.secret', 'Share.public', 'Share.status',  'Share.knet', 'Subject.title');
  $this->paginate['conditions'] = array('Share.user_id'=>$this->Auth->user('id'));
  $this->paginate['order']      = 'Share.id DESC';
  $data = $this->paginate('Share');
  $this->set(compact('data')); 
  $this->set('ajax', $ajax);  

  # Show error messages 
  if ($this->Session->check('CommentErrors')): 
     # Get session vars from admin_add() 
	 $this->Share->validationErrors = $this->Session->read('CommentErrors');
	 $this->request->data= $this->Session->read('Values'); 
     # Delete session vars
	 $this->Session->delete('CommentErrors');  
	 $this->Session->delete('Values');  
	 $this->set('show', true); 
  endif;
 }

/**
 * 
 *  @access public
 *  @return void 
 */
 public function admin_edit($share_id=null)
 {
  $this->layout = 'admin';    
  $this->set('subjects',Set::combine($this->Share->Subject->find('all',array('order'=>'title')),"{n}.Subject.id","{n}.Subject.title"));  
  if (!empty($this->request->data['Share'])):
        if ($this->Share->save($this->request->data)):
	         $this->msgFlash(__('Data saved'), '/admin/shares/listing');
	    endif;
  else:
        $this->request->data = $this->Share->read(null, $share_id);
  endif;
 }

/**
 *  Upload file
 *  @access public
 *  @return void 
 */
 public function admin_add() 
 {
  $this->layout = 'admin';
  if (!empty($this->request->data['Share'])):
      # echo "tmp_name : ". $this->request->data['Share']['file']['tmp_name'] . "<br />";//
      $this->request->data['Share'] = Sanitize::clean($this->request->data['Share']);
    
      /* SUBMITTED INFORMATION - use what you need
       *  temporary filename (pointer): $podfile
       *  original filename           : $podfile_name
       *  size of uploaded file       : $podfile_size
       *  mime-type of uploaded file  : $podfile_type
       */
      /** uploaddir:  directory relative to where script is runing */
      $uploaddir   = '../webroot/files/userfiles';
      $maxfilesize = 3145728000; # 300 MB max size
      $file_name   = $this->request->data['Share']['file']['name']; 
      $file_size   = $this->request->data['Share']['file']['size'];
      $file        = $this->request->data['Share']['file']['tmp_name']; 
      $type        = $this->request->data['Share']['file']['type'];

      if (empty($type)):
	      $error  = 'File needed'."\n";
	      $this->flash($error,'/admin/shares/listing/');
          return False;	
      endif;
    
      if (!is_uploaded_file($this->request->data['Share']['file']['tmp_name'])):
	      $error  = "Error the file ". $file_name . " is not valid"."\n";
	      $this->flash($error,'/admin/shares/listing/');
          return False;	
      endif;
    
      /** Security: checks to see if file is an image, if not do not allow upload ==*/
      if ( $type == 'application/x-php'):  # .php is not a valid file!!!   alert Will Robinson!!
          $msg = 'Error the file '. $file_name . ' is not valid. No se pueden agregar archivos .php, subelo como .txt';
          unlink($file);  # delete uploaded file 
          $this->flash($msg, '/admin/shares/listing', 3);
          return False;
      endif;
    
      if ( $file_size > $maxfilesize):
	      $msg  = 'Error. The image is too big. Bigger than 300 MB. The current size: ' . $file_size ;
          unlink($file);  # delete uploaded file 
          $this->flash($msg, '/admin/shares/listing', 3);
          return False;
      endif;
      
      $current_id  = $this->Share->field('id', 'id > 0', 'Share.id DESC');
      $next_id     = ($current_id + 1);
      $extension   = $this->__getExtension($file_name);
    
      if ( !in_array($extension, $this->_allowed) ):
          die(__('This does not look like one allowed file') .' '. $extension);
      endif;
    
      $Name = $this->Auth->user('username').'_'.$next_id.'.'.$extension;
	
      /** setup final file location and name */
      $final_filename = str_replace(" ", "_", $Name);  # change spaces to underscores in filename
      $newfile = $uploaddir.'/'.$final_filename;
    
      /** do extra security check to prevent malicious abuse */
      if (is_uploaded_file($file)):
          /** move file to proper directory ==*/
          if (!move_uploaded_file($file, $newfile)):
              /** if an error occurs the file could not be written, read or possibly does not exist ==*/
              exit('Error Uploading File.');
          endif;
      endif;
      # Database stuff  
      $this->request->data['Share']['file']     = (string) $final_filename;
      $this->request->data['Share']['secret']   = (string) $this->Adds->genPassword(15);
      $this->request->data['Share']['user_id']  = (int) $this->Auth->user('id');
      if ($this->Share->save($this->request->data)):
          $this->msgFlash(__('File saved'), '/admin/shares/listing');
      else:
	      #Save error messages from model in Session vars! 
	      $this->Session->write('CommentErrors', $this->Share->validationErrors);  
	      $this->Session->write('Values', $this->request->data);  
	      $this->redirect('/admin/shares/listing'); 
      endif;
  endif;
 }

/**
 *  Change file status published/draft
 *  @access public
 *  @param integer $share_id
 *  @param integer $status
 *  @return void 
 */
 public function admin_change($share_id, $status, $current_page = 1, $sort = 'id', $direction)
 {
   if ( $sort == 'id' ):
       $return = '/admin/shares/listing/page:'.$current_page;
   else:
       $return = '/admin/shares/listing/page:'.$current_page.'/sort:'.$sort.'/direction:'.$direction;
   endif;

   $new_status = ($status == 0 ) ? 1 : 0;    
   $this->Share->id = (int) $share_id;
   if ($this->Share->saveField('status', $new_status)):
       $this->msgFlash(__('Status modified'), $return);
   endif;
 }

/**
 *  Change file status public/non public
 *  @access public
 *  @param integer $share_id
 *  @param integer $share_id
 *  @return void 
 */
 public function admin_public($share_id, $public, $current_page = 1, $sort = 'id', $direction)
 {  
   if ( $sort == 'id' ):
       $return = '/admin/shares/listing/page:'.$current_page;
   else:
       $return = '/admin/shares/listing/page:'.$current_page.'/sort:'.$sort.'/direction:'.$direction;
   endif;

   $new_status = ($public == 0 ) ? 1 : 0;    
   $this->Share->id = (int) $share_id;
   if ($this->Share->saveField('public', $new_status)):
       $this->msgFlash(__('Data modified'), $return);
   endif;
 }

/**
 *  Remove file 
 *  @access public
 *  @param integer $share_id
 *  @return void 
 */
 public function admin_delete($share_id) 
 {   
   $file = '../webroot/files/userfiles/'.$this->Share->field('file', array('Share.id'=>$share_id));
   if ( unlink($file) ):
       if ( $this->Share->delete($share_id) ):
           $this->msgFlash(__('File deleted'), '/admin/shares/listing');
       endif;
   endif;
 }

/**
 *  Get extension
 *  @access private
 *  @param string $filename
 *  @return string
 */ 
 private function __getExtension($filename)
 {
   $parts = explode('.',$filename);
   $last  = count($parts) - 1;
   $ext   = $parts[$last];
   return strtolower($ext);
 }
}
# ? > EOF
