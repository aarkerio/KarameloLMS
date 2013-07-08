<?php echo $this->Form->create('Webquest', array('onsubmit'=>'return validateWebquest()', 'action'=>'add')); ?>
<fieldset>
<legend><?php echo __('New') . ' Webquest'; ?></legend>
<?php 
  echo $this->Form->input('Webquest.title', array('size'=>40, 'maxlength'=>150, 'label'=>__('Title')));
  echo $this->Form->input('Webquest.value', array('type'=>'select', 'label'=>__('Points'), 'options'=>range(1,20)));
  echo $this->Form->input('Webquest.knet', array('type'=>'checkbox', 'label'=>__('Share in Knet network')));
  echo $this->Form->end(__('Save')); 
  echo '</fieldset>';

# ? > EO