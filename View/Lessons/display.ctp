<?php
#die(debug($blog));
$this->set('title_for_layout', __('Lessons'));

echo $this->Html->div('title_section', $this->Html->image('static_pages.png', array('title'=>__('Lessons'), 'alt'=>__('Lessons'))).' '.__('Lessons'));

if ( count($data) < 1 ):
	echo $this->Html->div(Null, 'This teacher has not yet published lessons');
endif;

foreach ($data as $v):
    echo $this->Html->para(Null, '» '.$this->Html->link($v['Lesson']['title'], '/lessons/view/'.$blogger['User']['username'].'/'.$v['Lesson']['id'], 
                                       array("class"=>"title")));
endforeach;

$this->Paginator->options(array('url' => $blogger['User']['username']));

$t  = $this->Html->div(Null,$this->Paginator->prev('« '.__('Previous'),Null,Null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
$t .= $this->Html->div(Null,$this->Paginator->next(__('Next').' »', Null, Null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
$t .= $this->Html->div(Null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
echo  $this->Html->div(Null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));

# ? > EOF
