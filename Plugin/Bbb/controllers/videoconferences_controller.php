<?php
/* Karamelo
 * @copyright		Copyright 2009-2011, Chipotle Software
 * @author          Manuel Montoya <mmontoya_at_chipotle-software_PUNTO_com
 * @link			http://www.chipotle-software.com/
 * @package			org.karamelo
 * @subpackage		org.karamelo.app
 * @since			Version 2.0 
 * @version			$Revision: 1590 $
 * @modifiedby		$LastChangedBy: aarkerio $
 * @lastmodified	$Date: 2010-01-30  $
 * @license			http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License Version 3
 */

class QuotesController extends BbbAppController 
{
 public $user_id;

/**
 * Name: beforeFilter
 * Desc: Performs necessary steps and function calls prior to executing
 *       any view function calls.
 * See: APP/plugins/facebook/facebook_app_controller.php
 */
 public function beforeFilter() 
 {
  parent::beforeFilter();
  $this->Auth->allowedActions = array('index', 'friends', 'rss');
  $this->user_id = $this->facebook->require_login();
  #die(debug( $this->user_id ));
 }

/**
 * Name: index
 * Desc: Display the friends index page.
 * @access public
 * @return void 
 */
 public function index() 
 {
  # Retrieve the user's friends and pass them to the view.
  #$friends = $this->facebook->api_client->friends_get();
  #die(debug($friends));
  #$this->set('friends', $friends);
  #$this->set('user_id', $this->user);
 }

/**
 * Name: index
 * Desc: Display the friends index page.
 * @access public
 * @return void 
 */
 public function friends() 
 {
  $this->layout = False; #'portal';
  $friends = $this->facebook->api_client->friends_get();
  #die(debug($friends));
  $this->set('user_id', $this->user_id);
  $this->set('friends', $friends);
 }
}
# ? > EOF