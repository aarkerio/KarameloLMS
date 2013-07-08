<?php 
 echo $this->Html->script('ckeditor/ckeditor'); 
 $this->Html->addCrumb('Control Panel', '/admin/entries/start');
 $this->Html->addCrumb(__('Helps'), '/admin/helps/listing');  
 echo $this->Html->getCrumbs(' > '); 

 echo $this->Form->create('Help', array('action'=>'edit')); 
 if ( isset($this->data['Help']['id']) ):
     echo $this->Form->hidden('Help.id');
     $legend = __('Edit Help');
 else:
     $legend = __('New Help');
 endif;
?>
<fieldset>
<legend><?php echo $legend; ?></legend>
<table>
<tr><td>
<?php
    echo $this->Form->input('Help.title', array('size'=>40, 'maxlength'=>60, 'class'=>'required'));
    echo $this->Form->input('Help.url', array('size' => 30, 'maxlength' => 100,'class'=>'required')); 
  ?>
</td>
<td>
   <?php 
    $langs = array('en'=>'English', 'es'=>'Espanol', 'fr'=>'Francaise', 'de'=>'Deutsch');
    echo $this->Form->input('Help.lang', array('type'=>'select','label'=>__('Language'), 'options'=> $langs)); 
   ?>
</td>
<td>
<?php  echo $this->Gags->setImages(); ?>
</td>
</tr>

<tr><td colspan="3">
   <?php
   echo $this->Form->input('Help.help', array('cols'=>100, 'rows'=>25, 'class'=>'required'));
   echo $this->Ck->load('HelpHelp', 'Karamelo'); 
   ?>
</td></tr>
<tr>
<td colspan="3"><?php echo $this->Form->input('Help.end', array('type'=>'checkbox', 'label'=> __('Finish edition'))); ?></td>
</tr>
<tr><td colspan="3">
  <?php echo $this->Form->end(__('Save'));  ?>
</td></tr></table>
</fieldset>
