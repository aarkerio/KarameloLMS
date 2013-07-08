<?php
#die(debug($data));
$this->set('title_for_layout', __('Gap fillings'));

$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb(__('Gap fillings'), '/admin/gaps/listing');
echo $this->Html->getCrumbs(' > ');

echo $this->Html->div('title_section', __('vClassrooms'));

$vclasses = array();   # contains id(s) from vclassroom(s) already linked to this gap

foreach ( $gaps as $gap):
     $vclasses[$gap['GapsVclassroom']['id']] = $gap['GapsVclassroom']['vclassroom_id'];
endforeach;

foreach ( $data as $val):
    if ( !in_array($val['Vclassroom']['id'], $vclasses) ):
        $tmp  = $this->Html->para(Null, $this->Html->image('admin/link.gif').$val['Vclassroom']['name']);
        $tmp .= $this->Form->create('Gap', array('action'=>'link2class'));
        $tmp .= $this->Form->hidden('GapsVclassroom.gap_id', array('value'=>$gap_id));
        $tmp .= $this->Form->hidden('GapsVclassroom.vclassroom_id', array('value'=>$val['Vclassroom']['id']));
        $tmp .= $this->Form->end(__('Assign this Gap filling'));
    else:
        $tmp = $this->Html->para(null, $this->Html->image('admin/unlink.gif').__('This gap is already assigned to vGroup') 
                        .'  <b>'.$val['Vclassroom']['name'].'</b>');
       
        foreach ( $gaps as $gap):
	        if ($gap['GapsVclassroom']['vclassroom_id'] == $val['Vclassroom']['id']):
	            $gapsvclasroom_id =  $gap['GapsVclassroom']['id'];
	        endif;   
        endforeach;

        $tmp .= $this->Form->create('Gap', array('action'=>'unlink2class'));
        $tmp .= $this->Form->hidden('GapsVclassroom.id', array('value'=>$gapsvclasroom_id));
        $tmp .= $this->Form->hidden('GapsVclassroom.gap_id', array('value'=>$gap_id));
        $tmp .= $this->Form->end(__('Unlink this gap'));
    endif;

    echo $this->Html->div('grayblock', $tmp); 
endforeach;

# ? > EOF
