<?php
/**********************************
 * Karamelo LMS
 * http://www.chipotle-software.com
 * Version 0.7
 * @license GNU Affero General Public License V3
 * file: APP/Controller/Components/facebook.php
 ***********************************/ 

App::import('Vendor', 'Facebook', array('file'=>'facebook.php'));

class FacebookComponent extends Component {
 private  $appapikey = 'adf90e83cf888c7a1504b757fc554a63';
 private  $appsecret = '3ca943fcedb242d9d212b35bb165314f';
 public   $facebook  = Null;
 public   $user_id   = 0; 

 public function setUserId()
 {
  $this->facebook = new Facebook($appapikey, $appsecret);
  $this->user_id = $facebook->require_login();
 }
 
 public function getFriends() 
 {
   # Greet the currently logged-in user!
   #echo "<p>Hello, <fb:name uid=\"$user_id\" useyou=\"false\" />!</p>";
   // Print out at most 25 of the logged-in user's friends,
   // using the friends.get API method
   #echo "<p>Friends:";
   $friends = $this->facebook->api_client->friends_get();
   $friends = array_slice($friends, 0, 25);
   return $friends;
 }
}
# ? > EOF
