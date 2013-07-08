<?php 
/*
 * GcalendarHelper Chipotle Software(c) 2009-2011. Recover Gcalendars user.
 * @version 0.7
 * @license Affero GPLv3
 */

/**
 * Import libraries
 * gCalendar API in Zend 
 */
#die(APP);
ini_set('include_path', ini_get('include_path') . ':' . APP . '/Vendor');
App::import('Vendor','Gdata' ,  array('file'=> 'Zend/Gdata.php'));

App::import('Vendor','AuthSub', array('file'=> 'Zend/Gdata/AuthSub.php'));

/**
 * @see Zend_Gdata_ClientLogin
 */
#App::import('Vendor','ClientLogin', array('file'=>'Gdata'.DS.'ClientLogin'));

/**
 * @see Zend_Gdata_InstallationChecker
 */
App::import('Vendor','InstallationChecker', array('file'=>'Gdata'.DS.'InstallationChecker.php'));

/**
 * @see Zend_Gdata_Calendar
 */
App::import('Vendor','Calendar', array('file'=> 'Zend/Gdata/Calendar.php'));

class GcalendarHelper extends Helper {

/**
 * Holds the content to be cleaned.
 *
 * @access private
 * @var mixed
 */
 public  $initialized   = False;
 public  $helpers       = array('Html', 'Form');
 private $__gdataObject = NUll;

/**
 * @var string Location of AuthSub key file.  include_path is used to find this
 */
 private $_authSubKeyFile = Null; # Example value for secure use: 'mykey.pem'

/**
 * @var string Passphrase for AuthSub key file.
 */
 private $_authSubKeyFilePassphrase = Null;

/**
 * @var string Passphrase for AuthSub key file.
 */
 private $_src = Null; 

/**
 * @var string Passphrase for AuthSub key file.
 */
 private $_client = Null;

/**
 * Installation checker 
 * @access public
 * @return void
 */
 public function installationChecker()
 {
   $installationChecker = new InstallationChecker;
 }

/**
 * Experimental - gCalendar
 * @access public
 * @return void
 */
 public function gCalendar() 
 {
  # Magic factory instantiation
  $gdataCal    = new Zend_Gdata_Calendar();
  $this->__gdataObject = $gdataCal->newObject();
 }

 public function getAuthSubUrl() 
 {
  $next    = $this->__curPageURL();
  $scope   = 'http://www.google.com/calendar/feeds/';
  $secure  = False;
  $session = True;
  return Zend_Gdata_AuthSub::getAuthSubTokenUri($next, $scope, $secure, $session);
 }

/**
 * Current URL
 * @access private
 * @return string
 */
 private function __curPageURL() 
 {
   #debug($_SERVER);
   $pageURL = 'http';
   if ($_SERVER['SERVER_PORT'] == 443):   #SSL
       $pageURL .= 's';
   endif;
   $pageURL .= '://';
   if ($_SERVER["SERVER_PORT"] != "80"):
       $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
   else:
       $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
   endif;
   return $pageURL;
 }

/**
 * Outputs an HTML unordered list (ul), with each list item representing a
 * calendar in the authenticated user's calendar list.
 *
 * @param  Zend_Http_Client $client The authenticated client object
 * @access public
 * @return void
 */
 public function setSession($token=False)
 {
  if ( !isset($_SESSION['sessionToken']) and isset($token) ):
      $_SESSION['sessionToken'] = Zend_Gdata_AuthSub::getAuthSubSessionToken($token);
  endif;

  return True; 
 }

/**
 *
 * @return mixed object or boolean
 */
 public function getClient($token=False)
 {
  if ( $token ):
      $this->_client = Zend_Gdata_AuthSub::getHttpClient($token);
      return True;
  else: 
      return False;
  endif;
 }

/**
 * Outputs an HTML unordered list (ul), with each list item representing a
 * calendar in the authenticated user's calendar list.
 *
 * @param  Zend_Http_Client $client The authenticated client object
 * @access public
 * @return string
 */
 public function outputCalendarList()
 {
  try {
      $gdataCal = new Zend_Gdata_Calendar($this->_client);
      $calFeed = $gdataCal->getCalendarListFeed();
      if ( !$calFeed ):
          return False;
      endif;
      $str  = "<h1>" . $calFeed->title->text . "</h1>\n";
      $str .= "<ul>\n";
      foreach ($calFeed as $calendar):
          $this->_src   = $calendar->content->src;
          $gcalendar_id = $this->__chomps();
          $str .= "\t<li><a href=\"#\" id=\"closelink\"onclick=\"setGc('$gcalendar_id'); return false;\">" . $calendar->title->text . "</a></li>\n";
      endforeach;
      $str .= "</ul>\n";
      return $str;
   } catch (Zend_Gdata_App_Exception $e) {
      echo "Error: " . $e->getMessage();
   }
 }

/**
 * Clean to get calendar_id
 * @access private
 * @return string
 */
 private function __chomps()
 {
   $pieces = explode('/', $this->_src);
   #debug($pieces);
   $gcalendar_id = str_replace("%40", "@", $pieces[5]);
   return $gcalendar_id;
 }
 
/**
 * Clean to get calendar_id
 * @access public
 * @return boolean
 */
 public function createCalendar($name='Vclassroom calendar')
 {
  try {
      $gdataCal = new Zend_Gdata_Calendar($this->_client);
      #$calFeed = $gdataCal->getCalendarListFeed();
      # I actully had to guess this method based on Google API's "magic" factory
      $appCal = $gdataCal->newListEntry();
      # I only set the title, other options like color are available.
      $appCal->title = $gdataCal->newTitle($name); 

      # This is the right URL to post to for new calendars...
      # Notice that the user's info is nowhere in there
      $own_cal = "http://www.google.com/calendar/feeds/default/owncalendars/full";

      # And here's the payoff. 
      #Use the insertEvent method, set the second optional var to the right URL
      return $gdataCal->insertEvent($appCal, $own_cal);
      
   } catch (Zend_Gdata_App_Exception $e) {
      echo "Error: " . $e->getMessage();
   }
 }

 /**
  * Creates an event on the authenticated user's default calendar with the
  * specified event details.
  *
  * @param  Zend_Http_Client $client    The authenticated client object
  * @param  string           $title     The event title
  * @param  string           $desc      The detailed description of the event
  * @param  string           $where
  * @param  string           $startDate The start date of the event in YYYY-MM-DD format
  * @param  string           $startTime The start time of the event in HH:MM 24hr format
  * @param  string           $endDate   The end date of the event in YYYY-MM-DD format
  * @param  string           $endTime   The end time of the event in HH:MM 24hr format
  * @param  string           $tzOffset  The offset from GMT/UTC in [+-]DD format (eg -08)
  * @return string The ID URL for the event.
  */
 public function createEvent($client, $title = 'Karamelo activity',
                       $desc='Activity in virtual classroom', $where = 'Virtual classroom',
                       $startDate = '2010-01-20', $startTime = '10:00',
                       $endDate = '2010-01-20', $endTime = '11:00', $tzOffset = '-08')
 {
  try {
     $gc = new Zend_Gdata_Calendar($this->_client);
     $newEntry = $gc->newEventEntry();
     $newEntry->title = $gc->newTitle(trim($title));
     $newEntry->where  = array($gc->newWhere($where));

     $newEntry->content = $gc->newContent($desc);
     $newEntry->content->type = 'text';

     $when = $gc->newWhen();
     $when->startTime = "{$startDate}T{$startTime}:00.000{$tzOffset}:00";
     $when->endTime = "{$endDate}T{$endTime}:00.000{$tzOffset}:00";
     $newEntry->when = array($when);

     $createdEntry = $gc->insertEvent($newEntry);
     return $createdEntry->id->text;
    } catch (Zend_Gdata_App_Exception $e) {
      echo "Error: " . $e->getMessage();
    }
 }

 # https or http ?
 private function __getCurrentUrl() 
 {
  global $_SERVER;
  /**
   * Filter php_self to avoid a security vulnerability.
   */
  $php_request_uri = htmlentities(substr($_SERVER['REQUEST_URI'], 0, strcspn($_SERVER['REQUEST_URI'], "\n\r")), ENT_QUOTES);

  if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
      $protocol = 'https://';
  } else {
      $protocol = 'http://';
  }
  $host = $_SERVER['HTTP_HOST'];
  if ($_SERVER['SERVER_PORT'] != '' &&
      (($protocol == 'http://' && $_SERVER['SERVER_PORT'] != '80') ||
       ($protocol == 'https://' && $_SERVER['SERVER_PORT'] != '443'))) 
  {
      $port = ':' . $_SERVER['SERVER_PORT'];
  } else {
      $port = '';
  }
  return $protocol . $host . $port . $php_request_uri;
 }
} 
# ? > EOF