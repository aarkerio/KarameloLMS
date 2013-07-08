<?php 
$this->set('title_for_layout',__('News Category'));

echo $this->Html->div('title_portal', $data[0]['Theme']['theme']); 
echo '<div style="margin:15px auto 0 auto;width:500px;text-align:center;">';
echo $this->Html->image('themes/'.$data[0]['Theme']['img'], array('alt'=>$data[0]['Theme']['theme'], 'title'=>$data[0]['Theme']['theme'], 'class'=>'themes'));
?>
</div>
<div style="margin:25px">
<ul>
<?php
foreach( $data as $val):
    echo '<li style="padding:4px">' . $this->Html->link($val['News']['title'], '/news/view/'.$val['News']['id']) . '</li>'; 
endforeach;
?>
</ul>
</div>
<?php
$t  = $this->Html->div(Null,$this->Paginator->prev('« '.__('Previous'). ' ',Null,Null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
$t .= $this->Html->div(Null, $this->Paginator->next(' '.__('Next'). ' »', Null, Null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
$t .= $this->Html->div(Null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
echo  $this->Html->div(Null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));

# ? > OEF