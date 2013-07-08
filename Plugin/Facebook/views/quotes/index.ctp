<?php
#$user_id = $facebook->require_login();

//initialize an array of quotes
$quotes= array("Only those who dare to fail greatly can ever achieve greatly.", 
               "Take my wife. Please!", 
               "I believe what doesn't kill you only makes you... STRANGER");

//Select a Random one.
$i= rand(0, sizeof($quotes)-1);

//prepare string for profile box
$text= ('
<style type="text/css">
 h1{ margin: 10px; font-size: 24pt; }
 h2{ margin: 15px; font-size: 20pt; }
</style>
');

$text.=('<h2>'. $quotes[$i] .'</h2>');

//set profile text
$facebook->api_client->profile_setFBML($text, $user_id);

//Select a Random one.
$i= rand(0, sizeof($quotes)-1);

//print the CSS
print ('
<style type="text/css">
 h1{ margin: 10px; font-size: 24pt; }
 h2{ margin: 15px; font-size: 20pt; }
</style>
');

print "<h1>Chidas Frases Quotes</h1>";
print "<h2>". $quotes[$i] ."</h2>";

?>