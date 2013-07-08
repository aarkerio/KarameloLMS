<?php echo $this->Form->create('Chat', array('action'=>'add')); ?>
  <fieldset>
     <legend><?php __('New chat'); ?></legend>
     <?php 
      echo $this->Form->input('Chat.vclassroom_id', array('type'=>'select', 'options'=>$vclassrooms, 'label'=> __('Subject'));
      echo $this->Form->input('Chat.status', array('type'=>'checkbox', 'label'=> __('Published')));
      echo $this->Form->end(__('Save'));    
      echo '</fieldset>';

# ? > EOF