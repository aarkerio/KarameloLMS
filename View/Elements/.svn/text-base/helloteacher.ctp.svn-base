<?php
  echo $this->Html->div(null, null, array('style'=>'width:500px;margin:15px;padding:4px;border:1px solid #7b98ba;'));
  echo __('Hey! you are teacher and this is your virtual classroom. You are seeing this vClassroom as your students do, you can even participate as other student because learning never ends, right? enjoy ;-)');
   echo '<br />';
   $alt = __('Acces Code').': '.$code;
   echo $this->Html->image('static/icon_password.gif', array('alt'=>$alt, 'title'=>$alt)) .'   ';
   $img= $this->Html->image('static/icon_community.png', array('alt'=>__('Join our teacher community'), 
               'title'=>__('Join our teacher community'))) .'   ';
   echo $this->Html->link($img, 'http://community.chipotle-software.com/', array('target'=>'_blank','escape'=>False));
   $img = $this->Html->image('static/icon_close.gif', array('alt'=>__('Hide this message'), 'title'=>__('Hide this message')));
   echo $this->Html->link($img, '/admin/vclassrooms/hide/'.$vclassroom_id.'/'.$username, array('escape'=>False));

   echo '</div>';
# 