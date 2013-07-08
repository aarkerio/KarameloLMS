<?php
echo $this->Html->div('feeders');
echo __('Subscribe by') . ' &nbsp;<br />';
echo $this->Html->link('Blog', '/entries/rss/'.$blogger['User']['username'] . '.rss', array('class'=>'smallinks')). ' | '; 
echo $this->Html->link('Podcast', '/podcasts/rss/'.$blogger['User']['username'].'.rss', array('class'=>'smallinks'));
echo '</div>';

# ? > EOF