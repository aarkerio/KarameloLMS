<?php 
$name =  $data['College']['name'];
echo $this->Html->div('title_portal', $name);
echo $this->Html->para(Null, $this->Html->image('static/'.$data['College']['logo'], array('title'=>$name, 'alt'=>$name)));
echo $this->Html->div(Null, $data['College']['description']);
$str = str_replace('@', '<img src="/img/static/at_symbol.gif" alt="arroba" />', $data['College']['email']);
echo $this->Html->para(null, __('Contact us').  ': '.$str);

# ? > EOF
