<?php
 echo '<?xml version="1.0"?>';
 echo $this->Html->docType();
 echo '<head>';
 echo $this->Html->charset();
 echo $this->Html->meta('favicon.ico','/favicon.ico', array('type' => 'icon'));
 echo '<title>'.$title_for_layout .'</title>';

 if (Configure::read() == 0): 
?>
  <meta http-equiv="Refresh" content="<?php echo $pause?>;url=<?php echo $url?>"/>
<?php endif; ?>
<style><!--
 body{background-color:#177477;}
 P { text-align:center; font:bold 1.1em sans-serif }
 h1{color:green;padding:4px;border:1px dotted orange;background-color:#c0c0c0;}
 A { color:#444; text-decoration:none }
 A:HOVER { text-decoration: underline; color:#44E }
 .logo{text-align:center; margin:19px auto;}
 .wrapper{margin:10px auto;padding:25px;border:1px solid gray;width:40%;background-color:#fff;}
 --></style>
</head>
<body>
<?php
echo $this->Html->div('wrapper');
echo $this->Html->div('logo', $this->Html->image('static/karamelo_logo.png', array('alt'=>'Karamelo', 'title'=>'Karamelo')));
echo $this->Html->para(Null, $this->Html->link($message, $url)); 
?>
</div>
</body>
</html>