<?php
$this->layout = 'popup';
$this->pageTitle = __('Preview');
#die(debug($data));
echo '<h1>'. $data['Treasure']['title'] . '</h1>';
echo $this->Html->div(null, '<b>'. __('Points') .':</b> '.$data['Treasure']['points']);
echo $this->Html->div(null, __('Secret'). ': '.$data['Treasure']['secret']);
echo $this->Html->div(null, $data['Treasure']['instructions']);
?>