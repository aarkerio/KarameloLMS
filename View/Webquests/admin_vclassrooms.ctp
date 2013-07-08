<?php
#die(debug($wq));
$this->set('title_for_layout',  $webq['Webquest']['title']); # page title
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb('Webquests', '/admin/webquests/listing');
echo $this->Html->getCrumbs(' > ');

echo $this->Html->div('title_section', $webq['Webquest']['title']);

$vclasses = array();   # contains vclassroom already linked to this webquest

foreach ( $webquests as $wq):
    $vclasses[$wq['VclassroomsWebquest']['id']] = $wq['VclassroomsWebquest']['vclassroom_id'];
endforeach;

# die(debug($vclasses)); 

foreach ( $data as $val):
    echo $this->Html->div('grayblock');
    if ( !in_array($val['Vclassroom']['id'], $vclasses) ):
        echo $this->Html->para(Null, $this->Html->image('admin/link.gif').$val['Vclassroom']['name']);
        echo $this->Form->create('Webquest', array('action'=>'link2class'));
        echo $this->Form->hidden('VclassroomsWebquest.webquest_id', array('value'=>$webq['Webquest']['id']));
        echo $this->Form->hidden('VclassroomsWebquest.vclassroom_id', array('value'=>$val['Vclassroom']['id']));
        echo $this->Form->end(__('Assign this Webquest'));
    else:
        echo $this->Html->para(Null, $this->Html->image('admin/unlink.gif').'This webquest is already assigned to  <b>'.$val['Vclassroom']['name'].'</b>');
       
        foreach ( $webquests as $wq):
            if ($wq['VclassroomsWebquest']['vclassroom_id'] == $val['Vclassroom']['id']):
	            $id =  $wq['VclassroomsWebquest']['id'];
	        endif;   
        endforeach;

        echo $this->Form->create('Webquest', array('action'=>'unlink2class'));
        echo $this->Form->hidden('VclassroomsWebquest.id', array('value'=>$id));
        echo $this->Form->hidden('VclassroomsWebquest.webquest_id', array('value'=>$webq['Webquest']['id'])); # used for return here
        echo $this->Form->end(__('Unlink this Webquest'));
    endif; 
   echo '</div>';
endforeach;

# ? > EOF