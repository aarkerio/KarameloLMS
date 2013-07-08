<?php
  #debug($this->data);
  echo $this->Html->div('divblock');
  echo $this->Form->create('Gap', array('controller'=>'gaps', 'action'=>'update'));
  echo $this->Form->hidden('GapVclassroom.vclassroom_id');
  echo $this->Form->hidden('GapVclassroom.id');
  echo $this->Form->hidden('GapVclassroom.popup', array('value'=>'1'));

  echo $this->Form->label('GapVclassroom.test_id', __('Gap'));
  echo $this->Form->input('GapVclassroom.sdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Starting date')));
  echo $this->Form->input('GapVclassroom.fdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Finishing date')));
  echo $this->Form->input('GapVclassroom.hidden', array('type'=>'checkbox', 'label'=>__('Show this Kandie only between start and finish date')));

  echo $this->Form->end(__('Save'));

  echo '</div>';

# ? > EOF
