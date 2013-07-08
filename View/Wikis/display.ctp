<?php
#die(debug($blog));
$this->set('title_for_layout', __('WikiPages'));

echo $this->Html->div('title_section', $this->Html->image('wikis.png', array('title'=>'WikiPages', 'alt'=>'WikiPages')).' '.'WikiPages');

if ( count($data) < 1 ):
	  echo $this->Html->div(null, __('This teacher has not yet published WikiPages'));
endif;

foreach ($data as $v):
      echo $this->Html->para(null, '>> '.$this->Html->link($v['Wiki']['title'], '/wikis/view/'.$blogger['User']['username'].'/'.$v['Wiki']['slug'], 
                                                          array('class'=>'title')));
endforeach;

$this->Paginator->options(array('url' => $blogger['User']['username']));

$t  = $this->Html->div(Null,$this->Paginator->prev('« '.__('Previous'),Null,Null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
$t .= $this->Html->div(Null,$this->Paginator->next(__('Next').' »', Null, Null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
$t .= $this->Html->div(Null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
echo  $this->Html->div(Null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));

# ? > EOF
