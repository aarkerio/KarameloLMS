<?php 
  $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
  $this->Html->addCrumb(__('Forums'), '/admin/catforums/listing'); 
  echo $this->Html->getCrumbs(' > ');
?>
<fieldset>
<legend><?php __('Edit forums category'); ?></legend>
<?php
  echo $this->Form->create('Catforum'); 
  echo $this->Form->hidden('Catforum.id');
  echo $this->Form->input('Catforum.title', array('size'=>60, 'maxlength'=>90, 'class'=>'required'));
  echo $this->Form->input('Catforum.description', array('size' => 60, 'maxlength' => 90, 'class'=>'required'));
  echo $this->Form->end(__('Save')); 
?>
</fieldset>