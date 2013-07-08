<?php
/**
 *  Chipotle Software (c) 2008-2012
 */

App::uses('HelperCollection', 'View');
App::uses('AppHelper', 'View/Helper');
App::uses('Router', 'Routing');
App::uses('ViewBlock', 'View');
App::uses('CakeEvent', 'Event');
App::uses('CakeEventManager', 'Event');
App::uses('CakeResponse', 'Network');

class ScormView extends View {

/**
 * List of variables to collect from the associated controller.
 *
 * @var array
 */
  protected $_passedVars = array(
    'viewVars', 'autoLayout', 'ext', 'helpers', 'view', 'layout', 'name', 'theme',
    'layoutPath', 'viewPath', 'request', 'plugin', 'passedArgs', 'cacheAction'
  );

/**
 * Constructor
 *
 * @param Controller $controller A controller object to pull View::_passedVars from.
 */
  public function __construct(Controller $controller = null) {
    if (is_object($controller)) {
      $count = count($this->_passedVars);
      for ($j = 0; $j < $count; $j++) {
        $var = $this->_passedVars[$j];
        $this->{$var} = $controller->{$var};
      }
      $this->_eventManager = $controller->getEventManager();
    }
    if (empty($this->request) && !($this->request = Router::getRequest(true))) {
      $this->request = new CakeRequest(null, false);
      $this->request->base = '';
      $this->request->here = $this->request->webroot = '/';
    }
    if (is_object($controller) && isset($controller->response)) {
      $this->response = $controller->response;
    } else {
      $this->response = new CakeResponse(array('charset' => Configure::read('App.encoding')));
    }
    $this->Helpers = new HelperCollection($this);
    $this->Blocks = new ViewBlock();
    parent::__construct();
  }

/**
 *  Render SCO iFrame
 *  @see View::render
 *  @access public
 *  @return boolean
 */
 public function render($view = Null, $layout = Null) 
 {
  $name      = Null;
  $extension = Null;
  $id        = Null;
  $modified  = Null;
  $path      = Null;
  $size      = Null;
  extract($this->viewVars, EXTR_OVERWRITE);  
  $dirs = explode("/", $path);
  $lastDir = end($dirs);

  #die(debug($dirs));
  $href  = 'http://'.$_SERVER['HTTP_HOST'].'/files/scorms/'. $lastDir;
  $href2 = 'http://'.$_SERVER['HTTP_HOST'].'/files/scorms/'. $lastDir .'/'. $data['ScormsSco']['launch']; # html file to charge
  $file  = $path .'/'. $data['ScormsSco']['launch'];
  #die(debug($file));
  header( 'Location: '. $href2 );

  # if (file_exists($path) && isset($extension) && array_key_exists($extension, $this->mimeType) && connection_status()) 
  if ( file_exists($file) ):
    $fileSize = @filesize($file);
    # fix for IE catching or PHP bug issue
    header("Pragma: public");
    header("Expires: 0"); # set expiration time
    # browser must download file from server instead of cache
	  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Type: text/html; charset=utf-8');
	  header("Content-Length: " . $fileSize);
	  header("Content-href: ". '<base href="'.$href.'" />');
    echo $href2;
	  @ob_end_clean(); # clean de buffer
    die();
  else:
      die('SCO file does not exist');
  endif;
  return True;
 }
}

# ? > EOF