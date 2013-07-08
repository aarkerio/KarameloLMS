<?php
 $this->Html->addCrumb('Control Panel', '/admin/entries/start');  
 $this->Html->addCrumb(__('Subjects'), '/admin/acquaintances/listing');  
 echo $this->Html->getCrumbs(' / ');  

 echo $this->Form->create('Subject'); 
 echo $this->Form->hidden('Subject.id');
?>
<fieldset>
  <legend><?php __('Edit subject'); ?></legend>
 <?php 
   echo $this->Form->input('Subject.code', array('size' => 8, 'maxlength' => 8));
   echo $this->Form->input('Subject.title', array('size' => 40, 'maxlength' => 80)); 
   echo  '<br />';
   echo $this->Form->end(__('Save')); 
?>
</fieldset>