<?php
#die(print_r($data));
$this->set('title_for_layout', __('Shares'));

echo $this->Html->div('title_section', $this->Html->image('mmultimedia.png', array('title'=>__('Shared'), 'alt'=>__('Shared'))).' '.$blogger['User']['username'] . '\'s '. __('Shared files'));

if ( count($data) < 1):
    echo $this->Html->para('title', __('Teacher does not have any resource yet')); 
endif;

foreach ($data as $v):
    $tmp  = $this->Html->link($this->Html->image('static/shares-icon.png', array('alt'=>__('Download'), 'width'=>'50', 'title'=>__('Download'))),'/shares/download/'.$v['Share']['secret'], array('escape'=>False)).' ';
    $d = Sanitize::clean($v['Share']['description']);
    $tmp .= '<br><b>'.__('Description').': </b>'.$this->Html->link($d, '/shares/download/'.$v['Share']['secret'], array('escape'=>False));
    $tmp .= $this->Html->link($this->Html->image('static/button_download.gif', array('alt'=>$v["Share"]["description"], 'title'=>$v['Share']['description'])), '/shares/download/'.$v['Share']['secret'], array('escape'=>False));
    $tmp .= '<br><b>Mime Type: </b>'.$this->Mime->getMimeType(getcwd().'/files/userfiles/'.$v['Share']['file']);
    echo $this->Html->div(Null,$tmp,array('style'=>'padding:6px;margin:4px;border:1px dotted orange;vertical-align:middle;width:90%;')); 
endforeach;

$this->Paginator->options(array('url' => $blogger['User']['username']));
$t  = $this->Html->div(null,$this->Paginator->prev('« '.__('Previous'),null,null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
$t .= $this->Html->div(null,$this->Paginator->next(__('Next').' »', Null, Null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
$t .= $this->Html->div(null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
echo  $this->Html->div(null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));

# ? > EOF
