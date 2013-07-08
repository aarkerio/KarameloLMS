<div style="padding:5px;border:1px dotted gray;background-color:#c0c0c0;width:100%;">
<?php
 #die(debug($data));
 echo $this->Html->div('title_sec', $data['Treasure']['title'], array('style'=>'font-size:17pt;'));
 echo $this->Html->div(null,$data['User']['username'].' get '.$data['ResultTreasure']['points'].'points at '.$data['ResultTreasure']['created'], array('style'=>'font-size:8pt;'));
 echo $this->Html->div(null, $data['Treasure']['instructions']);
 echo $this->Html->div(null, 'Value: '. $data['Treasure']['points'] . ' points');

 echo '</div>';