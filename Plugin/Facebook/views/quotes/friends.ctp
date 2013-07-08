<script src="http://static.ak.facebook.com/js/api_lib/v0.4/XdCommReceiver.js?2" type="text/javascript"></script>
<script type="text/javascript">FB.init("adf90e83cf888c7a1504b757fc554a63","/xd_receiver.html",{"forceBrowserPopupForLogin":true});</script>
<script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script>
<script type="text/javascript">window.onload = function() { facebook_onload(false); };</script>
<?php
#die(debug($data));

 // Greet the currently logged-in user!
  echo "<p>Hello, <fb:name uid=\"$user_id\" useyou=\"false\" />!</p>";

  // Print out at most 25 of the logged-in user's friends,
  // using the friends.get API method
  echo "<p>Friends:";

  foreach ($friends as $friend):
      echo "<p>Hello, <fb:name uid=\"$friend\" useyou=\"false\" />! <fb:profile-pic uid=\"$friend\" />";
      echo "<fb:user-status uid=\"$friend\" useyou=\"false\" /></p>";
  endforeach;
  echo "</p>";
  echo $html->link('Karamelo', 'http://trac.chipotle-software.com/karamelo/');
?>

<fb:login-button class="fb_login_not_authorized FB_ElementReady" size="medium" background="light" length="long" onlogin="facebook_onlogin_ready();"><a id="RES_ID_fb_login" class="fbconnect_login_button"><img alt="Connect" src="http://b.static.ak.fbcdn.net/rsrc.php/z3W9M/hash/5naudvb1.gif" id="fb_login_image"></a></fb:login-button>
sdfsdfdsf