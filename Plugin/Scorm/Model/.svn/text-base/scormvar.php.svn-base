<?php
/**
*  Karamelo e-Learning Platform
*  GPLv3
*  @copyright Copyright 2006-2011, Chipotle Software(c)
*  @version 0.7
*  @package Excercises
*  @license http://www.gnu.org/licenses/gpl-3.0.html
*/
# file: APP/Plugin/Scorms/Model/Scormvar.php

class Scormvar extends ScormAppModel {

  public  $belongsTo = array('User' =>
			 array('className'  => 'User',
			       'conditions' => '',
			       'order'      => '',
                   'foreignKey' => 'user_id',
                   'fields'     => 'id, username'
			       )
			 );   
}
 /*
 function readElement($varName, $id)
 {
	$result = $this->query("select varvalue from Scormvars where ((id=".$id.") and (varname='$varName'))");
	return $result[0][0]['varvalue'];		
 }

 function writeElement($varName,$varValue, $id)
 {

        $this->query("delete from Scormvars where ((id=".$id.") and (varname='$varName'))");
	$this->query("insert into Scormvars (id,varName,varValue) values (".$id.",'$varName','$varValue')");
	return;

 }
 function initializeElement($varName,$varValue, $id)
 {
	$result=$this->query("select varValue from Scormvars where ((id=".$id.") and (varName='$varName'))");
	if (empty($result)):
		$this->query("insert into Scormvars (id,varName,varValue) values (".$id.",'$varName','$varValue')");
	endif;
	return;
 } */

# ? > EOF

