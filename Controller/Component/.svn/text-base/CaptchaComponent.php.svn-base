<?php 
/**
 * Securimage-Driven Captcha Component
 * @author debuggeddesigns.com
 * @license MIT
 * @version 0.2
 */
 
App::uses('Component', 'Controller');
#the local directory of the vendor used to retrieve files
define('CAPTCHA_VENDOR_DIR', APP . 'Vendor' . DS . 'Securimage/');

App::import('Vendor','Securimage',array('file'=>'Securimage'.DS.'securimage.php')); 

class CaptchaComponent extends Component {

 public $SecureImage;

 # size configuration
 public $_image_height = 75; //the height of the captcha image
 public $_image_width = 350; //the width of the captcha image
     
 # filename and/or directory configuration
 public $_audio_path    = 'audio/';  # the full path to wav files used
 public $_gd_font_file  = 'gdfonts/bubblebath.gdf'; //the gd font to use
 public $_ttf_file      = 'elephant.ttf'; //the path to the ttf font file to load
 public $_wordlist_file = 'words/words.txt'; //the wordlist to use
     

 /**
   * Component Constructor
   * @access public
   * @return void
  */ 
 public function __construct(ComponentCollection $collection, $settings = array()) 
 {
    $this->Controller = $collection->getController();
    parent::__construct($collection, $settings); 
 }

/**
 *  The initialize method is called before the controller’s beforeFilter method.
 *  @access public
*   @param Controller $controller A reference to the instantiating controller object
 *  @return void
 */
 public function initialize(Controller $controller) 
 {
   $this->request  = $controller->request;
   $this->response = $controller->response;
   $this->_methods = $controller->methods;

   # add local directory name to paths
   $this->_ttf_file      = CAPTCHA_VENDOR_DIR.$this->_ttf_file; 
   $this->_gd_font_file  = CAPTCHA_VENDOR_DIR.$this->_gd_font_file;
   $this->_audio_path    = CAPTCHA_VENDOR_DIR.$this->_audio_path;
   $this->_wordlist_file = CAPTCHA_VENDOR_DIR.$this->_wordlist_file; 
   # CaptchaComponent instance of controller is replaced by a securimage instance

   $this->SecureImage =& new Securimage || die('Error loading object');

   # no distortion, the font will look exactly how it was designed to
   $this->SecureImage->perturbation = 0;
  
 }

 public function show()
 {
   return $this->SecureImage->show();
 }

 public function check($string)
 {
   return $this->SecureImage->check($string);
 }

}

# ? > EOF

