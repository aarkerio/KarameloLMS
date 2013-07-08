<?php
 echo $this->Form->create('Topic',               array('action'=> 'add', 'onsubmit'=>'return chkForm();'));
 echo $this->Form->input('Topic.forum_id',      array('type'=>'hidden', 'value' => $forum_id));
 echo $this->Form->input('Topic.blogger_id',    array('type'=>'hidden', 'value' => $blogger_id));
 echo $this->Form->input('Topic.vclassroom_id', array('type'=>'hidden', 'value' => $vclassroom_id));
?>
<fieldset>
  <legend><?php __('New topic'); ?></legend>
<?php 
  echo $this->Form->input('Topic.subject', array('size' => 30, 'maxlength' => 60, 'label'=>__('Title'), 'between'=>': <br />', 'class'=>'required'));
  echo $this->Form->input('Topic.message', array('rows' => 7, 'cols' => 60,'class'=>'required', 'label'=>False ));
  echo $this->Form->end(__('Save'));
  echo '</fieldset>';
# ? > EOF
