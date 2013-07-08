<?php
#die(debug($data));
echo $this->Html->div('title', __('About me'));
echo $this->Html->div('title');
echo $data['User']['name']  . ' <br />';
echo $this->Html->para(Null, __('My quote').': '. $data['Profile']['quote']);
echo $data['Profile']['cv']    . ' <br />';
echo $this->Html->image('avatars/'.$data['User']['avatar'], array('alt'=>$data['User']['name'],'title'=>$data['User']['name']));
echo '</div>';
# ? > EOF