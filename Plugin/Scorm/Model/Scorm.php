<?php
/**
 *  Chipotle-Software (c) 2009-2012
 *  @version 0.7
 *  @license GPLv3
 *  @package scorm
 */

App::uses('Core', 'Folder');

class Scorm extends ScormAppModel {

/**
 *  Load behaviours
 *  @access public    
 *  @var array
 */ 
 public $actsAs  = array('Containable');

/**
 *  CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $hasMany = array('Scorm.ResultScorm','Scorm.ScormVclassroom','Scorm.ScormsSco');

/**
 *  validate   CakePHP framework array element
 *  @access public
 *  @var array
 */
 public $validate = array(
          'name' => array(
               'rule' => array('minLength', '2'),
               'message' => 'Mimimum 2 characters long'
              ),
          'description'   => array(
                'rule'    => array('minLength', '1'),
                'message' => 'Mimimum 1 characters long'
              )
 );

/**
 *  OS System path
 *  @access private
 *  @var string
 */ 
private $_finalPath   = '';


/**
 *  OS System path
 *  @access private
 *  @var string
 */ 
private $_XmlObject   = '';

/**
 *  OS System path
 *  @access private
 *  @var string
 */ 
private $_folder   = 'webroot/files/scorms/';

/**
 *  OS System path
 *  @access private
 *  @var string
 */
private $_itemTitle   = '';

/**
 *  Set user_id for internal process
 * @access public
 * @return void
 */
 public function setUserID($user_id)
 {
  $this->userId = $user_id;
 }

/**
 *  Ugly java kind function
 *  @param array
 */
 public function passData($data)
 {
  $this->passedData = $data;
 }

/**
 * Import the scorm object (as a result from the parse_manifest function) into the database structure
 * Three steps: 1) Scorm data, 2) All Items, 3) All resources 
 * @param	string	Unique course code 
 * @return	bool	Returns -1 on error
 * @access public
 */
 public function importManifest()
 {
  $file = $this->_finalPath . '/imsmanifest.xml';

  if ( file_exists($file) ):
      $this->_XmlObject = simplexml_load_file($file);
  else:
      die('imsmanifest.xml file does not exist in zip');
  endif;

  #die( pr( $this->_XmlObject ));
  # Prepare array in order to insert new Scorm
  $this->data['Scorm']['user_id']        = (int) $this->userId;
  $this->data['Scorm']['name']           = $this->passedData['name'];
  $this->data['Scorm']['summary']        = $this->passedData['summary'];
  $this->data['Scorm']['path']           = $this->_finalPath; # for instance: guerra_de_reforma/  
  $this->data['Scorm']['version']        = $this->_XmlObject->metadata->schemaversion != Null ? $this->_XmlObject->metadata->schemaversion : '1.2';
  $this->data['Scorm']['maxattent']      = isset($this->_XmlObject->metadata->maxattent)  ? $this->_XmlObject->metadata->maxattent : $this->passedData['maxattent'];
  $this->data['Scorm']['display_order']  = 0;    # SCORM display order in admin_listing view
  $this->data['Scorm']['lang_id']        = 1;    # later

  #die(debug($this->data));
  if ($this->save($this->data)):   #save SCORM
      $this->log('Logged ' . date('l jS \of F Y h:i:s A').' -- added SCORM ', 'logged');
  else:
      die(debug($this->validationErrors));
  endif;
  # after save  
  $scorm_id = (int) $this->getLastInsertID();
  
  #die(pr($xml->organizations->organization->attributes()->identifier));
  # Insert father (root '/') parent in ScormsSco model, the launch must be empty
  $this->data['ScormsSco']['scorm_id']      = $scorm_id; 
  $this->data['ScormsSco']['manifest']      = $this->__getAttribute('identifier');
  $this->data['ScormsSco']['organization']  = $this->_XmlObject->organizations->organization->attributes()->identifier; #  MANIFEST01_ORG1   
  $this->data['ScormsSco']['parent']          = '/';  #  eXede_reforma482373791c8b0cda432 or /
  $this->data['ScormsSco']['identifier']       = $this->_XmlObject->organizations->organization->attributes()->identifier;  #  ITEM-eXede_reforma482373791c8b0cda433 = item identifier
  $this->data['ScormsSco']['launch']           = '';  #  index.html
  $this->data['ScormsSco']['scormtype']    = 'part';  #  sco, asset or ' '
  $this->data['ScormsSco']['title']               = $this->_XmlObject->organizations->organization->title;  #   ATutor HowTo 1.4.3 - Getting Started

  if ($this->ScormsSco->save($this->data)):
       $this->log('New SCORM - In import_manifest(), inserting item by ' .  $this->userId);
  endif;

  $sco_id       = (int)    $this->ScormsSco->getLastInsertID(); # get SCO parent id

  # Insert each item in model ScorsSco 
  $this->__insertItems($this->data['ScormsSco']['parent'], $scorm_id, $sco_id, $this->data['ScormsSco']['manifest']);
  #die('Fin');
  return True;
 }
/**
 *  Insert Items (ScormsScos) sons
 *  @param 
 *  @param $grandParent, $scorm_id, $sco_id, $organizations, $scorm_manifest
 */
private function __insertItems($grandParent, $scorm_id, $sco_id, $scorm_manifest)
{
 foreach($this->_XmlObject->organizations->organization as $org ):
      #die(pr($org));
     foreach($org->item as $item):  #parsing items 
         $this->_itemTitle   = trim($item->title);
         #die(pr($this->_itemTitle));
         $this->data['ScormsSco']['type']                   = 'item';   # this an item
         $this->data['ScormsSco']['scorm_id']      = $scorm_id;
         $this->data['ScormsSco']['manifest']      = $scorm_manifest;                              #  eXede_reforma482373791c8b0cda431
         $this->data['ScormsSco']['organization']  = $scorm_manifest;                              #  eXede_reforma482373791c8b0cda432 
         $this->data['ScormsSco']['parent']        = trim($item->attributes()->identifier);       #   item identifier="I_A001" 
         $this->data['ScormsSco']['identifier']    = trim($item->attributes()->identifier);        #  ITEM-eXede_reforma482373791c8b0cda433
         $this->data['ScormsSco']['identifierref'] = trim($item->attributes()->identifierref);
         $this->data['ScormsSco']['isvisible']     = trim($item->attributes()->isvisible);
         $this->data['ScormsSco']['title']         = trim($item->title); 
         $this->data['ScormsSco']['scormtype']     = 'item';

         /* <prerequisites> <adlcp:maxtimeallowed><adlcp:timelimitaction><adlcp:datafromlms> <adlcp:masteryscore> */
         $namespaces = $this->_XmlObject->getNameSpaces(true);
         #die(pr($namespaces));
         if ( isset($namespaces['adlcp']) ):
             $adlcp = $item->children($namespaces['adlcp']);
             $prerequisites   = (string) $adlcp->prerequisites;
             $timelimitaction = (string) $adlcp->timelimitaction;
             $dataFromLMS     = (string) $adlcp->dataFromLMS;
             $maxtimeallowed  = (string) $adlcp->maxtimeallowed;
             $masteryscore    = (string) $adlcp->masteryscore;
             $timelimitaction = (string) $adlcp->timelimitaction; 
             if ( $prerequisites ):
                 $this->data['ScormsSco']['prerequisites']   = $prerequisites;
             endif;
             if ( $dataFromLMS  ):
                 $this->data['ScormsSco']['datafromlms']     = $dataFromLMS;
             endif;
             if ( $maxtimeallowed ):
                 $this->data['ScormsSco']['maxtimeallowed']  = $maxtimeallowed;
             endif;
             if ( $masteryscore ):
                 $this->data['ScormsSco']['masteryscore']    = $masteryscore;
             endif;
             if ( $timelimitaction ):
                 $this->data['ScormsSco']['timelimitaction'] = $timelimitaction;
             endif;
         endif;
         #pr($this->data);
         $this->ScormsSco->create();
         if ($this->ScormsSco->save($this->data)):
             $this->log('New SCORM - In import_manifest(), inserting item');
         endif;
         $this->__insertResources($scorm_id, $sco_id,  $scorm_manifest, $this->data['ScormsSco']['identifierref']);
         unset($this->data['ScormsSco']);
     endforeach;
 endforeach;

 return True; 

 }
 
/**
 * Insert resources
 * @params int $scorm_
 * @params int $scorm_
 * @params int $scorm_
 */
private function __insertResources($scorm_id, $sco_id, $scorm_manifest, $identifierref) 
{ 
 $d = array();
 #die(pr($this->_itemTitle));
 #die(pr($this->_XmlObject->resources->resource));
 foreach( $this->_XmlObject->resources->resource as $re ):
     $identifier = trim($re->attributes()->identifier);
      if ( $identifierref == $identifier ):
          $scormtype = (string) $re->attributes('adlcp', True)->scormtype;
          $d['ScormsSco']['type']        = 'resource';   # this a resource
	      $d['ScormsSco']['scorm_id']    = $scorm_id;
	      $d['ScormsSco']['item_id']     = $sco_id;                            # Item parent hasMany resource relationship
	      $d['ScormsSco']['manifest']    = $scorm_manifest;                    #  eXede_reforma482373791c8b0cda431
          $d['ScormsSco']['launch']      = trim($re->attributes()->href);      #  index.html  'href' in resources, launcher
          $d['ScormsSco']['scormtype']   = $scormtype;                         #  sco or asset
          $d['ScormsSco']['title']       = $this->_itemTitle; 
          $d['ScormsSco']['identifier']  = trim($re->attributes()->identifier); 
    
          $this->ScormsSco->create();
          if ($this->ScormsSco->save($d)):
             $this->log('New SCORM - In import_manifest(), inserting item');
          endif;
          reset($d);  #reset
     endif;
 endforeach;   
 return True;    
}
/**
 *
 *
 *  @param 
 */
private function __getAttribute($index)
{
  foreach($this->_XmlObject->attributes() as $key => $value) 
  {
     $value = trim($value);
     if (  $key == $index ):
         return $value;
     endif;
  }
}

/**
 *  Insert Items (ScormsScos) sons
 *  @param 
 *  @param $grandParent, $scorm_id, $sco_id, $organizations, $scorm_manifest
 */
 public function unZip()
 {
  #die(debug($this->passedData));
  $new_dir_name  = $this->__createDir();
 }

/**
  * Create dir
  * @return string
  * @access public
  */
private function __createDir()
{ 
  $new_name = $this->__removeExtension($this->passedData['file']['name']); 
  $new_dir  = $this->_folder.$new_name;
  $this->_finalPath = APP.$new_dir;
  #die($this->_finalPath); 
  #echo getcwd() . "\n";
  if (file_exists($this->_finalPath) && is_dir($this->_finalPath)):
      $random = $this->__generateRandomString();
      $this->_finalPath = $this->_finalPath . $random;  # avoiding overwrite dir
      #die(debug($this->_finalPath)); 
  endif;
  # Extract the zip file to TMP and keep there 
  $zip = new ZipArchive;
  if ($zip->open($this->passedData['file']['tmp_name']) === TRUE):
    $zip->extractTo($this->_finalPath);
    $zip->close();
  endif;
  #die($this->_finalPath);
  return True;
}

/**
 *  random string
 *  @param 
 *  @param $grandParent, $scorm_id, $sco_id, $organizations, $scorm_manifest
 */
private function __generateRandomString($length = 6) 
{
   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $randomString = '';
   for ($i = 0; $i < $length; $i++) 
   {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
   }
   return $randomString;
}

/**
 * getScorms -- Return scorms owned by teacher and not already linked to the vclassroom (used in popup window)
 * @param integer $user_id
 * @param integer $vclassroom_id
 * @return array  list scomnrs already linked to vclassroom
 */
 public function getScorms($user_id, $vclassroom_id)
 {
   $params = array('conditions'   => array('Scorm.user_id'=>$user_id),
                   'fields'       => array('Scorm.id', 'Scorm.name'),
                   'contain'      => False,
                   'order'        => 'Scorm.name');
   $scorms        = $this->find('all', $params);
   #die(debug($scorms));
   foreach ($scorms as $k =>$t):
       $params = array('conditions' => array('ScormVclassroom.scorm_id' => $t['Scorm']['id'],'ScormVclassroom.vclassroom_id'=>$vclassroom_id),
                       'fields     '=> array('ScormVclassroom.scorm_id'));
       $assigned = $this->ScormVclassroom->find('first', $params);
       if ( $assigned ): # SCORM is already assigned to this Vclassroom, so unset
           unset($scorms[$k]);
       endif; 
   endforeach;

  return $scorms;
 }

/**
  * Remove extension
  * @return string
  * @access private
  * @param string
  */
 private function __removeExtension($strName)
 {
   $ext = strrchr($strName, '.');
   
   if ($ext !== false):
       $strName = substr($strName, 0, -strlen($ext));
       $strName = str_replace(" ","_",$strName);
   endif;
   return strtolower($strName);
  } 

/**
 * getScorms -- Return scorms owned by teacher and not already linked to the vclassroom (used in popup window)
 * @param integer $user_id
 * @param integer $vclassroom_id
 * @return array  list scomnrs already linked to vclassroom
 */
 public function getResults($user_id, $vclassroom_id)
 {
  $params = array('conditions' => array('ResultScorm.vclassroom_id'=>$vclassroom_id, 'ResultScorm.user_id'=>$user_id),
                  'fields'     => array('ResultScorm.scorm_id'));
  $data  = $this->ResultScorm->find('all', $params);
  $vclassrooms = array_map("unserialize", array_unique(array_map("serialize", $data)));
  
  #die(debug($vclassrooms));
  $conditions = array('user_id'=>$user_id, 'vclassroom_id'=>$vclassroom_id);
  $tmp = array();
  foreach($vclassrooms as $k=>$vc):
      $tmp[$k]['name']           = $this->field('name', array('id'=>$vc['ResultScorm']['scorm_id']));
      $tmp[$k]['id']              = $vc['ResultScorm']['scorm_id'];
      $tmp[$k]['points']          = $this->ResultScorm->getPoints($user_id, $vclassroom_id, $vc['ResultScorm']['scorm_id']);
      $conditions['varname']      = 'lesson_location';
      $tmp[$k]['lesson_location'] = $this->ResultScorm->field('varvalue', $conditions); 
      $conditions['varname']      = 'lesson_status';
      $tmp[$k]['lesson_status']   = $this->ResultScorm->field('varvalue', $conditions);
      $conditions['varname']      = 'lesson_mode';
      $tmp[$k]['lesson_mode']     = $this->ResultScorm->field('varvalue', $conditions);
      $conditions['varname']      = 'entry';
      $tmp[$k]['entry']           = $this->ResultScorm->field('varvalue', $conditions);
      $conditions['varname']      = 'raw';
      $tmp[$k]['raw']             = $this->ResultScorm->field('varvalue', $conditions);
      $conditions['varname']      = 'credit';
      $tmp[$k]['credit']          = $this->ResultScorm->field('varvalue', $conditions);
      $conditions['varname']      = 'mastery_score';
      $tmp[$k]['mastery_score']   = $this->ResultScorm->field('varvalue', $conditions); 
      $conditions['varname']      = 'total_time';
      $tmp[$k]['total_time']      = $this->ResultScorm->field('varvalue', $conditions);  
      $conditions['varname']      = 'session_time';
      $tmp[$k]['session_time']    = $this->ResultScorm->field('varvalue', $conditions);
      $conditions['varname']      = 'suspend_data';
      $tmp[$k]['suspend_data']    = $this->ResultScorm->field('varvalue', $conditions);
      $conditions['varname']      = 'scoreMin';
      $tmp[$k]['scoreMin']        = $this->ResultScorm->field('varvalue', $conditions); 
      $conditions['varname']      = 'scoreMax';
      $tmp[$k]['scoreMax']        = $this->ResultScorm->field('varvalue', $conditions);
  endforeach;
  #die(debug( $tmp));
  return $tmp;
 } 

 /**
  * Delete a file, or a folder and its contents (recursive algorithm)
  *
  * @author      Aidan Lister <aidan@php.net>
  * @version     1.0.3
  * @link        http://aidanlister.com/repos/v/function.rmdirr.php
  * @param       string   $dirname    Directory to delete
  * @access      private
  * @return      bool     Returns TRUE on success, FALSE on failure
  */
 private function __rmdirr($dirname) 
 {
  # Sanity check
  if (!file_exists($dirname)):
      return False;
  endif;

  # Simple delete for a file
  if (is_file($dirname) || is_link($dirname)):
      return unlink($dirname);
  endif;

  # Loop through the folder
  $dir = dir($dirname);
  while (false !== $entry = $dir->read()) 
  {
      # Skip pointers
      if ($entry == '.' || $entry == '..'):
         continue;
      endif;
      # Recurse
      rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
  }
  # Clean up
  $dir->close();
  return rmdir($dirname);
 }
}

# ? > EOF

