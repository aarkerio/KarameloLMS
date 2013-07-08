<?php
#die(var_dump($data));
$this->set('title_for_layout', __('Usefull links'));

echo $this->Html->div('title_section', $this->Html->image('ylinks.png', array('title'=>__('Usefull links'), 'alt'=>__('Usefull links'))).' '.$blogger['User']['username'] . '\'s '. __('Usefull links'));

if ( count($data) < 1 ):
    echo $this->Html->div(Null,__('Teacher has not published in this section'),array('style'=>'font-size:18pt;padding:4px;boder:1px solid #c0c0c0'));
endif;

foreach ($data as $val):
    $tmp  =  '<h2>'. $val['Acquaintance']['name']   . '</h2>';
    $tmp .= $this->Html->para(Null, nl2br($val['Acquaintance']['description']));
    $tmp .= $this->Html->para(Null,$this->Html->link($this->Html->image('static/icon_http.gif', array('alt'=>'Go!', 'title'=>'Go!')),
                              $val['Acquaintance']['url'], array('escape'=>False)));
    echo $this->Html->div(Null, $tmp, array('style'=>'padding:3px;border:1px dotted gray;margin:5px;padding:6px;'));
endforeach;

# ? > EOF