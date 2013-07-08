<?php
$this->set('title_for_layout', $blogger['User']['username']. '\'s Edublog');
#die(debug($data));
if ( count($data) < 1 ):
    echo $this->Html->div('titentry', __('This teacher has not yet published on his/her blog'));
endif;

foreach ($data as $val):
     echo $this->element('one_entry', array('cache' => False, 'val'=>$val, 'comments'=>False));
endforeach;

$this->Paginator->options(array('url' => $blogger['User']['username']));

$t  = $this->Html->div(Null,$this->Paginator->prev('« '.__('Previous'),Null,Null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
$t .= $this->Html->div(Null,$this->Paginator->next(__('Next').' »', Null, Null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
$t .= $this->Html->div(Null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
echo  $this->Html->div(Null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));

# ? > EOF
