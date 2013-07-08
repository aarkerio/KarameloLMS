<?php
echo '<?xml version="1.0"?>';
echo $this->Html->docType();
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
echo '<head>';
echo $this->Html->charset();   # Defaults to UTF-8
echo $this->Html->meta('favicon.ico','/favicon.ico', array('type' => 'icon'));
echo $this->Html->meta('News RSS 2.0', '/news/rss.rss', array('type' => 'rss'));
echo $this->Html->meta('keywords',  'education, school, elearning, scorm, social networks',  array(), False);
echo $this->Html->meta('description', 'Educational Portal',array(), False);
if ( isset($this->Js) ):
    echo $this->Html->script(array('jquery-min', 'myfunctions'));
endif;
echo $this->Html->css(array('portal/portal'));
echo '<title>Karamelo::'. $title_for_layout.'</title>';
echo $this->Html->scriptBlock('window.onload = timedMsg;');
?>
<meta name="verify-v1" content="HZsWBXKKGjQZtODXjcEgnlmENVcWHEA5qZX5gli7qQk=" />
</head>
<body>
<?php 
echo $this->Session->flash();
echo $this->element('check_browser'); # IE6 go away!
?> 
<div id="page">
<div id="toplinks"><?php echo $this->element('toplink'); ?></div><!-- toplinks -->
<div id="header"></div><!-- end header -->
<?php   # menu 
  echo $this->element('menu_b');
?>
<div id="container">
<div id="content"><?php echo $content_for_layout; ?></div><!-- main column.  End content -->
<div id="sidebar">
<?php
  # search box
  echo $this->element('search');
  
  # user is logged in ?
  if ( $this->Session->check('Auth.User')  ):
      echo $this->Html->div('outbutton',
                      $this->Html->link($this->Html->image('static/logout.gif', array('alt'=>'Logout', 'title'=>'Logout')),
                                 '/users/logout', array('escape'=>False)));
  else:
      echo $this->element('login');
  endif;

  # if student is logged in, show his/her vClassroom
  if ( $this->Session->check('Auth.User') && $this->Session->read('Auth.User.group_id') == 3):
      echo $this->element('studentclass');
  endif;

  # Parents School element
  echo $this->element('schoolparents');

  # load edublogs
  echo $this->element('lastentries');
  
  # podcast image    
  echo  $this->Html->div('sideelement',
                   $this->Html->link($this->Html->image('teacher_podcast.jpg',array('alt'=>'Podcasts','title'=>'Download Podcasts')),'/podcasts/recent',array('escape'=>False)));
  # Quick vote
  echo $this->element('poll'); 
  
  # College's subjects 
  echo $this->element('subjects');
 
  # We love buttons
  echo $this->element('welove');

  # Twitter
  echo $this->element('twitter');
?>
</div><!-- end sidebar -->
</div><!-- end container -->
<!-- footer -->
<div id="footer">
<p id="legal"><strong>Your School Name Here</strong> &copy; 2006-2012</p>
	<p id="links"> <a href="#"><?php echo __('Privacy Policy');?></a> | <a href="#"><?php echo __('Terms of Use');?></a> | <a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional"><abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a> | <a href="http://jigsaw.w3.org/css-validator/check/referer" title="This page validates as CSS"><abbr title="Cascading Style Sheets">CSS</abbr></a></p>
</div><!-- end footer -->
</div><!-- end page -->
<?php
if ( !$this->Session->check('Auth.User') ):
    echo $this->element('login_hide');   # login javascript popup
endif;
echo $this->Js->writeBuffer();
?>
</body></html>
