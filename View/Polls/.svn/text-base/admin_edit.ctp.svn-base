<div class="image-info">
<?php echo $this->Form->create('Poll'); ?>
<fieldset>
<legend><?php __('Edit Poll'); ?></legend>
<?php
  echo $this->Form->hidden('Poll.id');
  echo $this->Form->input('Poll.question', array('size'=>60, 'maxlength'=>90)); 
?>
<br />
<br />
<?php 
# echo $this->Form->label('Poll.question', __('Answers')) . '<br />';
# print_r($this->data);
foreach ($this->data['Pollrow'] as $val):
    echo $this->Form->input('Poll.answer', array('size'=>60, 'maxlength'=>90, 'value'=>$val['answer']));
endforeach;
?>
<br />
<?php echo $this->Form->input('Poll.status', array('type'=>'checkbox', 'label'=>__('Published'))); ?>
<br /><br />
<p style="clear:both"></p></fieldset>
  <?php echo $this->Form->end(__('Save')); ?>
</div>