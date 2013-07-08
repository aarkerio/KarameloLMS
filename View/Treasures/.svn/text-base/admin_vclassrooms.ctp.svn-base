<?php
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb(__('Scavengers hunts'), '/admin/treasures/listing');
echo $this->Html->getCrumbs(' > ');
 
$vclasses = array();   # contains vclassroom already linked to this treasure

foreach ( $treasures as $wq):
     $vclasses[$wq['TreasuresVclassroom']['id']] = $wq['TreasuresVclassroom']['vclassroom_id'];
endforeach;

# die( debug( $vclasses ) ); 

foreach ( $data as $val):
  if ( !in_array($val['Vclassroom']['id'], $vclasses) ):
    $tmp  = $this->Html->para(null, $this->Html->image('admin/link.gif').$val['Vclassroom']['name']); 
    $tmp .= $this->Form->create('Treasure', array('action'=>'link2class'));
    $tmp .= $this->Form->hidden('TreasuresVclassroom.treasure_id', array('value'=>$treasure_id));
    $tmp .= $this->Form->hidden('TreasuresVclassroom.vclassroom_id', array('value'=>$val['Vclassroom']['id']));
    $tmp .= $this->Form->end(__('Assign this Treasure'));
   else:
    $tmp = $this->Html->para(null, $this->Html->image('admin/unlink.gif').' '.__('This scavenger is already assigned to').'  <b>'.$val['Vclassroom']['name'].'</b>');
       
    foreach ( $treasures as $wq):
             if ($wq['TreasuresVclassroom']['vclassroom_id'] == $val['Vclassroom']['id']):
	             $id =  $wq['TreasuresVclassroom']['id'];
	     endif;   
    endforeach;

    $tmp .= $this->Form->create('Treasure', array('action'=>'unlink2class'));
    $tmp .= $this->Form->hidden('TreasuresVclassroom.id', array('value'=>$id));
    $tmp .= $this->Form->hidden('TreasuresVclassroom.treasure_id', array('value'=>$treasure_id)); //used for return here
    $tmp .= $this->Form->end(__('Unlink this treasure'));
  endif;

  echo $this->Html->div('grayblock', $tmp);
endforeach;

# ? > EOF