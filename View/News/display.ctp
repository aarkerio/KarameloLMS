<?php
#die(debug($data));
$this->set('title_for_layout',  __('News'));
echo $this->Html->div('title_portal', __('News on Campus'));
foreach ($data as $val):
    echo $this->element('new', array('data'=>$val, 'comments'=>False));
endforeach;

echo  $this->Html->div('pagination');
echo $this->Html->div(Null, $this->Paginator->prev('«'. __('Previous').' ',Null,Null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
echo $this->Html->div(Null, $this->Paginator->next(' '.__('Next').'»', Null, Null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
echo $this->Html->div(Null, $this->Paginator->counter(), array('style'=>'width:200px;float:center'));
echo '</div><!-- div pagination ends -->';
# ? > EOF
 