------------------------------
   Welcome Budy !
-----------------------------
<?php 

echo 'Karamelo ' . __('Confirmation email') . " \n";

echo __('Copy and paste this URL in your browser to confirm your Karamelo account'). "\n";

echo 'http://'.$_SERVER['HTTP_HOST'] .'/confirms/signup/'. $message."\n";

echo __('Thank you for your attention'). "\n";

# ? > EOF

