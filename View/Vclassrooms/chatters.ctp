<?php
#debug($data);
echo '<h3>'. __('Chatters') .'</h3>';
foreach($data as $val):
   if ( $val['User']['group_id'] < 3 ):
       $options = array('alt'=>'Teacher: '.$val['User']['username'], 'width'=>'25px','style'=>'border:2px solid red;margin:3px;', 'title'=>'Teacher: '.$val['User']['username']);
   else:
       $options = array('alt'=>$val['User']['username'], 'width'=>'25px','style'=>'margin:3px;','title'=>$val['User']['username']);
   endif;
   echo $this->Html->link($this->Html->image('avatars/'.$val['User']['avatar'], $options), '/users/about/'.$val['User']['username'], array('escape'=>False));
endforeach;
# ? >  EOF