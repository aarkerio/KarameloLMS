<?php
#die(debug($data));
if (isset($js)):
   echo $this->Html->script(array('audio-player'));
endif;
echo $this->Html->div('title_portal', __('Last Podcasts'));

if ( count($data) == 0):
    echo $this->Html->para(null, __('Not podcasts yet'));
else:
     $i = (int) 1; # just one iterator
endif;

foreach ($data as $val):
 $i++;
 echo $this->Html->div('divblock'); 
    echo  $this->Html->div('news_title', $val['Podcast']['title']);
    echo  $this->Html->div('news_date',  $val['Podcast']['created']);
    echo '<b>'.__('Author').'</b>: '.$this->Html->link($val['User']['username'], '/blog/'.$val['User']['username']);
    echo  $this->Html->div('news_body',  $val['Podcast']['description']);
    echo  $this->Html->link($this->Html->image('static/headphones.gif', array('alt'=>__('Download'), 'title'=>__('Download'))),
                        '/files/podcasts/'.$val['Podcast']['filename'], array('escape'=>False)) .'    &nbsp; &nbsp;&nbsp;';
    echo  $this->Gags->audioPlayer($val['Podcast']['filename'], $i);
    echo  $this->Html->para(null, $this->Html->link(__('Subscribe'), '/podcasts/rss/'.$val['User']['username'].'.rss'));
    echo '</div>'; 
 endforeach;
?>




