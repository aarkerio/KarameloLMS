<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package images
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : APP/Controller/ImagesController.php

App::uses('Sanitize', 'Utility');

class ImagesController extends AppController
{

/**
 * CakePHP Components
 * @access public
 * @var array
 */
 public $components    = array('Adds');

/**
 * Images
 * @access public
 * @var array
 */
 public $uploadDir     = '../webroot/img/imgusers/';

/**
 * Thumbs dir
 * @access public
 * @var string
 */
 public $thumbsDir     = '../webroot/img/imgusers/thumbs/';

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */  
 public function beforeFilter()
 {
    parent::beforeFilter();
 }
    
 /***  === ADMIN METHODS  ***/
/**
 *  Change status published/draft 
 *  @access public
 *  @return void
 */
 public function admin_listing($set = Null, $ck = Null)
 {  
  if ($set != Null):
      $this->layout    = 'popup'; # small window
      $limit = 10;
      $this->set('set', True);   

      if (isset($ck)):
	      $this->set('ck');
      endif; 
  else:
      $this->layout    = 'admin';
      $limit = 30;
      $this->set('set', Null);
  endif;
  
  $this->paginate = array('conditions'  => array('Image.user_id'=>$this->Auth->user('id')),
                          'order'       => 'Image.id DESC',
                          'fields'      => array('Image.id', 'Image.file', 'Image.user_id'),
                          'limit'       => $limit
                        );
  $data = $this->paginate('Image');
  foreach($data as $v):
      $this->Adds->resizeImage($v['Image']['file'], $this->uploadDir, $this->thumbsDir, 100, True);
  endforeach;
  $this->set(compact('data'));

  if ($this->Session->check('CommentErrors')): 
      # Get session vars from admin_add()
 	  $this->Image->validationErrors = $this->Session->read('CommentErrors');
	  $this->request->data= $this->Session->read('Values'); 
	  # Delete session vars
 	  $this->Session->delete('CommentErrors'); 
	  $this->Session->delete('Values'); 
	  $this->set('show'); 
  endif;  
 }
 
/**
 *  Add image
 *  @access public
 *  @return void
 */
 public function admin_add($set = null) 
 {  
  # die(debug($this->request->data));
  #If the request is from ckeditor
  if (isset($this->request->data['Image']['ckeditor'])):
	  $return = $this->request->data['Image']['return'].'/ck?CKEditorFuncNum=2&langCode='.$this->Auth->user('lang');
  else:
      $return = $this->request->data['Image']['return'];
  endif;
  
  if ($this->request->data['Image']['file']['error'] != 0):
      $this->flash(__('Error uploading image'), $return); 
      return False;
  endif;

  $this->layout    = 'admin';
       
  /** SUBMITTED INFORMATION - use what you need
    *  temporary filename (pointer): $imgfile
    *  original filename           : $imgfile_name
    *  size of uploaded file       : $imgfile_size
    *  mime-type of uploaded file  : $imgfile_type
   */ 
  /** uploaddir:  directory relative to where script is running */
    $maxfilesize  = 2097152; /** 2MB max size */
    $imgfile_name = $this->request->data['Image']['file']['name'];
    $imgfile_size = $this->request->data['Image']['file']['size'];
    $imgfile      = $this->request->data['Image']['file']['tmp_name'];
    $type         = $this->request->data['Image']['file']['type'];
    /** Security: checks to see if file is an image, if not do not allow upload ==*/
    $types = array('image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/gif');

    if (empty($type)):
	    $error  = 'Image file needed'."\n";
	    $this->flash($error,$return);
        return False;	
    endif;
	
    # Check the file is in fact an image
    if ( !in_array($type, $types) ): 
        $error  = "Error. The file $imgfile_name is not valid. Only .jpg, .gif or .png files. Current type file: ".$type ."\n";
        #delete uploaded file
        unlink($imgfile);
        $this->flash($error,$return);
        return False;
    endif;
    
    if ( $imgfile_size > $maxfilesize):
        $error  = 'Error. '.__('Image is bigger than 2.0 MB. Current size',True). ' '  . $imgfile_size;
        # delete uploaded file
        unlink($imgfile);
        $this->flash($error,$return);
        return False;
    endif;
    # Get max ID in model to build image name  
    $current_id  = (int) $this->Image->field('id', 'id > 0', 'id DESC');
  
    $next_id     = ($current_id + 1);
    
    $extension   = $this->Adds->last3chars($imgfile_name);
    #build new image name
    $name        = strtolower($this->Auth->user('username') . '_' . $next_id . '.' .$extension);
    
    /** setup final file location and name */
    /** change spaces to underscores in filename  */
    $final_filename = str_replace(' ', '_', $name);
    
    $newfile        = $this->uploadDir . $final_filename;
    
   # do extra security check to prevent malicious abuse 
   if (is_uploaded_file($imgfile)):
       /** move file to proper directory ==*/
       if ( !move_uploaded_file($imgfile, $newfile) ):
           /** if an error occurs the file could not be written, read or possibly does not exist ==*/
           $this->flash('Error. '. __('Uploading File'), $return);
       endif;
    endif;
	
   # made thumb
   $this->Adds->resizeImage($final_filename, $this->uploadDir, $this->thumbsDir, 100, True);
   	
   # Database stuff  
   $this->request->data['Image']['file']    = (string) $final_filename;
   $this->request->data['Image']['user_id'] = (int) $this->Auth->user('id');

   if ($this->Image->save($this->request->data)): 
       $this->msgFlash(__('Data saved'), $return);
   else:
	   $this->Session->write('CommentErrors', $this->Image->validationErrors); 
	   $this->Session->write('Values', $this->request->data); 
	   $this->redirect($return); 
   endif;
}

/**
 *  Delete Image from DB and HD
 *  @access public
 *  @return void
 */
 public function admin_delete()
 {
    if (isset($this->request->data['Image']['ckeditor'])):
	    $return = $this->request->data['Image']['return'].'/ck?CKEditorFuncNum=2&langCode='.$this->Auth->user('lang');
    else:
	    $return = $this->request->data['Image']['return'];
    endif;
	
    $file = $this->Image->field('Image.file', array('Image.id'=>$this->request->data['Image']['id']));
    if ( !$file ):
        $this->msgFlash(__('Data removed'), $return);
    endif;
    $this->Image->delete($this->request->data['Image']['id']);
    # delete image and thumb from hard disk
    if ( file_exists($this->uploadDir . $file) ):
        unlink( $this->uploadDir . $file );
    endif;
    if ( file_exists($this->thumbsDir . $file) ):
        unlink($this->thumbsDir . $file);
    endif;
    $this->msgFlash(__('Data removed'), $return);
 }
} 
# ? > EOF
