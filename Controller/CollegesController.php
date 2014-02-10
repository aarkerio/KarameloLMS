<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package college
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file : app/Controller/CollegesController.php

/**
 *  Include libraries
 */
App::uses('Sanitize', 'Utility');

class CollegesController extends AppController {
 
/**
 *  CakePHP Helpers
 *  @var array
 *  @access public
 */
 public $helpers     = array('Ck', 'Time');

/**
 *  CakePHP Components
 *  @var array
 *  @access public
 */
 public $components  = array('Mailer');

/**
 *  Cake cache 
 *  @var array
 *  @access public
 */
 /* public $cacheAction = array(
                           'view/'    => 48000,
                           'admin_listing/' => 48000
                           ); */

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */  
 public function beforeFilter() 
 {
  parent::beforeFilter();
  $actions = array('index', 'terms', 'goya', 'firsttime', 'quickstart', 'getInfo', 'contact', 'fromoutside', 'calendar','twitter', 'parentsSchool');
  $this->Auth->allow($actions);
 }

/**
 *  Static page
 *  @access public
 *  @return void 
 */
 public function index()
 {
  $this->layout = 'portal';
  $this->set('data', $this->College->find('first', array('conditions'=>array('College.id'=>1))));
 }

/**
 *  Google college calendar
 *  @access public
 *  @return void
 */
 public function calendar() 
 {
   $this->layout = 'portal';
   $params = array(
                   'conditions'   => array('College.id'=>1),
                   'fields'       => array('College.name', 'College.gcalendar_id')
                  );
   $this->set('data', $this->College->find('first', $params));
 }

/**
 *  Just print
 *  @access public
 *  @return void
 */
 public function contact()
 {
  $this->layout    = 'portal';
 }

/**
 *  Just send anonymous cintatct message, see /messages/contact  view 
 *  Google college calendar
 *  @access public
 *  @return void
 */
 public function fromoutside()
 {
  if (!empty($this->request->data['College'])):
      #die(debug($this->request->data));
      $msg  = (string) $this->request->data['College']['title'] .' '.$this->request->data['College']['name'] ."\n";
      $msg .= $this->request->data['College']['body'] ."\n"; 
      $msg .= __('Email').': '.$this->request->data['College']['email']; 
      #die(debug($msg));      
      $email = $this->College->field('email', array('College.id' => 1));
      $this->Mailer->template = 'anonymous';
      $this->Mailer->subject  = __('Contact request');
      $this->Mailer->set('msg', $msg);
      if ( $this->Mailer->send($email) ):
          $this->render('sent', 'ajax'); 
      endif;
  endif;
 }

/**
 *  Quick start - quick explanation about this portal and how use it
 *  @access public
 *  @return void
 */
 public function quickstart() 
 { 
  $this->layout = 'portal';
 }

/**
 *  Used in blogs 
 *  @access public
 *  @return mixed array or null
 */
 public function getInfo() 
 {
  $this->layout = 'portal';
  $params = array(
                   'conditions' => array('College.id'=>1),
                   'fields'     => array('College.name', 'College.logo')
                 );
  return $this->College->find('first', $params);
 }
 
/**
 *  Display college data
 *  @access public
 *  @return void
 */
 public function twitter() 
 {
  return $this->College->field('College.twitter', array('College.id'=>1));
 }

/**
 *  Display Parents school banner in Front End
 *  @access public
 *  @return void
 */
 public function parentsSchool() 
 {
  return $this->College->field('College.sp', array('College.id'=>1));
 }
/**
 *  Display terms in contract
 *  @access public
 *  @return void
 */
 public function terms()
 {
   $this->layout = 'popup';
 }

/**
 *  Estearn egg
 *  @access public
 *  @return void
 */
 public function goya()
 {
   $this->title     = 'Eastern::egg Pumas';
   return True;
 }

/*** ======ADMIN METHODS === *****/

/**
 *  Listing
 *  @access public
 *  @return void
 */
 public function admin_listing() 
 {
  $this->layout = 'admin';
  $params = array('conditions'  => array('id'=>1),
                  'fields'      => array('id', 'name', 'email', 'description', 'keywords', 'logo', 'sp', 'gcalendar_id', 'twitter'),
                  'order'       => 'College.id DESC'
  );
  $data            = $this->College->find('first', $params);
  $this->set('data', $data); 
 }
 
/**
 *  Listing
 *  @access public
 *  @return void
 */
 public function admin_edit()
 {
  $this->layout    = 'admin';
  $this->College->bindModel(array('belongsTo'=>array('User')));
  $sp = Set::combine($this->College->User->find('all',array('conditions'=>array('User.group_id < 3'),'order'=>'username')),"{n}.User.username","{n}.User.name");
  array_push($sp, __('No blog for parents')); 
  $sp = array_reverse($sp);
  $this->set('sp',$sp);
  if ( empty( $this->request->data['College'] ) ):
      $this->request->data = $this->College->read(Null, 1);
  else:
      if ($this->College->save($this->request->data)):
          if ( $this->request->data['College']['end'] == 1 ):
              $this->msgFlash(__('Data saved'),'/admin/colleges/listing');
          else:
              $this->msgFlash(__('Data saved'), '/admin/colleges/edit/');
          endif;
      endif;
  endif;
 }

/**
 *  Listing  Reports to PDF 
 *  @access public
 *  @return void
 */
 public function admin_reports() 
 {
  $this->layout = 'admin';
  $params = array('conditions' => array('College.id'=>1),
                  'fields'     => array('College.id', 'College.name', 'College.email'),
                  'order'      => 'College.id DESC'
                 );
  $data = $this->College->find('first', $params);
  $this->set('data', $data); 
 }

/**
 *  Display users tryed logged in
 *  @access public
 *  @return void
 */
 public function admin_record()
 {
  $this->layout = (string) 'admin';
  $this->view   = (string) 'Media';
  $path         = (string) APP . 'tmp'.DS.'logs'.DS;
  $file         = (string) 'logged.log';
  $destination  = (string) 'logged.zip';
  $pf           = (string) $path. $file;
  $pd           = (string) $path. $destination;
  if ( file_exists($pf) ):
      $zip = new ZipArchive;
      if ( $zip->open($pd, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== True ):
          die("Could not open archive"); 
      endif;
      $zip->addFile($pf, 'log_'.time().'.txt') or die ("ERROR: Could not add file: $file");
      #close the zip -- done! 
      $zip->close();
  endif; 
  $params = array(
                  'id'        => $destination,
                  'name'      => 'logged',
                  'download'  => True,
                  'extension' => 'zip',
                  'path'      => $path
                  );
  #die(debug($params));
  $this->set($params);
 }

/**
 *  Change college logo 
 *  @access public
 *  @return void
 */
 public function admin_logo()
 {
  #die(debug($this->request->data['College']));
  # return link
  $return =  '/admin/colleges/edit/1';   

  if ( !is_uploaded_file($this->request->data['College']['file']['tmp_name']) || $this->request->data['College']['file']['error'] == 1 ):
      $this->flash(__('Error uploading image'), $return);
      return False;
  endif;
  
  #die($return);
  /** SUBMITTED INFORMATION - use what you need
    *  temporary filename (pointer): $imgfile
    *  original filename           : $imgfile_name
    *  size of uploaded file       : $imgfile_size
    *  mime-type of uploaded file  : $imgfile_type
  */
    
    /** uploaddir:  directory relative to where script is running */
    $uploaddir    = '../webroot/img/static'; 
    $maxfilesize  = 1017152; /** 1MB max size */
    $imgfile_name = $this->request->data['College']['file']['name'];
    $imgfile_size = $this->request->data['College']['file']['size'];
    $imgfile      = $this->request->data['College']['file']['tmp_name'];
    $type         = $this->request->data['College']['file']['type'];

    list($width, $height, $typeimg, $attr) = getimagesize($imgfile);

    /** Security: checks to see if file is an image, if not do not allow upload ==*/
    
    if ( $type != 'image/jpeg' && $type != 'image/pjpeg' && $type != 'image/png' && $type != 'image/gif'): 
        /** is this a valid file? */
        $msg   = "ERROR the file $imgfile_name $imgfile is not valid. Only .jpg, .gif or .png files<br >Current type file: ".$type;
        /** delete uploaded file  */
        unlink($imgfile);
        $this->flash($msg, $return);
        return false;
    endif;
    
    if ( $imgfile_size > $maxfilesize):
         $msg  = "Error. The image is too big. Bigger than 1.0 MB  Current size: " . $imgfile_size;
         /** delete uploaded file */
         unlink($imgfile);
         $this->flash($msg, $return);
         return False;
    endif;
  
    #check size
    if ($width > 150 || $height > 150): 
      $error  = 'Error '. __('The image is too large', true);
      $error .= "Width or height is larger than 150 pixels. Current size: width ". $width ."px  height ". $height ."px\n";   
      /** delete uploaded file */
      unlink($imgfile);
      $this->flash($error,  $return);
      return False;
    endif;
  
    /** change spaces to underscores in filename  */
    $final_filename  = str_replace(' ', '_', $imgfile_name);
    #die($final_filename);
    $newfile = $uploaddir . '/' . $final_filename;
    
    if ( file_exists($newfile) && $this->request->data['College']['overwrite'] == 0):
        $msg = __('There is already a file with this name, please push Back button', true);
        $this->flash($msg, $return);
        return False;
    endif;
    /** do extra security check to prevent malicious abuse */
    if (is_uploaded_file($imgfile)):
       /** move file to proper directory ==*/
        if (!move_uploaded_file($imgfile, $newfile)):
            die($this->flash(__('Error Uploading File', true),  $return));
       endif;
    endif;
   
  /** delete the temporary uploaded file **/
  unset($this->request->data['College']['file']); // We do'nt need this anymore 
 
 /** Database stuff  **/
  $this->College->id = $this->request->data['College']['id'];
  if ($this->College->saveField('logo',  $final_filename)):
      $msg = __('Data updated');
  else:
      $msg = __('Data NOT updated');
  endif; 
  $this->msgFlash(__('Data update'),  $return);
 }
}

# ? > EOF
