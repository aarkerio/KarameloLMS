<?php
 echo '<?xml version="1.0"?>';
 echo $this->Html->docType();
 echo '<head>';
 echo $this->Html->charset();
 echo $this->Html->meta('favicon.ico','/favicon.ico', array('type' => 'icon'));
 echo $this->Html->meta('Blog Entries RSS 2.0', '/entries/rss/'.$blogger['User']['username'].'.rss', array('type' => 'rss'));
 echo $this->Html->meta('keywords',  'enter any meta keyword here',  array(), False);
 echo $this->Html->meta('description', 'enter any meta description here',array(), False);
 echo '<title>'.$title_for_layout .'</title>';
 echo $this->Html->css(array('reset', 'basic/styles', 'common/blog'));

 if ( isset($this->Js) ):
     echo $this->Html->charset('UTF-8');
     echo $this->Html->script(array('jquery-min', 'myfunctions'));
 endif;
echo $this->Html->scriptBlock('window.onload = timedMsg;');
?>
</head>
<body>
<?php echo $this->Session->flash();  # print little messages after someone do some action. see the css definitions ?> 
<!--Main-->
<div id="pagewidth">
<div id="header">
<?php 
echo $this->Html->link($blogger['Profile']['name_blog'], '/blog/'.$blogger['User']['username'], array('title'=>$blogger['Profile']['name_blog']));
echo $this->Html->div('quote', ''.$blogger['Profile']['quote']); 
?>
</div><!-- #header -->
<?php echo $this->element('navmenu'); ?>
<div id="dvrssquote">
<div id="dvrss"><strong>RSS:</strong> <?php echo $this->element('feeders');?></div>
<div id="dvquote">
<?php  
if (!isset($belongs)): #if belongs is set I am in vclassroom
    echo $this->element('quote');
endif; 
?>
</div>
</div><!-- #rssquote -->
<div id="wrapper">
<div id="maincol"><?php  e($content_for_layout); ?> </div>
<?php
if ( !isset($belongs) and !isset($permissions) ):
    echo '<div id="sidebar">';
    echo $this->element('vclassrooms');
    echo $this->element('cv');
    echo $this->element('college');
    echo $this->element('lesson');
    echo $this->element('podcast');
    echo $this->element('catfaqs');
    echo $this->element('acquaintances');
    echo $this->element('banner');
    echo '</div><!-- #sidebar -->';
else: ?>
    <script language="javascript">
         document.getElementById("maincol").style.width = '100%';
    </script>
<?php 
endif;
?>
</div><!-- #wrapper -->
</div><!-- #pagewidth -->
<div style="clear:both;"></div>

<div id="footer"> 
        <?php echo $this->element('footer'); ?>
</div><!-- #footer -->
<?php echo $this->Js->writeBuffer(); ?>
</body> 
</html>