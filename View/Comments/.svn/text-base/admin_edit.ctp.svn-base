<?php 
 echo $this->Html->script('ckeditor/ckeditor');  
 
 $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
 $this->Html->addCrumb(__('Comments'), '/admin/comments/listing');  
 echo $this->Html->getCrumbs(' > '); 

 echo $this->Form->create('Comment');
 echo $this->Form->hidden('Comment.id'); 
?>

<fieldset>
<legend><?php __('Edit help'); ?> </legend>
<?php
  echo $this->Form->input('Comment.comment', array('cols'=>80, 'rows'=>65 'label' => __('Comment'), 'type'=>'textarea'));
  echo $this->Ck->load('CommentComment', 'Karamelo', $this->Session->read('Auth.User.lang'), 700, 300);
  echo $this->Form->end(__('Save'));  
?>
</fieldset>