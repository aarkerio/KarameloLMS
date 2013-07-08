<?php 
 if ( isset($message) ):
     $msg = $message;
 else:
     $msg = 'Thanks!';
 endif;
 echo '<h1>Karamelo e-Learning Platform</h1>';
 echo $this->Html->div(Null,  date('l jS \of F Y h:i:s A'));
 echo $this->Html->para(Null, $msg);
 echo $this->Html->para(Null, $this->Html->link(__('Go to vClassroom'),  'http://'.$_SERVER['HTTP_HOST'].$url));
 echo $this->Html->div(Null,  __('Thank you for your attention'));
# ? > EOF
