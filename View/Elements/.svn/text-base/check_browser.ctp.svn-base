<?php
$browser = $_SERVER['HTTP_USER_AGENT'];
#echo $browser;
#running internet explorer
if ($msie = strpos($browser, 'MSIE')):
   #version number
   $ver = substr($browser, $msie + 5, 3);
   if ($ver < 7.0):
            echo    'Welcome!<br /><br />It appears you\'re using Microsoft Internet Explorer '.$ver.'.
                     <br />Since Microsoft does not wish to fix this ancient and bug-ridden browser, this site has refused to support it.<br /><br />
                     Before you can proceed to this site you will need to upgrade to a modern browser, such as FireFox or Internet Explorer 7.';
  endif;
endif;
?>