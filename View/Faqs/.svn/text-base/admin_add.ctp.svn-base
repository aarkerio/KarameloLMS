<?php 
 echo $this->Form->create('Faq'); 
 echo $this->Form->hidden('Faq.catfaq_id', array('value'=>$catfaq_id)); 
?>
<fieldset>
   <legend><?php __('New Question/Answer');?></legend>  
<?php 
  echo $this->Form->input('Faq.question', array('size' => 50, 'maxlength' => 120, 'label'=>__('Question'), 'class'=>'required'));
  echo $this->Form->input('Faq.answer', array('type'=>'textarea', 'rows'=>15, 'cols'=>60, 'class'=>'required', 'label'=> __('Answer')));
  echo $this->Html->scriptBlock("$('textarea#FaqAnswer').ckeditor({ toolbar:'Basic', width:700, height:400 });");
  echo $this->Form->input('Faq.status', array('type'=>'checkbox', 'label' => __('Published')));
  echo $this->Form->end(__('Save')); 

  echo '</fieldset>';

# ? > eof