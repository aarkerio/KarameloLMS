<?php
$this->set('title_for_layout', 'People is blogging');
echo $this->Html->div('title_portal','eduBloggers');

foreach ($data as $v):
    $tmp  = '<b>'.__('Teacher').'</b>: '.$v['User']['name'] . '<br /> blog: '.$this->Html->link($v['Profile']['name_blog'], '/blog/'.$v['User']['username']) .'<br />';
	$tmp .= $this->Html->link(
	                  $this->Html->image('avatars/'.$v['User']['avatar'], array('alt'=>$v['Profile']['quote'], 'title'=>$v['Profile']['quote'])), 
					  '/blog/'.$v['User']['username'], array('escape'=>False));
    echo $this->Html->div('divblock', $tmp, array('style'=>'padding:15px;margin:8px;'));
endforeach;

# ? > EOF
