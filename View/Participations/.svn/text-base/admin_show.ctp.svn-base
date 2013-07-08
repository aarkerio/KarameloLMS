<?php
#die(debug($data));
$this->set('title_for_layout', __('Participation'));
echo $this->Html->div(Null,  __('Points') . ': '. $data['Participation']['points']);

echo $this->Html->para(Null, $data['Participation']['title'], array('style'=>'font-size:14pt;'));
echo $this->Html->div(Null, $this->Html->image('avatars/'.$data['User']['avatar'], array('alt'=>$data['User']['username'], 'title'=>$data['User']['username'])));
echo $this->Html->div(Null,  '<b>'.__('Student') . '</b>: '. $data['User']['name']);
echo $this->Html->div(Null,  '<b>'.__('Created') . '</b>: '. $data['Participation']['created']);
echo $this->Html->div(Null,  $data['Participation']['participation']);

# ? > EOF
