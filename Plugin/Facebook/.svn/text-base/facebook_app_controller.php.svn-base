<?php
/* Karamelo
 * @copyright		Copyright 2009-2011, Chipotle Software
 * @link			http://www.chipotle-software.com/
 * @package			org.karamelo
 * @subpackage		org.karamelo.app
 * @since			Version 2.0
 * @version			$Revision: 1590 $
 * @modifiedby		$LastChangedBy: aarkerio $
 * @lastmodified	$Date: 2009-08-30  $
 * @license			http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License Version 3
 */

App::import('Vendor', 'facebook/facebook');
include('fbk.php'); #  your secret api
class FacebookAppController extends AppController
{
  public $helpers = array('Javascript');
  public $facebook;

  public $__fbApiKey = 'adf90e83cf888c7a1504b757fc554a63';
  public $__fbSecret = fbk::fbsecret;

  public function __construct()
  {
   parent::__construct();
   # Prevent the 'Undefined index: facebook_config' notice from being thrown.
   $GLOBALS['facebook_config']['debug'] = NULL;
   # Create a Facebook client API object.
   $this->facebook = new Facebook($this->__fbApiKey, $this->__fbSecret);
  }
  public function connect()
  {
    $hash1 = Services_Facebook_Connect::hashEmail('joe@example.com');
    $hash2 = Services_Facebook_Connect::hashEmail('jeff@example.com');
    $args = array();
    $args[] = array(
                        'email_hash'  => $hash1,
                        'account_id'  => 12345678,
                        'account_url' => 'http://example.com/users?id=12345678'
                        );

    $args[] = array(
            'email_hash'  => $hash2
                        );

    $result =   $this->facebook->connect_registerUsers($args);
  }
}
# ? > EOF

