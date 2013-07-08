<div style="float:left;padding:6px;width:100%;margin:10px;height:auto"><!-- wrappertools -->

<h2>Teacher tools</h2>

<div class="main-item" title="Blog" onclick="document.location.href = '/admin/entries/list'">
  <span class="main-item-icon">
     <?php echo $this->Html->link($this->Html->image('blog.png', array("title"=>"EduBlog", "alt"=>"EduBlog")), '/admin/entries/listing', null, null, false); ?>
  </span>
  <a href="/admin/entries/listing" title="Blog" class="main-item-caption">eduBlog</a>
</div>

<div class="main-item" title="Quotes" onclick="document.location.href = '/admin/quotes/list'">
  <span class="main-item-icon">
     <?php echo $this->Html->link($this->Html->image('quotes.png', array("title"=>"Quotes", "alt"=>"Quotes")), '/admin/quotes/listing', null, null, false); ?>
  </span>
  <a href="/admin/quotes/listing" title="Quotes" class="main-item-caption">Quotes</a>
</div>

<div class="main-item" title="My Images" onclick="document.location.href = '/admin/images/list'">
  <span class="main-item-icon">
      <?php echo $this->Html->link($this->Html->image('myimages.png', array("title"=>"My Images", "alt"=>"My Images")), '/admin/images/listing', null, null, false); ?>
  </span>
  <a href="/admin/images/listing" title="My Images" class="main-item-caption">My Images</a>
</div>

<div class="main-item" title="Settings" onclick="document.location.href = '/admin/messages/listing/'">
  <span class="main-item-icon">
       <?php echo $this->Html->link($this->Html->image('phorum.png', array("title"=>"Messages", "alt"=>"Messages")), '/admin/messages/listing', null, null, false); ?>
  </span>
  <a href="/admin/messages/listing/" title="My Settings" class="main-item-caption">Messages</a>
</div>

<div class="main-item" title="Media Manager" onclick="document.location.href = '/admin/shares/list'">
  <span class="main-item-icon">
     <?php echo $this->Html->link($this->Html->image('mmultimedia.png', array("title"=>"Files", "alt"=>"Files")), '/admin/shares/listing', null, null, false); ?>
  </span>
  <a href="/admin/shares/listing" title="Shares" class="main-item-caption">Shares</a>
</div>

<div class="main-item" title="Manage your eCourses in a pretty and fast way" onclick="document.location.href = '/admin/ecourses/list'">
  <span class="main-item-icon">
      <?php echo $this->Html->link($this->Html->image('ecourses.png', array("title"=>"eCourses", "alt"=>"eCourses")), '/admin/ecourses/listing', null, null, false); ?>
  </span>
  <a href="/admin/ecourses/listing" title="Manage your eCourses in a pretty and fast way" class="main-item-caption">eCourses</a>
</div>

<div class="main-item" title="Lessons" onclick="document.location.href = '/admin/lessons/listing'">
  <span class="main-item-icon">
      <?php echo $this->Html->link($this->Html->image('static_pages.png', array("title"=>"Lessons", "alt"=>"Lessons")), '/admin/lessons/listing', null, null, false); ?>
  </span>
  <a href="/admin/lessons/listing" title="Lessons" class="main-item-caption">Lessons</a>
</div>

<div class="main-item" title="Glossary" onclick="document.location.href = '/admin/cat/glossaries/list'">
  <span class="main-item-icon">
     <?php echo $this->Html->link($this->Html->image('Glossary.png', array("title"=>"Glossary", "alt"=>"Glossary")), '/admin/catglossaries/listing', null, null, false); ?>
  </span>
  <a href="/admin/catglossaries/listing" title="Glossary" class="main-item-caption">Glossary</a>
</div>

<div class="main-item" title="Podcast" onclick="document.location.href = '/admin/podcasts/list'">
  <span class="main-item-icon">
       <?php echo $this->Html->link($this->Html->image('ipod.png', array("title"=>"Podcast", "alt"=>"Podcast")), '/admin/podcasts/listing', null, null, false); ?>
  </span>
  <a href="/admin/podcasts/listing" title="Podcast" class="main-item-caption">Podcast</a>
</div>

<div class="main-item" title="Create/Edit your FAQs" onclick="document.location.href = '/admin/catfaqs/list'">
  <span class="main-item-icon">
     <?php echo $this->Html->link($this->Html->image('faq.png', array("title"=>"FAQs", "alt"=>"FAQs")), '/admin/catfaqs/listing', null, null, false); ?>
  </span>
  <a href="/admin/catfaqs/listing" title="Create/Edit your FAQs" class="main-item-caption">FAQs</a>
</div>

<div class="main-item" title="Your links" onclick="document.location.href = '/admin/acquaintances/list'">
  <span class="main-item-icon">
     <?php echo $this->Html->link($this->Html->image('ylinks.png', array("title"=>"Friend Links", "alt"=>"Friend Links")), '/admin/acquaintances/listing', null, null, false); ?>
  </span>
  <a href="/admin/acquaintances/listing" title="Your links" class="main-item-caption">Friend links</a>
</div>

<div style="clear:both;"></div>

<h2>Courses</h2>
<?php
foreach ($data as $val)
{
 echo '<div style="padding:4px;margin:5px;border:1px dotted gray;">';
      
      echo $this->Html->link($val['Ecourse']['title'], '/admin/ecourses/vclassrooms/'.$val['Ecourse']['id']);
      
      echo '<div style="padding:6px 3px 8px 24px;margin:10px 0 5px 0;border:1px dotted gray;">';
      echo '<h1>Classrooms</h1>'; 
      foreach ($val['Vclassroom'] as $v)
      {
         echo '<b>' . $this->Html->link($v['name'], '/admin/vclassrooms/start/'.$v['id'])    . '</b><br />';
      }
      echo '</div>';
 echo '</div>';
}
?>
<div style="clear:both;"></div>



<div style="margin:10px">
<br />
<?php if ( $othAuth->user('group_id') == 1 ):  ?>
   <h2>Admin sections</h2>
<?php endif; ?>

<?php if ( $othAuth->user('group_id') == 1 ): ?>
  <div class="main-item" title="News" onclick="document.location.href = '/admin/news/listing'">
    <span class="main-item-icon">
       <?php echo $this->Html->link($this->Html->image('news-icon.png', array("title"=>"News", "alt"=>"News")), '/admin/news/listing', null, null, false); ?>
    </span>
    <a href="/admin/news/listing" title="News" class="main-item-caption">News</a>
   </div>
<?php endif; ?>

<?php if ( $othAuth->user('group_id') == 1 ): ?>
  <div class="main-item" title="Subjects" onclick="document.location.href = '/admin/subjects/listing'">
    <span class="main-item-icon">
      <?php echo $this->Html->link($this->Html->image('areas.png', array("title"=>"Subjects", "alt"=>"Subjects")), '/admin/subjects/listing', null, null, false); ?>
    </span>
    <a href="/admin/subjects/listing" title="Subjects" class="main-item-caption">Subjects</a>
   </div>
<?php endif; ?>

<?php if ( $othAuth->user('group_id') == 1 ): ?>
  <div class="main-item" title="News Themes" onclick="document.location.href = '/admin/themes/listing'">
   <span class="main-item-icon">
 <?php echo $this->Html->link($this->Html->image('cover-icon.png', array("title"=>"News Themes", "alt"=>"News Themes")), '/admin/themes/listing',null,null,false);?>
    </span>
    <?php echo $this->Html->link("News Themes", "/themes/listing", array("class"=>"main-item-caption")); ?> 
   </div>
<?php endif; ?>

<?php if ( $othAuth->user('group_id') == 1 ): ?>
 <div class="main-item" title="polls" onclick="document.location.href = '/admin/polls/listing'">
   <span class="main-item-icon">
     <?php echo $this->Html->link($this->Html->image('Poll.png', array("title"=>"Polls", "alt"=>"Polls")), '/admin/polls/listing', null, null, false); ?>
   </span>
   <a href="/admin/polls/listing" title="Polls" class="main-item-caption">Polls</a>
 </div>
 <?php endif; ?>

<?php if ( $othAuth->user('group_id') == 1 ): ?>
<div class="main-item" title="Users" onclick="document.location.href = '/admin/users/listing'">
  <span class="main-item-icon">
       <?php echo $this->Html->link($this->Html->image('karamelo_users.png', array("title"=>"Users", "alt"=>"Users")), '/admin/users/listing', null, null, false); ?>
  </span>
  <a href="/admin/users/listing" title="ClassRooms" class="main-item-caption">Users</a>
</div>
<?php endif; ?>

<?php if ( $othAuth->user('group_id') == 1 ): ?>
<div class="main-item" title="Backup" onclick="document.location.href = '/admin/users/backup'">
  <span class="main-item-icon">
      <?php echo $this->Html->link($this->Html->image('backup.png', array("title"=>"Backups", "alt"=>"Backups")), '/admin/users/backup', null, null, false); ?>
  </span>
  <a href="/admin/users/backups" title="Backup" class="main-item-caption">Backup</a>
</div>
<?php endif; ?>

<?php if ( $othAuth->user('group_id') == 1 ): ?>
<div class="main-item" title="Newsletters" onclick="document.location.href = '/admin/newsletters/listing'">
  <span class="main-item-icon">
      <?php echo $this->Html->link($this->Html->image('static/newsletter-icon.png', array("title"=>"Newsletters", "alt"=>"Newsletters")), '/admin/newsletters/listing', null, null, false); ?>
  </span>
  <a href="/admin/newsletters/listing" title="Newsletters" class="main-item-caption">Newsletters</a>
</div>
<?php endif; ?>

<?php if ( $othAuth->user('group_id') == 1 ): ?>
<div class="main-item" title="Help" onclick="document.location.href = '/admin/helps/listing'">
  <span class="main-item-icon">
      <?php echo $this->Html->link($this->Html->image('admin/help-icon.png', array("title"=>"Helps", "alt"=>"Helps")), '/admin/helps/listing', null, null, false); ?>
  </span>
  <a href="/admin/helps/doit" title="Help" class="main-item-caption">Helps</a>
</div>
<?php endif; ?>

<?php if ( $othAuth->user('group_id') == 1 ): ?>
  <div class="main-item" title="Admin" onclick="document.location.href = '/admin/colleges/listing'">
    <span class="main-item-icon">
         <?php echo $this->Html->link($this->Html->image('admin.png', array("title"=>"Admin", "alt"=>"Admin")), '/admin/colleges/listing', null, null, false); ?>
    </span>
    <a href="/admin/colleges/listing" title="News" class="main-item-caption">Admin</a>
   </div>
<?php endif; ?>
</div>
</div><!-- wraptools ends-->