<?php 

include_once "getID3/getid3.php";

class CMP3File {
    /**
     * Array to return values
     *
     * @var array
     */
    public $info = array();
    
	  
    /**
     * getid3
     * Returns a value from the multimedia file values.
     *
     * @param string $file
     * @return array $info
     */
     
public function getid3($file) {
// Initialize getID3 engine
	if (file_exists($file))
	{ //after verifying the file exists,
		$getID3 = new getID3;
   
	 // Analyze file and store returned data in $ThisFileInfo
   $ThisFileInfo = $getID3->analyze($file);
   
   //print_r($ThisFileInfo);
   
   //die("filesize is " . $ThisFileInfo['filesize']);
	 // Optional: copies data from all subarrays of [tags] into [comments] so
	 // metadata is all available in one location for all tag formats
	 // metainformation is always available under [tags] even if this is not called
	 getid3_lib::CopyTagsToComments($ThisFileInfo);
   
	 // Output desired information in whatever format you want
	 // Note: all entries in [comments] or [tags] are arrays of strings
	 // See structure.txt for information on what information is available where
	 // or check out the output of /demos/demo.browse.php for a particular file
	 // to see the full detail of what information is returned where in the array
	 //echo @$ThisFileInfo['comments']['artist'][0]; // artist from any/all available tag formats
    
	  $mim = @$ThisFileInfo['mime_type']; // artist from any/all available tag formats
    
	  $dur = @$ThisFileInfo['playtime_string']; // play duration from any/all available tag formats
    
	  switch (strrchr(strtolower($file), "."))
	  { 
		case ".mp3";
			$tit = @$ThisFileInfo['id3v2']['comments']['title'][0]; // artist from any/all available tag formats
			$alb = @$ThisFileInfo['id3v2']['comments']['album'][0]; // artist from any/all available tag formats
			$art = @$ThisFileInfo['id3v2']['comments']['artist'][0]; // artist from any/all available tag formats
			$iom = @$ThisFileInfo['id3v2']['comments']['comment'][3]; // artist from any/all available tag formats
			$imp = @$ThisFileInfo['id3v2']['comments']['composer'][0]; // artist from any/all available tag formats
			$gen = @$ThisFileInfo['id3v2']['comments']['genre'][0]; // artist from any/all available tag formats
			break;
		case ".m4a";
			$tit = @$ThisFileInfo['quicktime']['comments']['title'][0]; // artist from any/all available tag formats
			$alb = @$ThisFileInfo['quicktime']['comments']['album'][0]; // artist from any/all available tag formats
			$art = @$ThisFileInfo['quicktime']['comments']['artist'][0]; // artist from any/all available tag formats
			$iom = @$ThisFileInfo['quicktime']['comments']['comment'][0]; // artist from any/all available tag formats
			$imp = @$ThisFileInfo['quicktime']['comments']['writer'][0]; // artist from any/all available tag formats
			//	$gen = @$ThisFileInfo['quicktime']['comments']['genre'][0]; // artist from any/all available tag formats
			break;
		case ".m4b";
			$tit = @$ThisFileInfo['quicktime']['comments']['title'][0]; // artist from any/all available tag formats
			$alb = @$ThisFileInfo['quicktime']['comments']['album'][0]; // artist from any/all available tag formats
			$art = @$ThisFileInfo['quicktime']['comments']['artist'][0]; // artist from any/all available tag formats
			$iom = @$ThisFileInfo['quicktime']['comments']['comment'][0]; // artist from any/all available tag formats
			$imp = @$ThisFileInfo['quicktime']['comments']['writer'][0]; // artist from any/all available tag formats
			//	$gen = @$ThisFileInfo['quicktime']['comments']['genre'][0]; // artist from any/all available tag formats
			break;
		case ".mov";
			$tit = @$ThisFileInfo['quicktime']['comments']['title'][0]; // artist from any/all available tag formats
			$alb = @$ThisFileInfo['quicktime']['comments']['album'][0]; // artist from any/all available tag formats
			$art = @$ThisFileInfo['quicktime']['comments']['artist'][0]; // artist from any/all available tag formats
			$iom = @$ThisFileInfo['quicktime']['comments']['comment'][0]; // artist from any/all available tag formats
			$imp = @$ThisFileInfo['quicktime']['comments']['director'][0]; // artist from any/all available tag formats
			//	$gen = @$ThisFileInfo['quicktime']['comments']['genre'][0]; // artist from any/all available tag formats
			break;
		case ".asf";
			$tit = @$ThisFileInfo['asf']['comments']['title'][0]; // artist from any/all available tag formats
			$alb = @$ThisFileInfo['asf']['comments']['album'][0]; // artist from any/all available tag formats
			$art = @$ThisFileInfo['asf']['comments']['artist'][0]; // artist from any/all available tag formats
			$iom = @$ThisFileInfo['asf']['comments']['comment'][0]; // artist from any/all available tag formats
			$imp = @$ThisFileInfo['asf']['comments']['composer'][0]; // artist from any/all available tag formats
			$gen = @$ThisFileInfo['asf']['comments']['genre'][0]; // artist from any/all available tag formats
			break;
		case ".wma";
			$tit = @$ThisFileInfo['asf']['comments']['title'][0]; // artist from any/all available tag formats
			$alb = @$ThisFileInfo['asf']['comments']['album'][0]; // artist from any/all available tag formats
			$art = @$ThisFileInfo['asf']['comments']['artist'][0]; // artist from any/all available tag formats
			$iom = @$ThisFileInfo['asf']['comments']['comment'][0]; // artist from any/all available tag formats
			$imp = @$ThisFileInfo['asf']['comments']['composer'][0]; // artist from any/all available tag formats
			$gen = @$ThisFileInfo['asf']['comments']['genre'][0]; // artist from any/all available tag formats
			break;
		default;
			$tit = $file; // artist from any/all available tag formats
	}
    $this->info['size'] 		= $ThisFileInfo['filesize'];
	$this->info['title'] 		= $this->escChars($this->stripJunk($tit));
	$this->info['composer']     = $this->escChars($this->stripJunk($imp));
	$this->info['album'] 		= $this->escChars($this->stripJunk($alb));
	$this->info['comment'] 		= $this->escChars($this->stripJunk($iom));
	$this->info['copyright'] 	= $this->escChars($this->stripJunk($imp));
	$this->info['artist'] 		= $this->escChars($this->stripJunk($art));
	$this->info['mime_type'] 	= $this->escChars($this->stripJunk($mim));
	$this->info['duration'] 	= $this->escChars($this->stripJunk($dur));
  
	return $this->info;
  } 
  else 
  {
	 return false; // file doesn't exist
	}
}

// Strip weird characters
private function stripJunk($text) {
    
   $outText = "";
  // Strip non-text characters
	for ($i=0; $i < strlen($text); $i++) {
      
    if ( ord($text[$i]) >= 32 AND ord($text[$i]) <= 122)   // php.net said: ord = Return ASCII value of character
    {
			$outText .= $text[$i];
    }
	}
	return $outText;
}

//html characters
private function escChars($text) {
// Strip non-text characters
	$fixed   = str_replace("&","&amp;", $text);   // ampersand
	$fixed   = str_replace("<","&lt;",$fixed);	// less than
	$fixed   = str_replace("©","&#169;",$fixed);	// copyright
	$fixed   = str_replace("'","&apos;",$fixed);	// apostrophe
	$fixed   = str_replace("\"","&quot;",$fixed);	// double quotes
	$outText = str_replace(">","&gt;",$fixed);	// greater than
	return $outText;
}
}
?>
