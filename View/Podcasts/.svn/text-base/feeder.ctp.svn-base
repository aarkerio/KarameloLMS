<?php
// dircaster specific variables
$maxFeeds   ="100";
$sftypes    ="(.mp3)";
$id3LibPath ="../vendors/getid3/getid3.php";
$audioPath  = "../";

// RSS general tags
$titleTAG           = "Your Channel Title";
$descriptionTAG     = "Your Description";
$linkTAG            = "http://www.yourdomain.com";
$copyrightTAG       = "© 2005 by you";
$languageTAG        = "en-us";

$webMasterTAG       = "you@yourdomain.com";
$generatorTAG       = "Karamelo";
$ttlTAG             = "60";
$rssPodcastUrlTAG   = "http://www.yourdomain.com/your_image.jpg";
$rssPodcastTitleTAG = "Your Podcast Title";
$rssPodcastLinkTAG  = "http://www.your_image_ling.com";

// iTunes specific tags
$nameSpaceTAG   = "http://www.itunes.com/DTDs/Podcast-1.0.dtd";
$explicitTAG    = "no";
$summaryTAG     = "Your iTunes channel summary";
$authorTAG      = "Main iTunes author";
$ownerNameTAG   = "iTunes contact name";
$ownerEmailTAG  = "iTunes_contact@yourdomain.com";
$topCategoryTAG = "iTunes specific category (see below)";
$subCategoryTAG = "iTunes specific sub-category (see below)";
$keywordTAG     = "key word list (for all audio files)";
$imageUrlTAG    = "http://www.yourdomain.com/images/myimage.jpg";
$imageTitleTAG  = "Podcast title";
$imageLinkTAG   = "http://www.yourdomain.com";
$imageItemTAG   = "no";

//
// end of dircaster variables.
//
/* Do not edit anything below this line! **********************/
/* Main Code **************************************************/
// dirCaster 0.4e, released 07/23/2005. Open source code but please
// leave all references to prior work intact when making changes.
// based on dircaster 0.4 by Ryan King (http://www.shadydentist.com)
// ID3v2.x tag support added by Warren Stone <fasttr@gmail.com> and
// utilizing getid3 library by James Heinrich <info@getid3.org>, 
// http://www.getid3.org. iTunes specific tag support by Warren Stone
//
// need to include the code to read id3 tags
// also reads lots of different formats
// we'll implement mp3, mpa (quicktime), asf (wma) and riff (wav/avi)
// alter the path to your getid3 directory location
//require_once($id3LibPath);
// lets make all of the user set variables xml compliant just in case


// path manipulations
$rootMP3URL = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$rootMP3URL =  substr($rootMP3URL, 0, strrpos ($rootMP3URL, "/")); // Trim off script name itself

// add a slash to the audio path if it's not set to the current directory
if ($audioPath != "./") 
{
    $audioPath = $audioPath . "/";
}
// let's remove the "dot" and any double slashes that might occur
$filePath = '../../webroot/files/podcasts/';

$channel  = "<channel>\n";
// original dircaster channel info
$channel .= "		<path>$filePath</path>\n";
$channel .= "		<audiopath>$audioPath</audiopath>\n";
$channel .= "		<title>$titleTAG</title>\n";
$channel .= "		<link>$linkTAG</link>\n";
$channel .= "		<description>$descriptionTAG</description>\n";
$channel .= "		<category>$topCategoryTAG</category>\n";
$channel .= "		<pubDate>" . date("r") ."</pubDate>\n";
$channel .= "		<lastBuildDate>" . date("r") ."</lastBuildDate>\n";
$channel .= "		<language>$languageTAG</language>\n";
$channel .= "		<copyright>$copyrightTAG</copyright>\n";
$channel .= "		<generator>$generatorTAG</generator>\n";
$channel .= "		<managingEditor>$ownerEmailTAG ($ownerNameTAG)</managingEditor>\n";
$channel .= "		<webMaster>$webMasterTAG</webMaster>\n";
$channel .= "		<ttl>$ttlTAG</ttl>\n\n";
// new itunes channel stuff
// itunes author tag
$channel .= "      <itunes:author>$authorTAG</itunes:author>\n";
// itune subtitle tag
$channel .= "      <itunes:subtitle>$descriptionTAG</itunes:subtitle>\n";
// itunes category tags
$channel .= "      <itunes:category text=\"".$topCategoryTAG."\">\n";
$channel .= "			<itunes:category text=\"".$subCategoryTAG."\"/>\n";
$channel .= "		</itunes:category>\n";
// itunes summary tag
$channel .= "      <itunes:summary>$summaryTAG</itunes:summary>\n";
// itunes owner tags
$channel .= "      <itunes:owner>\n";
$channel .= "      <itunes:name>$ownerNameTAG</itunes:name>\n";
$channel .= "      <itunes:email>$ownerEmailTAG</itunes:email>\n";
$channel .= "      </itunes:owner>\n";
// itunes explicit tag
$channel .= "      <itunes:explicit>$explicitTAG</itunes:explicit>\n";
// image tags
$channel .= "		<image>\n";
$channel .= "			<url>".$rssPodcastUrlTAG."</url>\n";
$channel .= "			<title>".$rssPodcastTitleTAG."</title>\n";
$channel .= "			<link>".$rssPodcastLinkTAG."</link>\n";
$channel .= "		</image>\n";
// itunes image link
$channel .= "		<itunes:image href=\"$imageUrlTAG\" />\n";

// items, the trick begins
foreach ($data as $key => $val) {
    
    $channel .= "<item>\n";
	// title tag
    
	$channel .= "<title>".$data[$key]['Podcast']['title']."</title>\n"; // title string
	// note filename returns with the audio path as a prefix
	$url = $rootMP3URL."/". htmlentities(str_replace(" ", "%20", $filename));
	$channel .= "<link>".$linkTAG."</link>\n"; //link string
	// artist
	$channel  .= "<author>$ownerEmailTAG</author>\n";
	$channel  .= "<itunes:album>".$data[$key]['Podcast']['title']."</itunes:album>\n";
	$channel  .= "<description>".$data[$key]['Podcast']['description']."</description>\n";
	$channel  .= "<pubDate>".$data[$key]['Podcast']['created']."</pubDate>\n";
	$channel  .= "<enclosure url=\"".$url."\" length=\"".$data[$key]['Podcast']['length']."\" type=\"".$data[$key]['Podcast']['mime']."\"/>\n";
	$channel  .= "<itunes:author>$artist</itunes:author>\n";
	$channel  .= "<itunes:subtitle>$mp3file->comment</itunes:subtitle>\n";
	$channel  .= "<itunes:keywords>$keywordTAG</itunes:keywords>\n";
    
    // check to see if we want image info for each item
	if ($imageItemTAG == "yes") 
    {
	   $channel  .= "<itunes:image href=\"$imageUrlTAG\" />\n";
    }
	
	$channel .= "<itunes:duration>".$data[$key]['Podcast']['duration']."</itunes:duration>\n";
		
	$channel .= "</item>\n\n";
	
}

echo $channel;

?>
