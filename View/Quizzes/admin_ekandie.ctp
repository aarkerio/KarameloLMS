<?php
#debug($this->data);
echo $this->Html->div('divblock');
  echo $this->Form->create('Test', array('controller'=>'tests', 'action'=>'update'));
  echo $this->Form->hidden('TestVclassroom.vclassroom_id');
  echo $this->Form->hidden('TestVclassroom.id');
  echo $this->Form->hidden('TestVclassroom.popup', array('value'=>'1'));

  echo $this->Form->label('TestVclassroom.test_id', __('Test'));
  echo $this->Form->input('TestVclassroom.sdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Starting date')));
  echo $this->Form->input('TestVclassroom.fdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Finishing date')));

  echo $this->Form->input('TestVclassroom.hidden', array('type'=>'checkbox', 'label'=> __('Show this Kandie only between start and finish date'), 'value'=>'1'));

  echo $this->Form->end(__('Save'));
  echo '</div>';

# ? > EOF

