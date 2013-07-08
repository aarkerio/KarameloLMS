<?php 
#debug($data); 
echo $this->Html->addCrumb('Control Panel', '/admin/entries/start');
echo $this->Html->getCrumbs(' > ');

echo $this->Html->div('title_section', $this->Html->image('admin.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('College'), 'title'=>__('College'))).' '.__('College information')
); 
echo $this->Html->link($this->Html->image('static/edit_icon.gif',array('alt'=>__('Edit'),'title'=>__('Edit'))),'/admin/colleges/edit/',array('escape'=>False)).'  '; 

echo $this->Html->link($this->Html->image('static/icon_logged.png', array('style'=>'width:18px;','alt'=>__('Access log'), 'title'=>__('Access log'))), 
'/admin/colleges/record/', array('escape'=>False)) .'  '; 

$msg = __('Publish activities in Google calendar');
echo $this->Html->link($this->Html->image('static/icon-gcalendar.png', array('style'=>'width:18px;', 'alt'=>'gCalendar', 'title'=>'gCalendar', 'onmouseover'=>"Tip('$msg')", 'onmouseout'=>"UnTip()")), '#', array('onclick'=>"window.open('http://www.google.com/calendar/render', '_blank','toolbar=no, scrollbars=yes,width=800,height=800'); return false;", 'escape'=>False));

$status = strlen($data['College']['sp']) > 4 ? __('Enabled') :  __('Not activated');
?>
<dl>
  <dt><?php echo $this->Html->image('static/'.$data['College']['logo'], array('alt'=>$data['College']['name'],'title'=> $data['College']['name'])) ;?></dt>
  <dt><b><?php __('Name'); ?></b></b></dt>
  <dd>&nbsp;<?php echo $data['College']['name'];?></dd>
  <dt><b><?php __('Description'); ?></b></dt>
  <dd>&nbsp;<?php echo $data['College']['description'];?></dd>
  <dt><b>Email</b></dt>
  <dd>&nbsp;<?php echo $data['College']['email'];?></dd>
  <dt><b>Twitter</b></dt>
  <dd>&nbsp;<?php echo $data['College']['twitter'];?></dd>
  <dt><b>Gcalendar</b></dt>
  <dd>&nbsp;<?php echo $data['College']['gcalendar_id'];?></dd>
  <dt><b><?php __('School Parents'); ?></b></dt>
  <dd>&nbsp;<?php echo $status;?></dd>
  <?php
    if ( strlen($data['College']['sp']) > 4 ):
	    echo '<dd>'.$this->Html->link($data['College']['sp'], '/blog/'.$data['College']['sp']).'</dd>';
    endif;
  ?>
</dl>
