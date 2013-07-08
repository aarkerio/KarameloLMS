<?php
#die( var_dump($data) );
echo  '<h1>' . $data['Podcast']['title'] . '</h1>';
echo  "<p>"  . $data['Podcast']['description']   . ' <br />';
echo  "<span style='font-size:7pt;'>". $data['Podcast']['created'] . '</span><br />';
echo  $data['Podcast']['filename'].' Size: '.filesize('../webroot/files/podcasts/'.$data['Podcast']['filename']) . ' bytes';
echo  ' '  . $data['Podcast']['length'] . '<br /></p>';

echo  $this->Html->link($this->Html->image('static/headphones.gif', array('alt'=>'Download podcast', 'title'=>'Download podcast')), 
                        '/files/podcasts/'.$data['Podcast']['filename'], array('escape'=>False)) .'   ';
echo $this->Gags->audioPlayer($data['Podcast']['filename'], 1) .'<br />';
echo $this->Html->link('Subscribe', '/podcasts/rss/'.$blogger['User']['username'].'.rss');
?>