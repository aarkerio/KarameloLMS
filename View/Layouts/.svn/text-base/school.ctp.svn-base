<?php
 echo '<?xml version="1.0"?>';
 echo $this->Html->docType();
 echo '<head>';
 echo $this->Html->charset();
 echo $this->Html->meta('favicon.ico','/favicon.ico', array('type' => 'icon'));
 echo $this->Html->meta('Blog Entries RSS 2.0', '/entries/rss/'.$blogger['username'].'.rss', array('type' => 'rss'));
 echo $this->Html->meta('keywords',  'enter any meta keyword here',  array(), False);
 echo $this->Html->meta('description', 'enter any meta description here',array(), False);
 echo '<title>'.$title_for_layout .'</title>';
 echo $this->Html->css('school/styles');
 if ( isset($js) ):
     echo $this->Html->charset('UTF-8');
     echo $this->Html->script(array('jquery-min', 'myfunctions'));
 endif;
?>
<script type="text/javascript">
     window.onload = timedMsg;
</script>
</head>
<body>
<?php echo $this->Session->flash();  # print little messages after someone do some action. see the css definitions ?> 
<!-- Begin Wrapper -->
<div id="wrapper">
<!-- Begin Header -->
<div id="header">
<h1>
<?php 
 echo $this->Html->link($blogger['name_blog'], '/blog/'.$blogger['username'], array('title'=>$blogger['name_blog'])); 
?>
</h1> 
<?php echo $this->Html->div('quote', ''.$blogger['quote']); ?>
</div>
<!-- End Header -->
<!-- Begin Navigation -->
<div id="navigation">
<ul id="menu_nav">
<?php 
 echo '<li>'.$this->Html->link('eduBlog',   '/blog/'.$blogger['username']) .'</li>'; 
 echo '<li>'.$this->Html->link('ePortfolio', '/users/portfolio/'.$blogger['username']).'</li>'; 
 echo '<li>'.$this->Html->link('About me',  '/vclassrooms/aboutme/'.$blogger['username']).'</li>';
 echo '<li>'.$this->Html->link('Contact',   '/messages/message/'.$blogger['username']).'</li>';
?>
</ul>
</div>
<!-- End Navigation --> 
<!-- Begin Faux Columns -->
<div id="faux"> 
<!-- Begin Left Column -->
<div id="leftcolumn">
<?php
 if ( isset($blogger['Quote'][0]['quote']) ):
     echo '<i>'.$blogger['Quote'][0]['quote'] . '</i><br /><b>'. $blogger['Quote'][0]['author'].'</b>';
 endif;
?>
<?php e($content_for_layout); ?>

 <div class="clear"></div>
 </div>
 <!-- End Left Column -->

 <!-- Begin Right Column -->
 <div id="rightcolumn">
 <!-- RSS feeds --> 
<strong>RSS:</strong> 
<?php
 echo $this->Html->link('Blog', '/entries/rss/'.$blogger['username'] . '.rss', array('class'=>'smallinks')). ' / '; 
 echo $this->Html->link('Podcast', '/podcasts/rss/'.$blogger['username'].'.rss', array('class'=>'smallinks'));

 echo $this->element('vclassrooms');  

 echo $this->Html->para(null,$this->Html->link($this->Html->image('static/ooo_banner.png', array('alt'=>'OpenOffice.org')), 'http://extensions.services.openoffice.org/',  array('escape'=>False)));

 echo $this->Html->div('temas', $blogger['username'] . ' profile'); 
 echo $this->Html->para('cv', $blogger['cv']);
 echo $this->Html->para(null,$this->Html->image('avatars/'.$blogger['avatar'], array("alt"=>$blogger['username'], "title"=>$blogger['username'])), array('style'=>'text-align:center'));

 echo $this->element('college'); 	
 echo $this->element('lesson', $blogger);  
 echo $this->element('podcast', $blogger);  
 echo $this->element('catfaqs', $blogger);  
 echo $this->element('acquaintances', $blogger);         

 if ( !$this->Session->check('Auth.User') ):
      echo $this->Html->para(Null, $this->Html->link($this->Html->image('static/login.png', array('alt'=>'Login', 'title'=>'Login')), 
                           '/users/login', array('escape'=>False)), array('style'=>'text-align:center;margin:35px 0 35px 0')); 
 endif; 
 	 
 echo $this->Html->div('temas', 'Powered by');
 echo $this->Html->div(null, $this->Html->link($this->Html->image('banners/banner_karamelo.jpg', array('style'=>'border:1px solid black','alt'=>'Karamelo', 'title'=>'Karamelo')), 
'http://www.chipotle-software.com', array('escape'=>False)), array('style'=>'text-align:center;padding-top:15px'));
?>
  <div class="clear"></div>  
 </div>
 <!-- End Right Column --> 
 </div>   
 <!-- End Faux Columns --> 
 <!-- Begin Footer -->
 <div id="footer">
    <?php echo $this->element('footer'); ?>
 </div>
 <!-- End Footer -->
 </div>
<!-- End Wrapper -->
<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>
