<?php
//die(debug($data));
echo $this->Html->div('titulo', $data['Forum']['title']);
echo '<div>';
echo $this->Html->link(
                 $this->Html->image('static/new_topic.gif', array("alt"=>"New topic", "title"=>"New topic")),
                 '/topics/add/'.$data['Catforum']['User']['username'].'/'.$data['Forum']['id'], false, false, null); 

echo $this->Html->link(
                 $this->Html->image('static/reply.gif', array("alt"=>"Reply", "title"=>"Reply")),
                 '/topics/add/'.$data['Catforum']['User']['username'].'/'.$data['Forum']['id'], 
                 false, false, null); 

echo '</div>';

foreach($data['Topic'] as $v):
  $tmp  = $this->Html->para('tit1',$v['User']['username'] .' '.__('wrote on',true).' '.$v['created']);
  $tmp .= $this->Html->para('tit1',$v['subject']);
  $tmp .= $this->Html->para('tit1',$v['message']);
  echo $this->Html->div('topic', $tmp);
endforeach;

echo '<div>';
echo $this->Html->link(
                 $this->Html->image('static/new_topic.gif', array('alt'=>'New topic', 'title'=>'New topic')),
                 '/topics/add/'.$data['Catforum']['User']['username'].'/'.$data['Forum']['id'], false, false, null); 

echo $this->Html->link(
                 $this->Html->image('static/reply.gif', array('alt'=>'Reply', 'title'=>'Reply')),
                 '/topics/add/'.$data['Catforum']['User']['username'].'/'.$data['Forum']['id'], 
                 false, false, null); 

echo '</div>';
 
?>