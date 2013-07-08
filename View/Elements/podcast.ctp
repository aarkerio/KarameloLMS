<?php
$data = $this->requestAction('podcasts/blogElement/'.$blogger['User']['id']);
if ( $data ):
   echo $this->Html->div('temas', 'Podcasts');
   foreach ($data as $v):
       echo '► '.$this->Html->link($v['Podcast']['title'],'/podcasts/show/'.$blogger['User']['username'].'/'.$v['Podcast']['id'],array('class'=>'petit')).'<br />';
   endforeach;
   echo $this->Html->para(Null, $this->Html->link(__('View all podcast'), '/podcasts/display/'.$blogger['User']['username'], array('class'=>'petit')));
endif;
# ? > EOF