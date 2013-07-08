<?php
#die(debug($data));
echo $this->Html->div('title_section', $this->Html->image('ipod.png', array('title'=>'Podcasts', 'alt'=>'Podcasts')).' '.__('Last Podcasts'));
$i = (int) 0;
echo $this->Html->div(null, $this->Html->link(__('Subscribe'), '/podcasts/rss/'.$blogger['User']['username'].'.rss'));

foreach ($data as $val):
    $i++;
    $tmp  =  '<h2>'. $val['Podcast']['title'].'</h2>';
    $tmp .=  $this->Html->div('news_date',  $val['Podcast']['created']);
    $tmp .= '<b>'.__('Author').'</b>: '.$this->Html->link($blogger['User']['username'], '/blog/'.$blogger['User']['username']);
    $tmp .=  $this->Html->div('news_body',  $val['Podcast']['description']);
   
    $t    =  $this->Html->link(
                        $this->Html->image('static/headphones.gif', array('alt'=>'Download podcast', 'title'=>'Download podcast')), 
                        '/files/podcasts/'.$val['Podcast']['filename'], array('escape'=>False)) .'   ';
    $t   .=  $this->Gags->audioPlayer($val['Podcast']['filename'], $i) .'<br />';
    $tmp .=  $this->Html->para(null,$t);

    echo $this->Html->div('divblock', $tmp);
endforeach;
?>




