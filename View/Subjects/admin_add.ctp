<?php 
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb(__('Subjects'), '/admin/subjects/listing');
echo $this->Html->getCrumbs(' > ');
echo $this->Form->create('Subject'); 
?>
<fieldset>
  <legend><?php __('New Subject'); ?></legend>
  <?php 
    echo $this->Form->input('Subject.code', array('size' => 8, 'maxlength' => 8, 'label'=>__('Code')));
    echo $this->Form->input('Subject.title', array('size' => 40, 'maxlength' => 80, 'label'=>__('Title'))); 
    echo $this->Form->end(__('Save')); 
    echo '</fieldset>';
# ? > EOF

