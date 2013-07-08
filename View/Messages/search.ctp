<?php
//die(debug($data));

$values = array();

foreach ($data as $val):
    $values[$val['User']['id']] = $val['User']['username'];
endforeach;
//die(debug($values));
echo $this->Form->select('Message.user_id', $values, null, array(), false);

?>