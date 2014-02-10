<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2014, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package users
*  @license http://www.gnu.org/licenses/agpl.html
*/
# File: app/Controller/UsersController.php

/**
 *  Include files
 */
App::uses('Sanitize', 'Utility');

class UsersController extends AppController {

/**
 *  Cake Helpers
 *  @var array
 *  @access public
 */   
 public $helpers        = array('Ck');

/**
 *  Paginate array
 *  @var array
 *  @access public
 */
 public $components     = array('Edublog', 'Mailer', 'Adds');

/**
 *  Paginate array
 *  @var array
 *  @access public
 */   
 public $paginate       = array('limit' => 5, 'order' => array('Page.created' => 'DESC'));

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */   
 public function beforeFilter() 
 {
  parent::beforeFilter();
  # die(debug($this->request->data));
  # check password field
  if ( isset($this->request->data['Profile']['userform']) ):
      if (strlen($this->request->data['User']['pwd']) > 1 && strlen($this->request->data['User']['pwd']) < 6): # passwd too short, so unset
          unset($this->request->data['User']['pwd']);
          $this->Session->setFlash(__('Password too short'));
      elseif(strlen($this->request->data['User']['pwd']) == 0): # just no pwd so unset
          unset($this->request->data['User']['pwd']);
          unset($this->request->data['User']['email']);
          #die(debug($this->request->data));
      endif;
  endif;
  #die(debug($this->request->data));
  $actions = array('blog','entry','last','portfolio','about','register','openid','directory','bloggers', 'logout');
  
  if ( $this->Auth->user()  ): # students can change avatar
      array_push($actions, 'avatar', 'edit');
  endif;
  
  $this->Auth->allow($actions); 
 }

/**
 *  Blogger portfolio
 *  @access public
 *  @return void
 */
 public function portfolio($username) 
 {
  $this->Edublog->setUserId($username); # blogger elements
  $params = array('conditions' => array('User.id'=> $this->Edublog->userId));
  $this->set('data', $this->User->find('first', $params));  
 }
     
/**
 *  About user
 *  @access public
 *  @return void
 */
 public function about($username) 
 {
  $this->layout    = 'portal';   
  $params = array('conditions' => array('User.username'=>trim($username)), 
                  'contain'    => array('Profile'));
  $data   = $this->User->find('first', $params);
  #die(debug($data));
  if ( (isset($this->params['requested']))):
      return $data; #blogger element 
  endif;   
  $this->set('data',$data);
 }
 
/**
 *  Display teachers and admins
 *  @access public
 *  @return void
 */
 public function directory($filter = Null)
 {
  $this->layout    = 'portal';
  # list teachers
  switch ($filter):
        case 1:
               $conditions['group_id'] = 2;
               break;
  endswitch;
  $params = array(
                  'conditions' => array('User.active'=>1, 'User.id !=' => 2, 'User.group_id <'=>3),
                  'fields'     => array('User.id','User.name','User.username','Profile.created','User.group_id','User.email',
                                    'Profile.name_blog','User.last_visit'),
                  'order'      => 'User.name',
                  'limit'      => 50
                 );
  #die(debug( $this->User->find('all', $params)));
  $this->set('users', $this->User->find('all', $params));
 }
 
/**
 *  Bloggers lis
 *  @access public
 *  @return void
 */
 public function bloggers()
 { 
  $this->layout = 'portal';
  $params = array(
                   'conditions'   =>  array('User.group_id <'=>3,  'User.active' =>  1), # only admin and teachers are bloggers
                   'fields'       =>  array('User.id', 'User.username', 'User.name', 'Profile.name_blog', 'User.avatar', 'Profile.quote'),
                   'order'        =>  'User.username',
                   'limit'        => 30
                 );
  $this->set('data', $this->User->find('all', $params));
 }

/**
 *  Login screen
 *  @access public
 *  @return void
 */
 public function login()
 {
   if ($this->request->is('post')):
       if ( $this->Auth->login() ):
	       if (!empty($this->request->data)):
               if (empty($this->request->data['User']['remember_me'])):
                    $this->Cookie->delete('User');
               else:
                    $cookie = array();        
                    $cookie['email'] = $this->request->data['User']['email'];
                    $cookie['token'] = $this->request->data['User']['pwd'];
                    $this->Cookie->write('Auth.User', $cookie, True, '+2 weeks');
               endif;
               unset($this->request->data['User']['remember_me']);
               # We use next line to allow only one session per user
               $date = (string) date('Y-m-d H:i:s');
               #die(debug($this->Auth->user('id')));
               $this->User->id = (int) $this->Auth->user('id');
               $this->User->saveField('current_visit', $date);
               $this->Session->write('Auth.User.current_visit', $date);
           endif;
       endif;
       $this->Session->setFlash('Welcome!');
       $this->redirect($this->Auth->redirect());
   else:
       $this->layout    = 'portal';
   endif; 
 }
 
/**
 *  Out!
 *  @access public
 *  @return void
 */
 public function logout() 
 {
   $this->Cookie->delete('User');
   $this->Session->destroy();
   $this->Session->setFlash('Logout');
   $this->redirect($this->Auth->logout());
 }
 
/**
 *  Register new user
 *  @access public
 *  @return void
 */
 public function register()
 {
  $this->set('groups', Set::combine($this->User->Group->find('all'), "{n}.Group.id","{n}.Group.name"));
  $this->layout    = 'portal';
  if (isset($this->request->data['User'])):
     $this->request->data['User']['username'] = Sanitize::paranoid($this->request->data['User']['username']);
     $this->request->data['User']['name']     = Sanitize::paranoid($this->request->data['User']['name'],  $this->para_allowed);
     $this->request->data['User']['email']    = Sanitize::paranoid($this->request->data['User']['email'], $this->para_allowed);
     # try to add new user to database
     $this->request->data['User']['active']     = (int) 0; # not active until confirm email 
     $this->request->data['User']['name_blog']  = $this->request->data['User']['username'].'\'s corner'; 
     #die(debug($this->request->data));
     # get the secret code for teachers registration process
     $code  = $this->User->Group->field('code', array('id'=>$this->request->data['User']['group_id']));
     #die($code);
     if ( $this->request->data['User']['code'] != $code ):
         $msg = __('The code is incorrect, please push back button, to know the code put in contact with your school admin services');
         $this->flash($msg, '/users/register');
         return False;
     endif;
     if ($this->User->save($this->request->data)):
         $newAro = array(
                         'alias'       => $this->request->data['User']['username'],
                         'model'       => 'User',
                         'foreign_key' => $this->User->id,
                         'parent_id'   => $this->request->data['User']['group_id']
                       );
        $this->Acl->Aro->save($newAro);
        #create profile
        $this->request->data['Profile']['user_id']  =  $this->User->id;   # the user id
        $this->User->Profile->save($this->request->data);
        # Send confirmation email
        $this->request->data['Confirm']['user_id']  = $this->User->id;   # the user id
        $this->request->data['Confirm']['secret']   = $this->Adds->genPassword(14);     # secret confirm ID
        # put the user in confirm model, this is, waiting for user confirmation trough email
        #die(debug($this->request->data));
	    if ($this->User->Confirm->save($this->request->data)):
              # Send the confirmation email
              $this->Mailer->template = 'confirmation'; # note no '.ctp'
              $this->Mailer->subject  =  __('Karamelo:: Confirm account');
              $this->Mailer->set('message',$this->request->data['Confirm']['secret']);
              if ( $this->Mailer->send($this->request->data['User']['email']) ):
                  $msg  = __('You have been registered') . '! ';
                  $msg .= __('A confirmation email has been sent to') .': '.$this->request->data['User']['email'] .' ';
	              $msg .= __('In order to complete the registration process, please click on the link contained on the email',True);
                  $this->flash($msg, '/', 5);
                 return True;
	          endif;
	    endif;
     endif;
  endif;
 }

/**
 *  Edit
 *  @access public
 *  @return void
 */
 public function edit() 
 {
  $this->layout    = 'portal';
  if ( !$this->Auth->user() ):
      $this->redirect('/');
      return False;
  endif;
  
  if ( $this->Auth->user('group_id') != 3 && $this->Auth->user('group_id') != 4 ):
      $this->redirect('/users/edit');
      return True;
  endif;
  
  unset($this->request->data['User']['email']);   # this field was necessary by pwd hasshing, but now unset
  
  if ( !empty($this->request->data['User']) ):
      $this->User->data = Sanitize::clean($this->request->data);
      if ($this->User->save($this->request->data)):
          $this->User->bindModel(array('hasOne'=>array('Profile')));
          $this->User->Profile->save($this->request->data);
          $this->msgFlash(__('Profile updated'), '/users/edit/');
      endif;
  endif;
  $this->User->bindModel(array('hasOne'=>array('Profile')));
  $this->User->contain('Profile');
  $this->request->data = $this->User->read(Null,$this->Auth->user('id'));
 }

/**
 *  Upload avatar
 *  @access public
 *  @return void
 */
 public function avatar() 
 {
  $this->layout    = 'ajax';
  # die(debug($this->request)); 
  if ( !is_uploaded_file($this->request->data['User']['file']['tmp_name']) || $this->request->data['User']['file']['error'] == 1 ):
      $this->flash(__('Error uploading image'), '/admin/users/edit');
      return False;
  endif;

  $return =  $this->Auth->user('group_id') < 3  ?  '/admin/users/edit/' : '/users/edit/';  
  #die($return);
  /** SUBMITTED INFORMATION - use what you need
    *  temporary filename (pointer): $imgfile
    *  original filename           : $imgfile_name
    *  size of uploaded file       : $imgfile_size
    *  mime-type of uploaded file  : $imgfile_type
  */
    
    /** uploaddir:  directory relative to where script is running */
    $uploaddir    = '../webroot/img/avatars/'; 
    $maxfilesize  = 2097152; /** 2MB max size */
    $imgfile_name = $this->request->data['User']['file']['name'];
    $imgfile_size = $this->request->data['User']['file']['size'];
    $imgfile      = $this->request->data['User']['file']['tmp_name'];
    $type         = $this->request->data['User']['file']['type'];

    list($width, $height, $typeimg, $attr) = getimagesize($imgfile);

    /** Security: checks to see if file is an image, if not do not allow upload ==*/
    if ( $type != 'image/jpeg' && $type != 'image/pjpeg' && $type != 'image/png' && $type != 'image/gif'):
        /** is this a valid file? */
        $msg   = 'ERROR the file $imgfile_name $imgfile is not valid. Only .jpg, .gif or .png files<br >Current type file: '.$type;
        /** delete uploaded file  */
        unlink($imgfile);
        $this->flash($msg, $return);
        return False;
    endif;
    
    if ( $imgfile_size > $maxfilesize):
        $msg  = 'Error.'. __('The image is too big. Bigger than 2.0 MB. Current size:').' ' . $imgfile_size ."\n";
        #delete uploaded file
        unlink($imgfile);
        $this->flash($msg, $return);
        return False;
    endif;
  
    $extension   = $this->Adds->get_extension($type);
    $name        = $this->Auth->user('username') . '_avatar' . $extension;
	
    /** setup final file location and name */
    #change spaces to underscores in filename 
    $final_filename = str_replace(' ', '_', $name);
    #die($final_filename);
    $newfile = $uploaddir . $final_filename;
    
    # Do extra security check to prevent malicious abuse 
    if (is_uploaded_file($imgfile)):
        # move file to proper directory 
        if (!move_uploaded_file($imgfile, $newfile)):
            die($this->flash(__('Error Uploading File'),  $return));
        else:
            # resize if bigger thab 50px
            if ( $width > 50 ):
                $this->Adds->resizeImage($final_filename,  $uploaddir ,  $uploaddir, 50, False);
            endif;
        endif;
    endif;
   
  /** delete the temporary uploaded file **/
  unset($this->request->data['User']['file']); # We do not need this anymore 
 
 /** Database stuff  **/
  $this->User->id = $this->Auth->user('id');
  if ($this->User->saveField('avatar',  $final_filename)):
      $this->msgFlash(__('Data update'),  $return);
  endif; 
 }  
/***    ===== ADMIN METHODS====   ****/
/**
 *  Login screen (little hack)
 *  @access public
 *  @return void
 */
 public function admin_login() 
 {
  $this->redirect('/users/login'); 
 }

/**
 *  Just a hack, use another method 'cause DRY!
 *  @access public
 *  @return void
 */
 public function admin_avatar() 
 {
   $this->avatar(); 
 }

/**
 *  Search user
 *  @access public
 *  @return void
 */
 public function admin_search() 
 {
  $this->layout = 'admin';
  if ( !empty($this->request->data['User']['words']) ):
      $data = $this->User->search($this->request->data['User']['words'],  $this->Auth->user('lang'));
      #die(debug($data));
      $this->set('words', $this->request->data['User']['words']);
      $this->set('data', $data);
  endif;
 }
 
/**
 *  "Stealth" account to become another user
 *  @access public
 *  @param integer
 *  @return void
 */
 public function admin_activities($user_id) 
 {
   $group_id = (int) $this->User->field('group_id', array('id'=>$this->Auth->user('id')));
   if ( $group_id == 1 ):
       $params = array(
                       'conditions' => array('User.id'=>$user_id),
                       'contain'    => False
                       );
       $data = $this->User->find('first', $params);
       #die(debug($data));
       $this->Session->write('Auth.User.lang', $data['User']['lang']);
       $this->Session->write('Auth.User.id', $data['User']['id']);
       $this->Session->write('Auth.User.username', $data['User']['username']);
       $this->Session->write('Auth.User.name', $data['User']['name']);
       $this->Session->write('Auth.User.pwd', $data['User']['pwd']);
       $this->Session->write('Auth.User.email', $data['User']['email']);
       $this->Session->write('Auth.User.helps', $data['User']['helps']);
       $this->Session->write('Auth.User.avatar', $data['User']['avatar']);
       $this->Session->write('Auth.User.group_id', $data['User']['group_id']);
       $this->Session->write('Auth.User.current_visit', $data['User']['current_visit']);
       $this->Session->write('Auth.User.last_visit', $data['User']['last_visit']);
       #$this->msgFlash(__('Account stealthed'), '/admin/entries/start/');
       $this->flash(__('Account taken'), '/', 3);
   else:
       $this->msgFlash(__('Something were wrong'), '/admin/users/edit/');
   endif;
 }

/**
 *  Edit user
 *  @access public
 *  @return void
 */
 public function admin_edit() 
 {
  $this->layout    = 'admin';
  if ( empty($this->request->data['User']) ):      
      $this->set('Groups', Set::combine($this->User->Group->find('all', array('order' => 'name')), "{n}.Group.id","{n}.Group.name"));
      $this->User->bindModel(array('hasOne'=>array('Profile')));
      $this->User->contain('Profile');
      $this->request->data = $this->User->read(Null, $this->Auth->user('id'));
  else:
      unset($this->request->data['User']['email']);   # this field was necessary by pwd hasshing, but now unset
      #die( debug($this->request->data) );
      if ( $this->User->saveAll($this->request->data) ):
          if ( isset($this->request->data['User']['lang']) && $this->request->data['User']['lang'] != $this->Auth->user('lang')):
              $this->Session->write('Auth.User.lang', $this->request->data['User']['lang']);
          endif;
          $this->msgFlash(__('Data saved'), '/admin/users/edit/');
      else:
          throw new NotFoundException('Could not find that lesson');
      endif;
  endif;
 }

/**
 *  Add new user
 *  @param mixed 
 *  @return void
 *  @param integer $user_id
 */
 public function admin_add($user_id = Null) 
 {
  $this->layout    = 'admin';
  $this->set('groups', Set::combine($this->User->Group->find('all', array('order' => 'name')), "{n}.Group.id","{n}.Group.name"));
  if ( !empty($this->request->data['User']) ):
       $this->request->data['User']['layout']    = (string) 'mexico';
       $this->request->data['User']['email']     = trim($this->request->data['User']['email']); # just in case a sloppy copy/paste
       $this->request->data['User']['username']  = trim($this->request->data['User']['username']); # just in case a sloppy copy/paste
       #die( debug($this->request->data) );
       if ($this->User->save($this->request->data)):
           #create profile
           $this->request->data['Profile']['user_id'] = $this->User->id;   # the user id
           $this->User->Profile->save($this->request->data);
           $this->msgFlash(__('Data saved'), '/admin/users/listing');
           #else: die(debug($this->User->validationErrors));
       endif;
  elseif($user_id != Null && intval($user_id)):
        $this->User->contain('Profile');
        $this->request->data = $this->User->read(array('User.id', 'User.username', 'User.name', 'User.group_id', 'User.active', 'User.email', 'User.lang', 'Profile.id', 'Profile.matricula'), $user_id);
  endif;
 }

/**
 *  Display current users
 *  @access public
 *  @param string $active
 *  @return void
 */
 public function admin_listing($active=Null) 
 {
  if ( !$active ):
      $conditions = array('User.id != 2', 'User.active'=>'1');
  else:
      $conditions = array('User.id != 2');
  endif;

  $this->layout     = 'admin';
  $this->paginate['conditions'] = $conditions;
  $this->paginate['fields']     = array('User.group_id','User.name','Profile.created','User.email','User.active','User.id','User.username','Group.name');
  $this->paginate['order']      = 'User.name';
  $this->paginate['limit']      = 50;
  $this->paginate['contain']    = array('Profile', 'Group');
  $data = $this->paginate('User');
  #die(debug($data));
  $this->set(compact('data'));
 }

/**
 *  Personal teacher backup
 *  (ToDO) search trough several tables this is more complex than general site backup
 *  @access public 
 *  @return void
 */
 public function admin_start() 
 {
   $this->autoRender = False;
   #TODO => $this->User->getRecord($this->Auth->user('id'));
 }

/**
 *  General site backup
 *  @access public
 *  @return boolean
 */
 public function admin_backup() 
 {
   $this->autoRender = False;
   #Configure::write('debug', 0);
   $db =& ConnectionManager::getDataSource('default');
   #die(debug($db->config));

   $DB_NAME = $db->config['database'];
   $DB_USER = $db->config['login'];
   $DB_PWD  = $db->config['password'];
   $output_file = sprintf($DB_NAME."_%s.sql", date("Ymd-hi"));
   $DB_EXPORT_PATH ='/tmp';

   if ( $db->config['driver'] == 'mysql' ):
       $command = (string) "mysqldump --lock-tables --user ".$DB_USER." -p". $DB_PWD."  ".$DB_NAME. " > ".$DB_EXPORT_PATH.'/'.$output_file; 
   else:
       $command = (string) "pg_dump ".$DB_NAME." -O -U ".$DB_USER." -f ".$DB_EXPORT_PATH.'/'.$output_file; 
   endif;

   #die($command);
   exec($command);
   $karamelo_path = getcwd();
   #$cwd = exec('pwd');
   $tar_file = sprintf('KARAMELO_'."_%s.tar", date("Ymd-hi"));
   $command = (string) 'tar -rvf '. $DB_EXPORT_PATH .'/'. $tar_file .' '.$karamelo_path;
   exec($command);
    
   $command = (string) 'tar -rvf '. $DB_EXPORT_PATH .'/'. $tar_file . ' '. $DB_EXPORT_PATH.'/'.$output_file;
   exec($command);
   $tgz_file = $tar_file.'.gz';
   $command = (string) 'tar -czvf '.$DB_EXPORT_PATH .'/'.$tgz_file.' '.$DB_EXPORT_PATH.'/'.$tar_file; 
   #die($command);
   exec($command);

   if (file_exists($DB_EXPORT_PATH.'/'.$output_file)):
       unlink($DB_EXPORT_PATH.'/'.$output_file);
   endif;
   if (file_exists($DB_EXPORT_PATH.'/'.$tar_file)):
       unlink($DB_EXPORT_PATH.'/'.$tar_file);
   endif;
   #die($tgz_file);
   header('Content-type: application/x-compressed');
   header("Content-disposition: attachment; filename=".$tgz_file);
   header("Content-type: force-download; name=".$tgz_file);
   header("Content-Transfer-Encoding: binary");
   header("Cache-Control: no-cache, must-revalidate");
   header("Pragma: no-cache");
   
   readfile($DB_EXPORT_PATH .'/'.$tgz_file);

   return True;
 }
 
/**
 *  Change user status actived/no actived
 *  @access public
 *  @param integer $user_id
 *  @param integer $status
 *  @return void
 */
 public function admin_change($user_id, $status)
 {
   $active = ($status == 0 ) ? 1 : 0;
   $this->User->id    = (int) $user_id;
     
   if ($this->User->saveField('active', $active)):
       $this->msgFlash(__('Status modified'), '/admin/users/listing/');
   endif;
 }

/**
 *  Insert many users from text file
 *  @access public
 *  @return void
 */
 public function admin_record() 
 {
   $this->layout = 'admin';
   #die(debug($this->request->data));
   if (isset($this->request->data['User']) && $this->request->data['User']['file']['error'] == 0):
       $counter  = (int) 0;
       $inserted = (int) 0;
       $file     = fopen($this->request->data['User']['file']['tmp_name'], 'r'); # load file
       while ( $line = fgets($file, 1000) ):
           if ( strlen($line) > 10): # too short
               $counter++;
               #echo $line;
               $user = explode(",", $line);
               if ( count($user) == 7): # not too much not too few
                   #die(debug($user));
                   $this->request->data['User']['username']  = trim($user[0]);
                   $this->request->data['User']['email']     = trim($user[1]);
                   $this->request->data['User']['group_id']  = trim($user[2]);
                   $this->request->data['User']['name']      = trim($user[3]);
                   $this->request->data['User']['pwd']       = $this->Auth->password(trim($user[4]));
                   $this->request->data['User']['lang']      = trim($user[5]);
                   $this->request->data['User']['actived']   = trim($user[6]);
                   #die(debug($this->request->data['User']));
                   if ( $this->request->data['User']['test'] == 0 ):
                       $this->User->create();
                       if ($this->User->save($this->request->data)):
                           $inserted++;
                       else:
                           echo 'Inserting - Error on line '. $counter.' file '.$this->request->data['User']['file']['name'].' <br />';
                           die($this->request->data['User']['username'] .' Error:'. var_dump($this->User->validationErrors));
                       endif;
                   endif;
               endif;
            endif;
       endwhile;
       fclose($file);
       $this->set('inserted', $inserted);
       $this->set('counter', $counter);
   endif;
 }

/**
 *  Remove user
 *  @access public
 *  @param integer $user_id
 *  @return void
 */
 public function admin_delete($user_id)
 {
   if ($this->User->delete($user_id)):
      $msg = __('Data removed');
  else:
      $msg = __('Data NOT removed');
  endif; 
  $this->msgFlash($msg, '/admin/users/listing');
 }
}

# ? > OEF
