<?php
#debug($this->data);
echo $this->Html->div('divblock');
echo $this->Form->create('Scorm', array('url'=>'/admin/scorm/scorms/update'));
echo $this->Form->hidden('ScormVclassroom.vclassroom_id');
echo $this->Form->hidden('ScormVclassroom.id');
echo $this->Form->hidden('ScormVclassroom.popup', array('value'=>'1'));

echo $this->Form->label('ScormVclassroom.test_id', 'Scorm');
echo $this->Form->input('ScormVclassroom.sdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Starting date')));
echo $this->Form->input('ScormVclassroom.fdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Finishing date')));
echo $this->Form->input('ScormVclassroom.hidden', array('type'=>'checkbox', 'label'=>__('Show this Kandie only between start and finish date')));

echo $this->Form->end(__('Save'));
echo '</div>';

# ? > EOF