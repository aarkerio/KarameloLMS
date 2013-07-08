<?php
 #die(debug($this->data));
if ( isset($this->data['Glossary']['id']) ):
     $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
     $this->Html->addCrumb(__('Glossaries'), '/admin/catglossaries/listing'); 
     $this->Html->addCrumb($this->data['Catglossary']['title'], '/admin/catglossaries/items/'.$this->data['Catglossary']['id']);
     echo $this->Html->getCrumbs(' > '); 
 endif;

 echo $this->Form->create('Glossary', array('action'=>'edit'));   

if ( isset($this->data['Glossary']['id']) ):
    echo $this->Form->input('Glossary.id', array('type'=>'hidden'));
    echo $this->Form->input('Glossary.catglossary_id', array('type'=>'hidden'));
    $legend =  __('Edit item');
 else:
    echo $this->Form->input('Glossary.catglossary_id', array('type'=>'hidden','value'=>$catglossary_id)); 
    $legend =  __('New item');
 endif;
?>
<fieldset>
  <legend><?php echo $legend ?></legend>
  <?php 
   echo $this->Form->input('Glossary.item', array('size' => 30, 'maxlength' => 90, 'class'=>'required'));
   echo $this->Form->input('Glossary.definition', array('cols'=>100,'rows'=>15,'type'=>'textarea','class'=>'required','label'=>__('Definition')));
   echo $this->Form->input('Glossary.end', array('type'=>'checkbox', 'label' => __('Finish edition'))); 
   echo $this->Form->submit(__('Save')); 
   echo '</fieldset>';

# ? > EOF