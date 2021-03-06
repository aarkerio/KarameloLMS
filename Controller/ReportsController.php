<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package vclassroom
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: /APP/Controller/ReportsController.php

/**
 * Load sanitize library
 */
App::uses('Sanitize', 'Utility');

class ReportsController extends AppController {

/**
 * Load helpers
 * @access public
 * @var array
 */
  public  $helpers = array('Paginator');

/**
 *  Cake components
 *  @var array
 *  @access public
 */ 
 public $components    = array('Mailer');

/**
 *  Pagination array
 *  @var array
 *  @access public
 */ 
 public $paginate = array('limit' => 40,'order' => array('Report.created' => 'asc'));


/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */  
 public function beforeFilter() 
 {
    parent::beforeFilter();

    if ( $this->Auth->user() ):
        $this->Auth->allow(array('display', 'show', 'add', 'points'));
    endif;
 }

/**
 * Save and store the report
 * @access public
 * @return void
 */
 public function add()
 {
   if ($this->request->data['Report']['file']['error'] == 1):
       if (Configure::read('debug') == 0):
           $this->flash(__('Error uploading file, please contact the support team. Push Back button.'), '/', 3);
       else:
           die('Something was wrong, maybe file is too big');
       endif;
   endif;

   if ( !empty($this->request->data['Report']) ):
       #die(debug($this->request->data));
       $uploaddir     = (string) '../webroot/files/studentsfiles';
       $maxfilesize   = 23783058;    # 30 MB max size
       $file_name     = $this->request->data['Report']['file']['name'];
       $file_size     = $this->request->data['Report']['file']['size'];
       $file          = $this->request->data['Report']['file']['tmp_name'];
       $type          = $this->request->data['Report']['file']['type'];
       $vclassroom_id = $this->request->data['Report']['vclassroom_id'];
       $activity_id   = $this->request->data['Report']['activity_id'];
       $url = (string) '/vclassrooms/show/'.$this->request->data['Report']['blogger_username'].'/'.$vclassroom_id; # return

       # Security: checks to see if file is an image, if not do not allow upload
       if ( $type == "application/x-php"):   # .php is not a valid file!!!   
           $msg = 'Error the file '. $file_name . ' is not valid. No se pueden agregar archivos .php, subelo como .txt';   # delete uploaded file 
           unlink($file);
           $this->flash($msg, '/admin/reports/listing/'.$vclassroom_id, 3);
           return False;
       endif;

       if ( $file_size > $maxfilesize):
           $msg  = 'Error. The image is too big. Bigger than 30 MB. The current size: ' . $file_size ;
           #  delete uploaded file 
           unlink($file);
           $this->flash($msg, $url, 3);
           return False;
       endif;
   
       $current_id  = (int) $this->Report->field('id', 'id > 0', 'Report.id DESC');
       $next_id     = ($current_id + 1);
       $extension   = $this->__getExtension($file_name);  
       $allowed     = array('pdf','docx','xlsx','pptx','doc','xls','ppt','xcf','sxw','odt','odc','ods','odp','abw','html','zip','rar','gz','png','jpg','gif','svg','mp3','ogg','flac','txt');
        
       if ( !in_array($extension, $allowed) ):
	       die(__('This does not look like one allowed file') . ' '. $extension);  # security check
       endif;
        
       $filename  = $this->Auth->user('username') . "_" . $next_id . '.'. $extension; 
       $newfile   = $uploaddir . '/' . $filename;
        
       /** do extra security check to prevent malicious abuse */
       if ( is_uploaded_file($file) ):
           /** move file to proper directory ==*/
           if (!move_uploaded_file($file, $newfile)):
	           /** if an error occurs the file could not be written, read or possibly does not exist ==*/        
               $this->flash('Error Uploading File', '/', 3);
               return False;
           endif;
       endif;
       # Database stuff starts 
       $this->request->data['Report']['filename']    = (string) $filename;
       $this->request->data['Report']['created']     = Null;
       $this->request->data['Report']['student_id']  = (int) $this->Auth->user('id');
       $this->request->data['Report']['points']      = (int) 0;
       
       #die( debug($this->request->data));
          
       if ($this->Report->save($this->request->data)):
           # Email STARTS
           $email    = (string) $this->Auth->user('email');
           $activity =  $this->Report->Activity->field('title', 'id='.$activity_id);
           $msg =  __('Teacher has received your file'). "\n<br />". __('Activity') .': ' . $activity ."\n<br />";
           $subject = (string) __('File submitted successfully');
           $this->Mailer->subject =  __('File submitted successfully');
           $this->Mailer->set('message',$msg);
           $this->Mailer->set('url', $url);
           $this->Mailer->template = 'default';
           $this->Mailer->sendAs   = 'html'; 
           $this->Mailer->send($email);  # email to student
           # Emails to teacher and tuthors
           $users = $this->Report->User->getTeachers($this->request->data['Report']['vclassroom_id']);
           $data  = array('subject'=>$subject, 'message'=>__('Student has sent a file').' '.$url);
           $this->Mailer->sendMany($data, $users);
           # Email ENDS
           $this->msgFlash(__('File saved'), $url);
       endif;
  endif;
 }

/*=== ADMIN  METHODS ===*/
/**
 *  List all teacher Catfaqs
 *  @access public
 *  @return void
 *  @param integer $vclassroom_id
 */
  public function admin_listing($vclassroom_id)
  {
   $this->layout = 'admin';
   $this->set('vclassroom_id', $vclassroom_id);
    
   $this->paginate['limit']      = 40;
   $this->paginate['fields']     = array('Report.id', 'Report.filename', 'Report.created', 'Report.points','Report.student_id','Report.description','Report.checked',  'Report.activity_id', 'Activity.title');
   $this->paginate['conditions'] = array('Report.vclassroom_id'=>$vclassroom_id);
   $this->paginate['contain']    =  array('User'=>array('fields'=>array('User.id', 'User.name', 'User.username', 'User.avatar')), 'Activity');
   $this->paginate['order']      = 'Report.created DESC';
   $data = $this->paginate('Report');
   $this->set(compact('data')); 
  }

/**
 * Update 
 * @access public
 * @return void
 * @param integer $report_id
 */
 public function admin_edit()
 {
   #die(debug($this->params['data']));
   $report_id = substr_replace( $this->params['data']['id'], '', 0, 7);
   #die(debug($report_id)); 
   $this->Report->id  = (int) $report_id;

   $description =  $this->params['data']['value'];
   
   if ($this->Report->saveField('description', $description)):
       $this->set('description', $description);
   endif;
 }

/**
 * Report evaluated
 * @access public
 * @return void
 * @param integer $report_id
 * @param string  $sense
 */
 public function admin_share($report_id)
 {
  $data = $this->Report->getData($report_id); # Model call
  #die(debug($data));
  $this->Report->id  = $report_id; 
    
   if ($this->Report->saveField('checked', 1)):
       # Email STARTS
       $email   = (string) $data['User']['email'];
       $subject = (string) $data['Vclassroom']['name'];
       $message = __('The teacher has called the file you sent'). ': '. $data['Report']['description']."\n";
       $this->Mailer->set('url', '/vclassrooms/show/'. $data['teacher_username'].'/'.$data['Report']['vclassroom_id']);
       $this->Mailer->set('message', $message);
       $this->Mailer->subject =  $subject;
       $this->Mailer->template = 'default';
       $this->Mailer->sendAs   = 'html'; 
       $this->Mailer->send($email);
       # Email ENDS    
       $this->msgFlash(__('Report graded'), $this->referer());
   endif;
 }

/**
 * Change points gained by student
 * @access public
 * @return void
 * @param integer $report_id
 * @param string  $sense
 */
 public function admin_points($report_id, $sense)
 {
   $this->disableCache();
   $points = (int) $this->Report->field('points', array('Report.id'=>$report_id));
   $points = ($sense == 'up' ) ? ($points + 1) : ($points - 1);

   $this->Report->id  = $report_id; 
    
   if ($this->Report->saveField('points', $points)):
       $this->set('points', $points);
	   $this->render('admin_points', 'ajax');
   endif;
 }

/**
 *  Teacher get student report
 *  @access public
 *  @return void
 *  @param integer $report_id
 */
 public function admin_download($report_id)
 {             
  $this->layout    = 'ajax';
  $conditions      = array('Report.id'=>$report_id);
  $filename        = $this->Report->field('filename', $conditions);
  $this->set('filename', 'files/studentsfiles/'.trim($filename));
 }

/**
 * Change points gained by student
 * @access public
 * @return void
 * @param integer $report_id
 */
 public function admin_show($participation_id) 
 {
   $this->layout = 'popup';
   $params = array('conditions' => array('Participation.id'=>$participation_id));
   $this->set('data', $this->Participation->find('first', $params));
 }

/**
 *  Remove file
 *  @access public
 *  @param integer $report_id
 *  @return void
 */
 public function admin_delete($report_id) 
 {   
    $params        = array('conditions'=>array('Report.id'=>$report_id), 'fields'=>array('Report.filename', 'Report.vclassroom_id'));
    $data          =  $this->Report->find('first', $params);
    $vclassroom_id = (int) $data['Report']['vclassroom_id']; 
    $prefile       = (string) trim($data['Report']['filename']); 
    $file          = (string) '../webroot/files/studentsfiles/'.$prefile;
    if ( unlink($file) ):
        if ( $this->Report->delete($report_id) ):
            $this->msgFlash(__('File deleted'),  $this->referer());
        endif;
    endif;
 }

 /**                                                                                                                           
  *  Remove all reports on virtual classroom     
  *  @access public      
  *  @param integer $vclassroom_id               
  *  @return void 
  */
 public function admin_unlink($vclassroom_id)
 {
     $params        = array('conditions'=>array('Report.vclassroom_id'=>$vclassroom_id), 'fields'=>array('Report.id', 'Report.filename', 'Report.vclassroom_id'));
     $data          =  $this->Report->find('all', $params);
     $dir          = (string) '../webroot/files/studentsfiles/';
     $i             = (int) 0; # iterator  
                                   foreach ($data as $r ):
     $prefile       = (string) trim($r['Report']['filename']);
     $file          = (string) $dir . $prefile;
     if ( unlink($file) ):
         if ( $this->Report->delete($r['Report']['id']) ):
             $i++;
     endif;
     endif;
     endforeach;
     $this->msgFlash($i . ' ' .__('Files deleted'),  $this->referer());
 }

/**
 * Change points gained by student
 * @access protected
 * @return void
 * @param string $filename
 */
 protected function __getExtension($filename)
 {
  $parts = explode('.',$filename);
  $last = count($parts) - 1;
  $ext = $parts[$last];
  return $ext;
 }
}

# ? > EOF
