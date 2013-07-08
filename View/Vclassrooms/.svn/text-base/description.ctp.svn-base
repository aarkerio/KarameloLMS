<?php
$img = $this->Html->div(null, $this->Html->link($this->Html->image('static/icon_hide.gif', array('alt'=>__('Hide'), 'title'=>__('Hide'))), 
                                                '#vcimg', array('onclick'=>'hideCourse()', 'escape'=>False)));

$hours = ($minutes / 60);
$hours = number_format($hours, 2, '.', ' ');
$tmp   = $this->Html->div(Null, '<b>'.__('Hours').'</b>: '.$hours);
echo $this->Html->div(Null, $tmp . $description . $img, array('style'=>'margin:4px;padding:4px;border:1px solid orange;'));

# ? > EOF