<?php
/**
*  Karamelo e-Learning Platform
*  GPLv3
*  @copyright Copyright 2006-2010, Chipotle SoftwareI(c)
*  @version 0.7
*  @package scorm
*  @license http://www.gnu.org/licenses/gpl-3.0.html
*/
# file : APP/Controller/ScormvarsController.php

App::import('Sanitize', 'Core', 'Folder');

class ScormvarsController extends ScormAppController {
  
  public $name     = 'Scormvars';
  public $helpers  = array('Ajax', 'Javascript');
  public $SCOInstanceID;

/**
 *
 * @access public
 * @return void
 */
  public function beforeFilter() 
  {
	    parent::beforeFilter();
	    $this->Auth->allow(array('index', 'play', 'run', 'initialize', 'initializeElement', 'readElement', 'getValue', 'setValue'));	   
  }

/**
 *
 * @access public
 * @return void
 */
  public function index()
  {
    $this->layout='portal';
  }

/**
 *
 * @access public
 * @return void
 */
  public function run($id=null)
  {
    $this->layout = 'ajax';
    $this->set('ScoID', $id); 
  }

/**
 *
 * @access public
 * @return void
 */
  public function readElement($varName) 
  {
    $safeVarName = $varName;
    $result = $this->Scormvar->query("select varvalue from Scormvars where ((id=".$this->SCOInstanceID.") and (varname='$safeVarName'))");
    #list($value) = $result[0][0]['varvalue'];	
    return $result[0][0]['varvalue'];
  }

/**
 *
 * @access public
 * @return void
 */
  public function writeElement($varName,$varValue) 
  { 
    $safeVarName  = $varName;
    $safeVarValue = $varValue;
    $this->Scormvar->query("DELETE FROM Scormvars where ((id=".$this->SCOInstanceID.") and (varname='$safeVarName'))");
    $this->Scormvar->query("INSERT INTO Scormvars (id,varName,varValue) values (".$this->SCOInstanceID.",'$safeVarName','$safeVarValue')");
    return;
  }

/**
 *
 * @access public
 * @return void
 */
  public function clearElement($varName) 
  {
    $safeVarName =$varName;
    $this->Scormvar->query("DELETE FROM Scormvars WHERE ((id=".$this->SCOInstanceID.") and (varName='$safeVarName'))");
    return;
  }

/**
 *
 * @access public
 * @return void
 */
  public function getValue()
  {
    $this->autoRender=False; 
    $this->layout = 'ajax';
    $varname = trim($_GET['varname']);
    $this->SCOInstanceID = $_GET['SCOInstanceID'] * 1;
    // no element name supplied, return an empty string
    if (! $varname) 
    {
      $varvalue = "";
    }
    else{
      // otherwise, read data from the 'scormvars' table
      $varvalue = $this->readElement($varname);
    }

    // return element value to the calling program
    print $varvalue;
  }
  
/**
 *
 * @access public
 * @return void
 */
  public function setValue()
  {
    $this->autoRender=False; 
    $this->layout = 'ajax';
    // read GET data
    $varname = $_GET['varname'];
    $this->SCOInstanceID = $_GET['SCOInstanceID'] * 1;
    
    // read POST data
    $varvalue = $_POST['varvalue'];
    
    // save data to the 'scormvars' table
    $this->writeElement($varname,$varvalue);
    
    // return value to the calling program
    print "true";		
  }

/**
 *
 * @access public
 * @return void
 */
  public function initialize()
  {
    $this->autoRender=False; 
    $this->layout = 'ajax';
    $this->SCOInstanceID=1; //$this->data['Exercise']['id']; 
    echo $this->SCOInstanceID;
    //$this->this->data['Entry']['body']; 
    // ------------------------------------------------------------------------------------
    // elements that tell the SCO which other elements are supported by this API
    $this->initializeElement('cmi.core._children','student_id,student_name,lesson_location,credit,lesson_status,entry,score,total_time,exit,session_time');
    $this->initializeElement('cmi.core.score._children','raw');
    
    # student information
    $this->initializeElement('cmi.core.student_name',$this->getFromLMS('cmi.core.student_name'));
    $this->initializeElement('cmi.core.student_id',$this->getFromLMS('cmi.core.student_id'));
    
    # mastery test score from IMS manifest file
    $this->initializeElement('adlcp:masteryscore',$this->getFromLMS('adlcp:masteryscore'));
    
    # SCO launch data from IMS manifest file 
    $this->initializeElement('cmi.launch_data',$this->getFromLMS('cmi.launch_data'));
    
    # progress and completion tracking
    $this->initializeElement('cmi.core.credit','credit');
    $this->initializeElement('cmi.core.lesson_status','not attempted');
    $this->initializeElement('cmi.core.entry','ab initio');
    
    # total seat time
    $this->initializeElement('cmi.core.total_time','0000:00:00');
    
    # new session so clear pre-existing session time
    $this->clearElement('cmi.core.session_time');
  }

/**
 *
 * @access public
 * @return void
 */
  public function initializeElement($varName,$varValue) 
  {
    // look for pre-existing values
    $this->autoRender = False; 
    $this->layout     = 'ajax';
    
    // make safe for the database
    $safeVarName  = $varName;
    $safeVarValue = $varValue;
    $result = $this->Scormvar->query("select varValue from Scormvars where ((id=".$this->SCOInstanceID.") and (varName='$safeVarName'))");
    if (empty($result)):
        $this->Scormvar->query("insert into Scormvars (id,varName,varValue) values (".$this->SCOInstanceID.",'$safeVarName','$safeVarValue')");
    endif;
  }

// ------------------------------------------------------------------------------------
// LMS-specific code
// ------------------------------------------------------------------------------------
/**
 *
 * @access public
 * @return void
 */
  public function getFromLMS($varname) {
    
    switch ($varname) {
      
    case 'cmi.core.student_name':
      $varvalue = $this->Auth->user('username');
      break;
      
    case 'cmi.core.student_id':
      $varvalue = (int) $this->Auth->user('id');
      break;
      
    case 'adlcp:masteryscore':
      $varvalue = '90';
      break;
      
    case 'cmi.launch_data':
      $varvalue = '';
      break;
      
    default:
      $varvalue = '';
      
    }
    
    return $varvalue;
    
  }

/**
 * Finish interaction
 */
 public function finish()
 {	
   $this->autoRender = False; 
   $this->layout = 'ajax';
   // read GET data
   $this->SCOInstanceID = $_GET['SCOInstanceID'] * 1;
    
   // ------------------------------------------------------------------------------------
   // set cmi.core.lesson_status
    
   // find existing value of cmi.core.lesson_status
   $lessonstatus = $this->readElement('cmi.core.lesson_status');
    
   // if it's 'not attempted', change it to 'completed'
   if ($lessonstatus == 'not attempted') {
      $this->writeElement('cmi.core.lesson_status','completed');
    }
    
    // has a mastery score been specified in the IMS manifest file?
    $masteryscore = $this->readElement('adlcp:masteryscore');
    $masteryscore *= 1;
    
    if ($masteryscore) 
    {  
        // yes - so read the score
        $rawscore = $this->readElement('cmi.score.raw');
        $rawscore *= 1;
      
        // set cmi.core.lesson_status to passed/failed
        if ($rawscore >= $masteryscore) {
	        $this->writeElement('cmi.core.lesson_status','passed');
        }
        else {
	        $this->writeElement('cmi.core.lesson_status','failed');
        }
    }
    
    // ------------------------------------------------------------------------------------
    // set cmi.core.entry based on the value of cmi.core.exit
    
    // clear existing value
    $this->clearElement('cmi.core.entry');
    
    // new entry value depends on exit value
    $exit = $this->readElement('cmi.core.exit');
    if ($exit == 'suspend') {
        $this->writeElement('cmi.core.entry','resume');
    }
    else {
        $this->writeElement('cmi.core.entry','');
    }
    
    // ------------------------------------------------------------------------------------
    // process changes to cmi.core.total_time
    
    // read cmi.core.total_time from the 'scormvars' table
    $totaltime = $this->readElement('cmi.core.total_time');
    
    // convert total time to seconds
    $time = explode(':',$totaltime);
    $totalseconds = $time[0]*60*60 + $time[1]*60 + $time[2];
    
    // read the last-set cmi.core.session_time from the 'scormvars' table
    $sessiontime = $this->readElement('cmi.core.session_time');
    
    // no session time set by SCO - set to zero
    if (! $sessiontime) {
      $sessiontime = "00:00:00";
    }
    
    // convert session time to seconds
    $time = explode(':',$sessiontime);
    $sessionseconds = $time[0]*60*60 + $time[1]*60 + $time[2];
    
    // new total time is ...
    $totalseconds += $sessionseconds;
    
    // break total time into hours, minutes and seconds
    $totalhours = intval($totalseconds / 3600);
    $totalseconds -= $totalhours * 3600;
    $totalminutes = intval($totalseconds / 60);
    $totalseconds -= $totalminutes * 60;
    
    // reformat to comply with the SCORM data model
    $totaltime = sprintf("%04d:%02d:%02d",$totalhours,$totalminutes,$totalseconds);
    
    // save new total time to the 'scormvars' table
    $this->writeElement('cmi.core.total_time',$totaltime);
    
    // delete the last session time
    $this->clearElement('cmi.core.session_time');
    
    // ------------------------------------------------------------------------------------
    // return value to the calling program
    print "true";
  }
}
# ? > EOF
