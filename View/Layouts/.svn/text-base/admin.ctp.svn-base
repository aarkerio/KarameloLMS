<?php
echo '<?xml version="1.0"?>';
echo $this->Html->docType();
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Karamelo::cPanel</title>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<?php 
echo $this->Html->css(array('cpanel/cpanel'));
echo $this->Html->charset('UTF-8');
echo $this->Html->script(array('jquery-min', 'admin', 'jquery-ui'));
echo '</head><body>';
echo $this->Html->script('tooltip/wz_tooltip');
echo $this->Session->flash();  # admin messages
?> 
<div id="header">
<div style="width:300px;float:left;margin-right:15px;">
<?php 
echo $this->Html->link($this->Html->image('admin/klogo.png', array('alt'=>'Karamelo', 'style'=>'width:100px;border:0;')), '/admin/entries/start', array('escape'=>False));
echo $this->Html->para(Null, 'Web 2.0 eLearning platform'); 
?>
</div>
<div style="width:700px;float:left;"> 
<?php __('logged_in'); ?> <strong><?php echo $this->Session->read('Auth.User.username'); ?></strong> |
<?php  
  echo $this->Html->link($this->Session->read('Auth.User.username') . '\'s blog',  '/blog/'. $this->Session->read('Auth.User.username')) . ' | '; 
  echo $this->Html->link($_SERVER['HTTP_HOST'], '/').' | ';
  echo $this->Html->link(__('My profile'), '/admin/users/edit') .' | '. $this->Html->link(__('Logout'), '/users/logout'); 
?>
</div>
</div><!-- header ends-->
<?php 
echo $this->element('admin_menu');
echo $this->Html->div('content_for_layout', $content_for_layout);
echo $this->Html->div(Null, '<!-- clear -->',array('style'=>'clear:both;'));
echo $this->Html->div('footer', $this->Html->link('Chipotle Software &copy; 2006-2012 AGPLv3', 'http://www.chipotle-software.com/', array('escape'=>False)));
echo $this->Html->div('help_top', $this->element('window_help'));
?>
<script type="text/javascript">
 jQuery(document).ready(function(){
         timedMsg();
	});
</script>
<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>