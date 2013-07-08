<?php
$data = $this->requestAction('acquaintances/blogElement/'.$blogger['User']['id']);
if ( $data ):
   echo $this->Html->div('temas', __('Useful links'));
   foreach ($data as $v):
       echo '► '.$this->Html->link($v['Acquaintance']['name'], $v['Acquaintance']['url'], array('class'=>'petit')).'<br />';
   endforeach;
   echo $this->Html->para(Null, $this->Html->link(__('View all links'), '/acquaintances/display/'.$blogger['User']['username'], array('class'=>'petit')));
endif;
# ? > EOF

