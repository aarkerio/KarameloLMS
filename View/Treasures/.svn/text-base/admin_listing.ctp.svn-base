<?php
#die( debug( $data ));
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
echo $this->Html->getCrumbs(' > ');

echo $this->Html->div('title_section', $this->Html->image('thunt.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Scavenger hunts'), 'title'=>__('Sacavenger hunts'))).' '.__('Scavenger hunts'));

echo $this->Html->para(Null, 
                $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))), '/admin/treasures/edit', 
                           array('escape'=>False)));

echo '<table class="tbadmin">';
if ($data):
    $th = array (__('Edit'),__('Title'),__('Points'),__('Secret'),__('Preview'), __('Status'),__('Delete'));
    echo $this->Html->tableHeaders($th);
endif;
foreach ($data as $val):
  if ($val['Treasure']['status'] == 1):
      $img   = 'static/status_1_icon.png';
      $st    = __('Published');
  else:
      $img   = 'static/status_0_icon.png';
      $st    = __('Draft');
  endif;

  $tr = array(
              $this->Gags->sendEdit($val['Treasure']['id'], 'treasures'),
              $val['Treasure']['title'],
              $val['Treasure']['points'],
              $this->Html->image('static/icon_password.gif', array('alt'=> $val['Treasure']['secret'], 'title'=> $val['Treasure']['secret'])),
              $this->Html->link($this->Html->image('static/eye_icon.gif', array('alt'=>__('Preview'), 'title'=>__('Preview'))), '#', array('onclick'=>"javascript:window.open('/admin/treasures/view/".$val['Treasure']['id']."', 'blank', 'toolbar=no, scrollbars=yes,width=700,height=500')", 'escape'=>False)),
              $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
                          '/admin/treasures/change/'.$val['Treasure']['id'].'/'.$val['Treasure']['status'], array('escape'=>False)),
              $this->Gags->confirmDel($val['Treasure']['id'], 'treasures')
            );
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow); 
endforeach;

echo '</table>';

# ? > EOF
