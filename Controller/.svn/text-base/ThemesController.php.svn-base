<?php
/**
*  Karamelo e-Learning Platform
*  GNU Affero General Public License V3
*  @copyright Copyright 2006-2012, Chipotle Software, Inc. (http://www.chipotle-software.com)
*  @version 0.7
*  @package news
*  @license http://www.gnu.org/licenses/agpl.html
*/
# file: APP/controllers/themes_controller.php
 
App::uses('Sanitize', 'Utility');

class ThemesController extends AppController {

/**
 * Load CakePHP helpers
 * @access public
 * @var array
 */
 public $helpers   = array('Ck');

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */  
 public function beforeFilter() 
 {
   parent::beforeFilter();
   $this->Auth->allow(array('view', 'display'));
 }

 /* === ADMIN METHODS === */
/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */
 public function admin_listing()
 {
   $this->layout = 'admin';
   $params = array('fields'  => array('theme', 'img', 'id', 'description'),
                   'order'   => 'Theme.theme');
   $this->set('data', $this->Theme->find('all', $params));
 }

/**
 *  Auth Component defining permissions
 *  @access public
 *  @return void 
 */
 public function admin_edit($theme_id = Null)
 {
  $this->layout    = 'admin';
  if (empty($this->request->data['Theme'])):
      $this->request->data   = $this->Theme->read(Null, $theme_id);
  else:
      if ($this->Theme->save($this->request->data)):
          $this->msgFlash(__('Data saved'), '/admin/themes/listing');
	  endif;
  endif;
 }

/**
 *  Add theme
 *  @access public
 *  @return void 
 */
 public function admin_add() 
 {  
  $this->layout    = 'admin';  
  if (!empty($this->request->data['Theme']) && is_uploaded_file($this->request->data['Theme']['file']['tmp_name'])): 
     /* SUBMITTED INFORMATION - use what you need
      *  temporary filename (pointer): $imgfile
      *  original filename           : $imgfile_name
      *  size of uploaded file       : $imgfile_size
      *  mime-type of uploaded file  : $imgfile_type
      */
      # uploaddir:  directory relative to where script is running 
      $uploaddir    = '../webroot/img/themes';
      $maxfilesize  = 524288;     # 0.5 MB max size 
      $imgfile_name = $this->request->data['Theme']['file']['name'];
      $imgfile_size = $this->request->data['Theme']['file']['size'];
      $imgfile      = $this->request->data['Theme']['file']['tmp_name'];
      $type         = $this->request->data['Theme']['file']['type'];

      list($width, $height, $typeimg, $attr) = getimagesize($imgfile);
    
      # Security: checks to see if file is secure, if not do not allow upload ==
      if ( $type != 'image/jpeg' && $type != 'image/pjpeg' && $type != 'image/png' && $type != 'image/gif'):
          $error  = "ERROR the file $imgfile_name $imgfile_name is not valid. Only .jpg, .gif or .png files. Current type file: ".$type." \n";
          unlink($imgfile);  # delete uploaded file 
          $this->flash($error,'/admin/themes/listing/', 4);
      endif;
    
      if ( $imgfile_size > $maxfilesize):
          $error  = "Error. The Theme is too big. Bigger than 2.0 MB. Current size: ".$imgfile_size."\n";
          unlink($imgfile);    # delete uploaded file 
          $this->flash($error,'/admin/themes/listing/', 4);
          return false;
      endif;

      # check size
      if ($width > 120 || $height > 120):
      	  $error = "Error. The image is too large. Widht or height is larger than 120 pixels. Current size: width ".$width."px  height ".$height."px \n";
          unlink($imgfile);
          $this->flash($error,'/admin/themes/listing/', 4);
          return False;
      endif;
      # setup final file location and name 
      $final_filename = str_replace(" ", "_", $imgfile_name); # change spaces to underscores in filename  
      $newfile        = $uploaddir . "/" . $final_filename;
      if (is_uploaded_file($imgfile)):
          # move file to proper directory 
	      if ( !move_uploaded_file($imgfile, $newfile) ):
	          # if an error occurs the file could not  be written, read or possibly does not exist 
	          $this->flash(__('Error Uploading File'), '/admin/Themes/listing/', 3);
	      endif;
      endif;
      # Database stuff 
      $this->request->data['Theme']['img']  = $final_filename;
      if ($this->Theme->save($this->request->data)):
          $this->msgFlash(__('Data saved'), '/admin/themes/listing');
      else:
          $errors = (string) '';
          foreach( $this->Theme->validationErrors as $e ):
          $errors .= $e."\n";
      endforeach;
          $this->flash($errors,  '/admin/themes/listing');
      endif;
  endif;
 }

/**
 *  Remove theme
 *  @access public
 *  @return void 
 */
 public function admin_delete($theme_id)
 { 
  $file = $this->Theme->field('Theme.img', array('Theme.id'=>$theme_id));
  if ( $this->Theme->delete($theme_id) ):
      unlink('../webroot/img/themes/' . $file);
      $this->msgFlash(__('Data removed'), '/admin/themes/listing');
  endif;
 }
}
# ? >
