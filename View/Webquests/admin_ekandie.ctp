<?php
  #debug($this->data); 
  echo $this->Html->div('divblock');
  echo $this->Form->create('Webquest', array('controller'=>'webquest', 'action'=>'update'));
  echo $this->Form->hidden('VclassroomWebquest.vclassroom_id');
  echo $this->Form->hidden('VclassroomWebquest.id');
  echo $this->Form->hidden('VclassroomWebquest.popup', array('value'=>'1'));

  echo $this->Form->label('VclassroomWebquest.test_id', __('Test'));
 
  echo $this->Form->input('VclassroomWebquest.sdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Starting date')));
  echo $this->Form->input('VclassroomWebquest.fdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Finishing date')));

  echo $this->Form->input('VclassroomWebquest.hidden', array('type'=>'checkbox', 'label' => __('Show this Kandie only between start and finish date')));

  echo $this->Form->end(__('Save'));

  echo '</div>';
# ? > EOF
