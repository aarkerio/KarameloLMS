<?php
/**
 *   Chipotle Software(c) GPLv3 2006-2012
 */
$this->set('title_for_layout', __('Welcome'));
?>
<div id="divimages" style="float:left;padding:6px;width:100%;margin:10px;height:auto"><!-- wrappertools -->
<?php
# no teacher entries yet, so, show welcome message
if ( !$data ):
    $link = '<i>'.$this->Session->read('Auth.User.username') ."'s blog </i>";
    $str  =  $this->Html->image('static/help-renky.jpg', array('title'=>'renky', 'alt'=>'renky', 'style'=>'float:left;')) .' ';
    $str .= __("Hi! I'm Renky, the annoying Karamelo's pet") .'.<br /><br /> ';
    $str .= __('Looks like you are a new Karamelo user. Note the link').' '.$link .' '.__('start_1').'. <br /><br />'.__('start_2').'.';
    echo $this->Html->div('firsttime',$str);
endif;
?>
<h2><?php echo __('Teacher tools');?></h2>
<?php
#debug($this->Session->read('Auth.User'));
$tmp  = $this->Html->link($this->Html->image('blog.png', array('title'=>'EduBlog','alt'=>'EduBlog')), '/admin/entries/listing', array('escape'=>False)); 
$tmp .= $this->Html->link('eduBlog', '/admin/entries/listing', array('title'=>'Blog', 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'eduBlog', 'onclick'=>"document.location.href='/admin/entries/listing'"));

$tmp = $this->Html->link($this->Html->image('myimages.png',array('title'=>__('My Images'),'alt'=>__('My Images'))),'/admin/images/listing',array('escape'=>False));
$tmp .= $this->Html->link(__('Images'),'/admin/images/listing', array('title'=>'My Images', 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'Images', 'onclick'=>"document.location.href='/admin/images/listing'"));
 
# Lessons
$tmp = $this->Html->link($this->Html->image('static_pages.png',array('title'=>__('Lessons'),'alt'=>__('Lessons'))),'/admin/lessons/listing',array('escape'=>False));
$tmp .= $this->Html->link(__('Lessons'),'/admin/lessons/listing', array('title'=>__('Lessons'), 'class'=>'main-item-caption'));
echo $this->Html->div('main-item',$tmp, array('title'=>'Lessons', 'onclick'=>"document.location.href='/admin/lessons/listing'"));

# FAQs
$tmp  = $this->Html->link($this->Html->image('faq.png', array('title'=>'FAQs','alt'=>'FAQs')),'/admin/catfaqs/listing', array('escape'=>False));
$tmp .= $this->Html->link('FAQs', '/admin/catfaqs/listing', array('title'=>'Create/Edit your FAQs', 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'FAQs', 'onclick'=>"document.location.href='/admin/catfaqs/listing'"));

# Glossary 
$tmp = $this->Html->link($this->Html->image('Glossary.png', array('title'=>__('Glossaries'), 'alt'=>__('Glossaries'))), '/admin/catglossaries/listing', array('escape'=>False));
$tmp .= $this->Html->link(__('Glossaries'), '/admin/catglossaries/listing', array('title'=>__('Glossary'), 'class'=>'main-item-caption'));
echo $this->Html->div('main-item',$tmp,array('title'=>'Glossaries','onclick'=>"document.location.href='/admin/catglossaries/listing'"));
 
# Podcasts
$tmp  = $this->Html->link($this->Html->image('ipod.png', array('title'=>'Podcasts', 'alt'=>'Podcasts')), '/admin/podcasts/listing', array('escape'=>False));
$tmp .= $this->Html->link('Podcasts', '/admin/podcasts/listing', array('title'=>'Podcast', 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'Blog', 'onclick'=>"document.location.href='/admin/podcasts/listing'"));

# Forums
$tmp  = $this->Html->link($this->Html->image('phorum.png', array('title'=>'Messages','alt'=>'Messages')),'/admin/messages/listing',array('escape'=>False)); 
$tmp .= $this->Html->link(__('Messages'), '/admin/messages/listing/', array('title'=>'My Settings', 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'Messages', 'onclick'=>"document.location.href='/admin/messages/listing'"));

# Wikis 
$tmp  = $this->Html->link($this->Html->image('wikis.png', array('title'=>'Wikis', 'alt'=>'Wikis')), '/admin/wikis/listing', array('escape'=>False));
$tmp .= $this->Html->link('Wikis', '/admin/wikis/listing', array('title'=>'Wikis', 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'Blog', 'onclick'=>"document.location.href='/admin/wikis/listing'"));

# Shares 
$tmp  = $this->Html->link($this->Html->image('mmultimedia.png',array('title'=>__('Shared files'), 'alt'=>__('Shared files'))), '/admin/shares/listing', array('escape'=>False));
$tmp .= $this->Html->link(__('Shares'), '/admin/shares/listing',array('title'=>__('Shared files'), 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'Files', 'onclick'=>"document.location.href='/admin/shares/listing'"));

# Usefull links
$tmp = $this->Html->link($this->Html->image('ylinks.png', array('title'=>__('Usefull links'),'alt'=>__('Usefull links'))),'/admin/acquaintances/listing',array('escape'=>False)); 
$tmp .= $this->Html->link(__('Usefull links'),'/admin/acquaintances/listing', array('title'=>__('Usefull'), 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'Links', 'onclick'=>"document.location.href='/admin/acquaintances/listing'"));

# Quotes
$tmp = $this->Html->link($this->Html->image('quotes.png', array('title'=>__('Quotes'), 'alt'=>__('Quotes'))), '/admin/quotes/listing', array('escape'=>False)); 
$tmp .= $this->Html->link(__('Quotes'), '/admin/quotes/listing', array('title'=>__('Quotes'), 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'Quotes', 'onclick'=>"document.location.href='/admin/quotes/listing'"));

# eCourses
$tmp  = $this->Html->link($this->Html->image('ecourses.png',array('title'=>'eCourses','alt'=>'eCourses')),'/admin/ecourses/listing',array('escape'=>False)); 
$tmp .= $this->Html->link('eCourses','/admin/ecourses/listing',array('title'=>'Manage your eCourses in a pretty and fast way', 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'eCourses', 'onclick'=>"document.location.href='/admin/ecourses/listing'"));

# Vclassroms
$tmp  = $this->Html->link($this->Html->image('static/icon_group.png',array('title'=>'vClassrooms','alt'=>'vClassrooms')), '/admin/vclassrooms/listing', array('escape'=>False));
$tmp .= $this->Html->link('vClassrooms', '/admin/vclassrooms/listing', array('title'=>'vClassrooms', 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'vClassrooms', 'onclick'=>"document.location.href='/admin/vclassrooms/listing'"));

# Forums
$tmp  = $this->Html->link($this->Html->image('static/forums.png', array('title'=>__('Forums'),'alt'=>__('Forums'))), '/admin/catforums/listing', array('escape'=>False));  
$tmp .= $this->Html->link(__('Forums'), '/admin/catforums/listing', array('title'=>__('Forums'), 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'Forums', 'onclick'=>"document.location.href='/admin/catforums/listing'"));
?>
</div>
<div style="clear:both;"></div>
<div id="divimages" style="float:left;padding:6px;width:100%;margin:4px;"><!-- wrappertools -->
<h2><?php echo __('Karamelo Network Didactic Elements (Kandies)');?></h2>
<?php 
# Webquests
$tmp = $this->Html->link($this->Html->image('webquests.png',array('title'=>'Webquests','alt'=>'Webquests')),'/admin/webquests/listing', array('escape'=>False)); 
$tmp .= $this->Html->link('Webquests', '/admin/webquests/listing', array('title'=>'Webquests', 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'Webquests', 'onclick'=>"document.location.href='/admin/webquests/listing'"));

# Gap fillings
$tmp = $this->Html->link($this->Html->image('static/gap_filling_icon.png', array('title'=>__('Gap filling'), 'alt'=>__('Gap filling'))),'/admin/gaps/listing',array('escape'=>False)); 
$tmp .= $this->Html->link(__('Gap fillings'), '/admin/gaps/listing', array('title'=>__('Gap filling'), 'class'=>'main-item-caption'));
 echo $this->Html->div('main-item', $tmp, array('title'=>__('Gap filling'), 'onclick'=>"document.location.href='/admin/gaps/listing'"));

# Scavenger Hunts
$tmp = $this->Html->link($this->Html->image('thunt.png',array('title'=>__('Scavanger hunts'),'alt'=>__('Scavenger hunts'))),'/admin/treasures/listing',array('escape'=>False)); 
$tmp .= $this->Html->link(__('Scavenger hunts'), '/admin/treasures/listing', array('title'=>__('Scavenger hunts'), 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'Scavenger hunts', 'onclick'=>"document.location.href='/admin/treasures/listing'"));

# Tests
$tmp  = $this->Html->link($this->Html->image('admin/tests.png', array('title'=>__('Tests'),'alt'=>__('Tests'))), '/admin/tests/listing', array('escape'=>False)); 
$tmp .= $this->Html->link(__('Tests'),'/admin/tests/listing', array('title'=>__('Test'), 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>__('Tests'), 'onclick'=>"document.location.href='/admin/tests/listing'"));

# Quizzes
#$tmp  = $this->Html->link($this->Html->image('admin/icon-quiz.png', array('title'=>__('Quizzes'),'alt'=>__('Quizzes'))), '/admin/quizzes/listing', array('escape'=>False)); 
#$tmp .= $this->Html->link(__('Quizzes'),'/admin/quizzes/listing', array('title'=>__('Quizzes'), 'class'=>'main-item-caption'));
#echo $this->Html->div('main-item', $tmp, array('title'=>__('Quizzes'), 'onclick'=>"document.location.href='/admin/quizzes/listing'"));

# SCORMs
$tmp = $this->Html->link($this->Html->image('scorm-icon.png',array('title'=>'SCORMs', 'alt'=>'SCORMs')),'/admin/scorm/scorms/listing',array('escape'=>False));
$tmp .= $this->Html->link('SCORMs', '/admin/scorm/scorms/listing', array('title'=>'Wikis', 'class'=>'main-item-caption'));
echo $this->Html->div('main-item', $tmp, array('title'=>'SCORMs', 'onclick'=>"document.location.href='/admin/scorm/scorms/listing'"));

# Knet
#$tmp  = $this->Html->link($this->Html->image('static/knet_icon.png',array('title'=>'Knet','alt'=>'Knet')),'/admin/knets/listing',array('escape'=>False)); 
#$tmp .= $this->Html->link('Knet','/admin/knets/listing', array('title'=>'Chats', 'class'=>'main-item-caption'));
#echo $this->Html->div('main-item', $tmp, array('title'=>'K-net', 'onclick'=>"document.location.href='/admin/knets/listing'"));
?>
<div>
<div style="clear:both;"></div>
<br />
<?php if ( $this->Session->read('Auth.User.group_id') == 1 ):  ?>
   <h2><?php echo __('Admin sections');?></h2>
<?php 
endif; 

if ( $this->Session->read('Auth.User.group_id') == 1 ): 
    $tmp  = $this->Html->link($this->Html->image('news-icon.png',array('title'=>__('News'),'alt'=>__('News'))),
                              '/admin/news/listing',array('escape'=>False)); 
    $tmp .= $this->Html->link(__('News'), '/admin/news/listing', array('title'=>__('News'), 'class'=>'main-item-caption'));
    echo $this->Html->div('main-item', $tmp, array('title'=>__('News'), 'onclick'=>"document.location.href='/admin/news/listing'"));
endif; 

if ( $this->Session->read('Auth.User.group_id') == 1 ):
    $tmp  = $this->Html->link($this->Html->image('areas.png', array('title'=>__('Subjects'),'alt'=>__('Subjects'))),
                              '/admin/subjects/listing', array('escape'=>False)); 
    $tmp .= $this->Html->link(__('Subjects'), '/admin/subjects/listing', array('title'=>__('Subjects'), 'class'=>'main-item-caption'));
    echo $this->Html->div('main-item', $tmp, array('title'=>'Subjects', 'onclick'=>"document.location.href='/admin/subjects/listing'"));
endif; 

if ( $this->Session->read('Auth.User.group_id') == 1 ):
    $tmp  = $this->Html->link($this->Html->image('articles.png',array('title'=>__('News Themes'),'alt'=>__('News Themes'))),
                              '/admin/themes/listing', array('escape'=>False)); 
    $tmp .= $this->Html->link(__('News Themes'), '/admin/themes/listing', array('class'=>'main-item-caption', 'title'=>__('News Themes')));
    echo $this->Html->div('main-item', $tmp, array('title'=>__('News Themes'), 'onclick'=>"document.location.href='/admin/themes/listing'"));
endif;

if ( $this->Session->read('Auth.User.group_id') == 1 ): 
    $tmp  = $this->Html->link($this->Html->image('Poll.png', array('title'=>__('Polls'),'alt'=>__('Polls'))),
                              '/admin/polls/listing', array('escape'=>False));
    $tmp .= $this->Html->link(__('Polls'), '/admin/polls/listing', array('title'=>__('Polls'), 'class'=>'main-item-caption'));
    echo $this->Html->div('main-item', $tmp, array('title'=>__('Polls'), 'onclick'=>"document.location.href='/admin/polls/listing'"));
endif;

if ( $this->Session->read('Auth.User.group_id') == 1 ):
    $tmp = $this->Html->link($this->Html->image('karamelo_users.png', array('title'=>__('Users'), 'alt'=>__('Users'))), 
                             '/admin/users/listing', array('escape'=>False)); 
    $tmp .= $this->Html->link(__('Users'), '/admin/users/listing', array('title'=>'Users', 'class'=>'main-item-caption'));
    echo $this->Html->div('main-item', $tmp, array('title'=>__('Users'), 'onclick'=>"document.location.href='/admin/users/listing'"));
endif;

if ( $this->Session->read('Auth.User.group_id') == 1 ):
    $tmp  = $this->Html->link($this->Html->image('backup.png', array('title'=>__('Backup'),'alt'=>__('Backups'))),
                              '/admin/users/backup', array('escape'=>False)); 
    $tmp .= $this->Html->link(__('Backup'), '/admin/users/backups', array('title'=>__('Backup'), 'class'=>'main-item-caption'));
    echo $this->Html->div('main-item', $tmp, array('title'=>__('Backup'), 'onclick'=>"document.location.href='/admin/users/backup'"));
endif;

# Newsletter 
if ( $this->Session->read('Auth.User.group_id') == 1 ): 
    $tmp  = $this->Html->link($this->Html->image('static/newsletter-icon.png', array('title'=>__('Newsletters'), 'alt'=>__('Newsletters'))), 
                              '/admin/newsletters/listing',  array('escape'=>False));
    $tmp .= $this->Html->link(__('Newsletters'),'/admin/newsletters/listing', array('title'=>'Newsletters', 'class'=>'main-item-caption'));
    echo $this->Html->div('main-item', $tmp, array('title'=>__('Newsletters'), 'onclick'=>"document.location.href='/admin/newsletters/listing'"));
endif; 

# Helps
if ( $this->Session->read('Auth.User.group_id') == 1 ): 
    $tmp  = $this->Html->link($this->Html->image('admin/help-icon.png',array('title'=>__('Helps'),'alt'=>__('Helps'))),
                              '/admin/helps/listing', array('escape'=>False));
    $tmp .= $this->Html->link(__('Help'), '/admin/helps/doit', array('title'=>__('Helps'), 'class'=>'main-item-caption'));
    echo $this->Html->div('main-item', $tmp, array('title'=>__('Helps'), 'onclick'=>"document.location.href='/admin/helps/listing'"));
endif;

# College
if ( $this->Session->read('Auth.User.group_id') == 1 ):
  $tmp  = $this->Html->link($this->Html->image('admin.png', array('title'=>__('College'), 'alt'=>__('College'))), '/admin/colleges/listing',  array('escape'=>False));
  $tmp .= $this->Html->link(__('College'), '/admin/colleges/listing', array('title'=>__('College'), 'class'=>'main-item-caption'));
  echo $this->Html->div('main-item', $tmp, array('title'=>__('College'), 'onclick'=>"document.location.href='/admin/colleges/listing'"));
endif; 

# School library
if ( $this->Session->read('Auth.User.group_id') == 1 ): 
    $tmp  = $this->Html->link($this->Html->image('static/medias_icon.jpg',array('title'=>__('School library'),'alt'=>__('School library'))),
                              '/admin/collections/listing', array('escape'=>False));
    $tmp .= $this->Html->link(__('School library'),'/admin/collections/listing',array('title'=>__('Collections'),'class'=>'main-item-caption'));
    echo $this->Html->div('main-item',$tmp,array('title'=>__('Book & Collections'),'onclick'=>"document.location.href='/admin/collections/listing'"));
endif;
/*
# General Reports
if ( $this->Session->read('Auth.User.group_id') == 1 ):
    $tmp  = $this->Html->link($this->Html->image('admin/report_icon.png', array('title'=>__('Reports'), 'alt'=>__('Reports'))), 
                              '/admin/colleges/reports', array('escape'=>False));
    $tmp .= $this->Html->link(__('Reports'), '/admin/colleges/reports', array('title'=>__('Reports'), 'class'=>'main-item-caption'));
    echo $this->Html->div('main-item', $tmp, array('title'=>__('Reports'), 'onclick'=>"document.location.href='/admin/colleges/reports/'"));
endif;

# External plugins (thiis must be done in this year!!)
if ( $this->Session->read('Auth.User.group_id') == 1 ):
    $tmp  = $this->Html->link($this->Html->image('admin/plugins_icon.png', array('title'=>__('Plugins'), 'alt'=>__('Plugins'))), 
                              '/admin/plugins/listing', array('escape'=>False));
    $tmp .= $this->Html->link(__('Plugins'), '/admin/plugins/listing', array('title'=>__('Plugins'), 'class'=>'main-item-caption'));
    echo $this->Html->div('main-item', $tmp, array('title'=>__('Plugins'), 'onclick'=>"document.location.href='/admin/plugins/listing'"));
endif;
*/

# ? > EOF
