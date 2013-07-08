<?php
echo $this->set('title_for_layout',  $data['College']['name']);
echo $this->Html->div('title_portal',$data['College']['name']);

echo $this->Html->div(null,  $data['College']['description'], array('style'=>'padding:5px'));

$str = str_replace('@', '<img src="img/static/at_symbol.gif" alt="arroba" />', $data['College']['email']);
echo $this->Html->para(null, __('Contact us').  ': '.$str);

# ? > EOF