<?php
#debug($data);
$this->set('title_for_layout', __('WikiPage History'));

echo $this->element('vccrumb', array('blogger'=> $blogger['User']['username'], 'vclassroom_id'=>$data['Wiki']['vclassroom_id']));
echo $this->Html->div('title_section', __('WikiPage History'));

foreach($data['Revision'] as $r):
    echo $this->Html->div(Null);
    echo $this->Html->link('Revision ' .  $r['revision'], '/wikis/revision/'.$blogger['User']['username'].'/'.$data['Wiki']['slug'].'/'.$r['id']);
    echo ' modified on '.$r['modified'] .' by '. $r['User']['username'] . ' ';
    echo $this->Html->link($this->Html->image('avatars/'.$r['User']['avatar'], array('alt'=>$r['User']['username'], 'title'=>$r['User']['username'], 
                                              'width'=>'18px')), '/users/about/'.$r['User']['username'], array('escape'=>False));
    echo '</div>';
endforeach;

# ? > EOF
