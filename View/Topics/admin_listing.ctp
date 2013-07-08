<?php
//die(debug($data));

echo $this->Html->div('news_title', 'Topic ' . $data['Topic']['subject']);

foreach($data['Reply'] as $val) 
{
   $st  = ($val['status'] == 1) ? 'Published' : 'Hidden';
   $stl = $this->Html->link($st, '/admin/replies/change/'.$val['topic_id'].'/'.$val['status'].'/'.$val['id']);
   $tmp  = $val['User']['username'] . $this->Html->image('avatars/'.$val['User']['avatar'], array('alt'=>$val['User']['username'], 'title'=>$val['User']['username']));
   $tmp .= $this->Html->para(null, $val['reply']);
   $tmp .= $this->Html->para('news_date', $val['created']);
   $tmp .= $this->Html->link('Delete', '/admin/replies/delete/'.$val['topic_id'].'/'.$val['id']).'  ';
   $tmp .= $stl. ' '. $this->Html->link('Edit', '/admin/replies/edit/'.$val['id']);
   echo $this->Html->div('adminblock', $tmp);
}
?>
