<?php
#die(debug($blogger));
echo '<?xml version="1.0"?>';
echo $this->Html->docType();
echo '<head>';
echo $this->Html->charset();
echo $this->Html->meta('favicon.ico','/favicon.ico', array('type' => 'icon'));
echo $this->Html->meta('Blog Entries RSS 2.0', '/entries/rss/'.$blogger['User']['username'].'.rss', array('type' => 'rss'));
echo $this->Html->meta('keywords',  'enter any meta keyword here',  array(), False);
echo $this->Html->meta('description', 'enter any meta description here',array(), False);
echo '<title>'.$title_for_layout .'</title>';
echo $this->Html->css(array('mexico/styles', 'common/blog'));
if ( isset($this->Js) ):
    echo $this->Html->charset('UTF-8');
echo $this->Html->script(array('jquery-min', 'myfunctions'));
endif;

echo $this->Html->scriptBlock('window.onload = timedMsg;');
?>
</head>
<body>
<?php echo $this->Session->flash(); ?>
<div id="pagewidth">
<div id="header"><br /><br />
<?php 
echo $this->Html->div('blogname', $this->Html->link($blogger['Profile']['name_blog'], '/blog/'.$blogger['User']['username'], array('title'=>$blogger['Profile']['name_blog'])));
echo $this->Html->div('quote', ''.$blogger['Profile']['quote']); 
?>
</div>
<?php echo $this->element('navmenu'); ?>
<div id="wrapper" class="clearfix" >
        <div id="maincol"> 
        <?php
           if (!isset($belongs)): #if belongs is set I am in vclassroom
              echo $this->element('quote');
          endif;
          echo $content_for_layout; 
        ?>
        </div><!--MAIN SECTION END -->
        <?php if ( !isset($belongs) and !isset($permissions) ): ?>
            <div id="sidebar"> 
            <?php
                echo $this->element('feeders');
                echo $this->element('vclassrooms');
                echo $this->element('cv');
                echo $this->element('college');
                echo $this->element('lesson');
                echo $this->element('podcast');
                echo $this->element('catfaqs');
                echo $this->element('acquaintances');
                echo $this->element('banner');
            ?>
            </div>
        <?php else: ?>
            <script language="Javascript">
                     document.getElementById("maincol").style.width= '970px'; 
            </script>
        <?php endif; ?>
   </div><!--wrapper -->
   <div id="footer" >
        <?php echo $this->element('footer'); ?>
   </div>
 </div><!--pagewidth -->
<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>