<?php
/**
 * Karamelo Facebook Suite
 * @copyright		Copyright 2009-2011, Chipotle Software (c)
 * @link			http://www.chipotle-software.com/
 * @since			Version 2.0 
 * @version			$Revision: 1590 $
 * @modifiedby		$LastChangedBy: aarkerio $
 * @lastmodified	$Date: 2010-01-18  $
 * @license			http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License Version 3
 */

App::import('Vendor', 'facebook/facebook');

include('fbk.php'); #  your secret FaceBook api, you need create this file, see: http://trac.chipotle-software.com/karamelo/wiki/FbkFIle 

class KsuiteAppController extends AppController 
{
  public $helpers = array('Js' => array('Jquery'));
  public $facebook;
  
  private $_fbAppID  = fbk::fbAppID;
  private $_fbApiKey = fbk::fbApiKey;
  private $_fbSecret = fbk::fbsecret;
  
/**
 *  I need this in all the plugin so I put here
 *  @access public
 *  @return void
 */
  public function __construct()
  {
   parent::__construct();
   # Prevent the 'Undefined index: facebook_config' notice from being thrown.
   $GLOBALS['facebook_config']['debug'] = NULL;
   # Create a Facebook client API object.
   $fb_array = array(
                     'appId'  => $this->_fbAppID,
                     'secret' => $this->_fbSecret, 
                     'cookie' => True  #  enable optional cookie support
                    );
   $this->facebook = new Facebook( array(
                     'appId'  => '431995865353',
                     'secret' => '418a0a131a7fd27a8420e5b2f7cd5edf', 
                     'cookie' => True  #  enable optional cookie support
                                         )
                  );

   #die( var_dump(   $this->facebook->getSession() )  );
  }
}
# ? > EOF