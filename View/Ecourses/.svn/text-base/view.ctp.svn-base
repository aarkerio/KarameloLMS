<?php
#die(var_dump($data));
echo $this->Html->div(null, $data['Catfaq']['title'].'\' FAQ', array('style'=>'font-size:18pt;padding:5px;boder:1px solid #c0c0c0'));

foreach ($data['Faq'] as $v):
     echo '<div style="border:1px dotted gray;padding:4px;margin-bottom:15px">';
     echo '<p style="font-weight:bold;">' .  $v['question'] . '</p>';
     echo $this->Html->para(null,  $v['answer']);
     echo $this->Html->para(null, $this->Html->link($this->Html->image('static/arrow_top.gif', array('alt'=>'Go top', 'title'=>'Go top')), 
                              '#main', array('escape'=>False));
     echo '</div>';
endforeach;
# ? >
