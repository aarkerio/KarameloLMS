<?php
echo $this->Html->script(array('ckeditor/ckeditor','myfunctions'));

$this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
$this->Html->addCrumb('FAQs', '/admin/catfaqs/listing');  
$this->Html->addCrumb($this->data['Catfaq']['title'], '/admin/faqs/listing/'.$this->data['Catfaq']['id']);
echo $this->Html->getCrumbs(' > ');

echo $this->Form->create('Faq', array('action'=>'edit')); 
echo $this->Form->hidden('Faq.catfaq_id');
echo $this->Form->hidden('Faq.id'); 
?>
<fieldset>
   <legend><?php echo __('Edit FAQ');?></legend>
<?php 
 echo $this->Form->input('Faq.question', array('size' => 40, 'maxlength' => 50, 'label'=>__('Question'), 'class'=>'required')); 
 echo $this->Form->input('Faq.answer', array('cols'=>70, 'rows'=>40, 'type'=>'textarea', 'label' => __('Answer')));
 echo $this->Ck->load('FaqAnswer', 'Karamelo', $this->Session->read('Auth.User.lang'));
 echo $this->Form->input('Faq.status', array('type'=>'checkbox', 'label' => __('Published')));
 echo $this->Form->input('Faq.end', array('type'=>'checkbox', 'label' => __('End edition')));
 echo $this->Form->end(__('Save')); 
 echo '</fieldset>';

# ? > EOF
