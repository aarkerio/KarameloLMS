<?php
  #debug($this->data);
  echo $this->Html->div('divblock');
  echo $this->Form->create('Treasure', array('controller'=>'treasures', 'action'=>'update'));
  echo $this->Form->hidden('TreasureVclassroom.vclassroom_id');
  echo $this->Form->hidden('TreasureVclassroom.id');
  echo $this->Form->hidden('TreasureVclassroom.popup', array('value'=>'1'));

  echo $this->Form->label('TreasureVclassroom.test_id', __('Treasure'));
  echo $this->Form->input('TreasureVclassroom.sdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Starting date')));
  echo $this->Form->input('TreasureVclassroom.fdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Finishing date')));

  echo $this->Form->input('TreasureVclassroom.hidden', array('type'=>'checkbox', 'label'=>__('Show this Kandie only between start and finish date')));

  echo $this->Form->end(__('Save'));
  echo '</div>';

# ? > EOF
