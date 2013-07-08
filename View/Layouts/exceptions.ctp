<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>You broke Karamelo!</title>
<?php echo $this->Html->charset(); ?> 
<style><!--
 body{ background-color:#e72b2b;}
 P { text-align:center; font:bold 1.0em sans-serif }
.title{color:red;padding:4px;background-color:#fff;font-size:18pt;}
 h3{text-align:center;}
 A { color:#444; text-decoration:none }
 A:HOVER { text-decoration: underline; color:#44E }
 .logo{text-align:center;}
.container{width:90%; background-color:#fff;margin:auto;border:4px solid gray;display:block;padding:8px;}
 --></style>
</head>
<body>
<?php 
 echo $this->Html->div('container', Null);
 echo $this->Html->div('title',__('You broke Karamelo!') .' ;-)'); 
 echo $this->Html->div('logo', $this->Html->image('static/youbroke.jpg', array('alt'=>'Broken', 'title'=>'Broke')));
 echo $this->Html->para(Null,$content_for_layout); 
?> 
</div>
</body>
</html>