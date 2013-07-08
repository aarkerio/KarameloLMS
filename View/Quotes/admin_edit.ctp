<?php 
 $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
 $this->Html->addCrumb(__('Quotes'), '/admin/quotes/listing'); 
 echo $this->Html->getCrumbs(' > ');

 echo $this->Form->create('Quote'); 
 echo $this->Form->hidden('Quote.id');
?>
<fieldset>
<legend><?php __('Edit quote');?></legend>
 <?php 
   echo $this->Form->input('Quote.quote', array('size' => 60, 'maxlength' => 150));
   echo $this->Form->input('Quote.author', array('size' => 25, 'maxlength' => 70));
   echo $this->Form->end(__('Save'));  
?>
</fieldset>
