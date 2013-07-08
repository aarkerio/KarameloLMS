<?php
/**********************************
 * Karamelo LMS
 * GNU Affero General Public License V3
 * http://www.chipotle-software.com (c)
 * Version 0.8
 * file: APP/Controller/Components/AddsComponent.php
 ***********************************/ 

App::uses('Component', 'Controller');
App::uses('Debugger', 'Utility');

class AddsComponent extends Component {

/**
 *  The initialize method is called before the controller’s beforeFilter method.
 *  @access public
 *  @param Controller $controller A reference to the instantiating controller object
 *  @return void
 */
 public function initialize(Controller $controller) 
 {
    $this->request = $controller->request;
	$this->response = $controller->response;
	$this->_methods = $controller->methods;
 }

/**
 * Return a varchar password
 * @acces public 
 * @param string $length
 * @return string
 */
 public function genPassword($length) 
 {
    $password = '';
    
    srand((double)microtime()*1000000);
    
    $vowels  = array("a", "e", "i", "o", "u");
    $numbers = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
    $cons    = array("b", "c", "d", "g", "h", "j", "k", "l", "m", "n", "p", "r", "s", "t", "u", "v", "w", "tr", 
    "cr", "br", "fr", "th", "dr", "ch", "ph", "wr", "st", "sp", "sw", "pr", "sl", "cl"); 
     
    $num_vowels = count($vowels); 
    $num_cons   = count($cons); 
    
     
    for($i = 0; $i < $length; $i++)
    {
        $password .= $cons[rand(0, $num_cons - 1)] . $numbers[rand(0, count($numbers) - 1)] . $vowels[rand(0, $num_vowels - 1)]; 
    }
    
    return substr($password, 0, $length); 
 }

/**
 * Handle images
 * @acces public 
 * @param string $length
 * @return string
 */
 public function get_extension($imagetype) 
 {    
   if ( empty($imagetype) ):
       return False;
   endif;
     
   switch($imagetype)
   {
           case 'image/bmp': return '.bmp';
           case 'image/cis-cod': return '.cod';
           case 'image/gif': return '.gif';
           case 'image/ief': return '.ief';
           case 'image/jpeg': return '.jpg';
           case 'image/pipeg': return '.jfif';
           case 'image/tiff': return '.tif';
           case 'image/x-cmu-raster': return '.ras';
           case 'image/x-cmx': return '.cmx';
           case 'image/x-icon': return '.ico';
           case 'image/x-portable-anymap': return '.pnm';
           case 'image/x-portable-bitmap': return '.pbm';
           case 'image/x-portable-graymap': return '.pgm';
           case 'image/x-portable-pixmap': return '.ppm';
           case 'image/x-rgb': return '.rgb';
           case 'image/x-xbitmap': return '.xbm';
           case 'image/x-xpixmap': return '.xpm';
           case 'image/x-xwindowdump': return '.xwd';
           case 'image/png': return '.png';
           case 'image/x-jps': return '.jps';
           case 'image/x-freehand': return '.fh';
           default: return False;
   }
 }

/**
 * Get extension
 * @acces public 
 * @param string $length
 * @return string
 */
 public function last3chars($filename)
 {
   $parts = explode('.',$filename);
   $last = count($parts) - 1;
   $ext = $parts[$last];
   return $ext;
 }


/**
 *  Validate email format and hosting address
 * @acces public 
 * @param string $length
 * @return string
 */
 public function validEmail($email) 
 {
  # Dave Child code  
  # First, we check that there's one @ symbol, and that the lengths are right
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)):
      # Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
      return False;
  endif;
  
  # Split it into sections to make life easier
  $email_array = explode("@", $email);
  
  $local_array = explode(".", $email_array[0]);
  
  for ($i = 0; $i < sizeof($local_array); $i++):
     if (!ereg("^(([A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])):
         return False;
     endif;
  endfor;
  
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])):      # Check if domain is IP. If not, it should be valid domain name
      $domain_array = explode(".", $email_array[1]);
      if ( sizeof($domain_array) < 2 ):
        return False; // Not enough parts to domain
      endif;
    
      for ($i = 0; $i < sizeof($domain_array); $i++):
          if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])):
              return False;
          endif;
      endfor;
  endif;
  return True;
 }

/**
 *  resizeImage
 *  @access public  
 *  @return boolean
 */
 public function resizeImage($file, $source, $destination, $width=100, $thumb = True) 
 {
   if ( $thumb and file_exists($destination . $file) ):
        return True;
   endif;
   
   $new_img     = $destination . $file;   # final system path
   $img_file    = $source . $file;        # system path
   #die($img_file);
   $img_info    = getimagesize($img_file);  # return array
   $imagewidth  = $img_info[0];
   $imageheight = $img_info[1];
   $img_type    = $img_info[2];    # 1 = GIF, 2 = JPG, 3 = PNG
   $ratio       = ($imagewidth / $width);
   $new_h       = round($imageheight / $ratio);
   # create
   switch ($img_type):
       case 1;
               $src_img = imagecreatefromgif($img_file);
               $dst_img = imagecreatetruecolor($width, $new_h);
               imagecopyresized($dst_img,$src_img,0,0,0,0,$width,$new_h, $imagewidth, $imageheight);
               imagegif($dst_img, $new_img, "100");
               return True;
       case 2;
	           
               $src_img = imagecreatefromjpeg($img_file);
               $dst_img = imagecreatetruecolor($width, $new_h);
               imagecopyresized($dst_img,$src_img,0,0,0,0,$width,$new_h, $imagewidth, $imageheight);
               imagejpeg($dst_img, $new_img, "100");
               return True;
       case 3;   
               $dst_img = imagecreatetruecolor($width, $new_h);
               $src_img = ImageCreateFrompng($img_file); 
               imagecopyresized($dst_img,$src_img,0,0,0,0,$width,$new_h, $imagewidth, $imageheight);
               imagepng($dst_img, $new_img);
               return True;
   endswitch;
 }
}
# ? > EOF
