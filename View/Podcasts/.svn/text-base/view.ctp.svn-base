<?php
echo $this->Html->div('title_section', 'Podcasts');
foreach ($data as $$val):
    echo $this->Html->para(null, '<b>'.$val['Podcast']['title'].'</b>');
    echo $this->Html->para(null, hl2br(h($val['Podcast']['description'])));
    #echo '<p><a href="/users/blog/'.$username.'/'.$data[$key]['Podcast']['id'].'">Permalink</a></p><hr />';
endforeach;
?>