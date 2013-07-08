s<?php 
 $helps = $this->Session->read('Auth.User.helps'); # helps enabled ?
 echo $this->Html->script('ckeditor/ckeditor'); 

 $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
 $this->Html->addCrumb(__('Newsletters'), '/admin/newsletters/listing'); 
 echo $this->Html->getCrumbs(' > '); 
 echo $this->Form->create('Newsletter', array('action'=>'edit'));

 if (!empty($this->data) && isset($this->data['Newsletter']['id'])): 
     echo $this->Form->hidden('Newsletter.id');
     $legend = __('Edit Newsletter');
 else:
     $legend = __('New Newsletter');
 endif;
?>
<fieldset>
<legend><?php echo $legend; ?></legend>
<table style="margin:0 auto 0 auto;">
<tr>
  <td><?php echo $this->Form->input('Newsletter.title', array('size' => 50, 'maxlength' => 50, 'class'=>'required')); ?></td>
 <td>
 <?php echo $this->Gags->setImages(); ?>
  </td>
  </tr>
  <tr><td colspan="2">
  <?php
   echo $this->Form->input('Newsletter.body', array('type'=>'textarea', 'cols'=>60, 'rows'=>17));
   echo $this->Ck->load('NewsletterBody', 'Karamelo', $this->Session->read('Auth.User.lang'), 900, 500);
  ?>
  </td>
</tr> 
<tr><td>
 <?php
    echo $this->Gags->helps('Select to set newsletter as published', $helps);
    echo $this->Form->input('Newsletter.status', array('type'=>'checkbox', 'label'=> __('Published'))); 
    
    echo $this->Gags->helps('Select to set newsletter as public, id est, any user can see it', $helps);
    echo $this->Form->input('Newsletter.public', array('type'=>'checkbox', 'label'=> __('Public')));
 ?>
</td><td>
<?php echo $this->Form->input('Newsletter.end', array('type'=>'checkbox', 'label'=> __('Finish edition'))); ?>
 </td>
 </tr>
  <tr><td colspan="2">
  </fieldset>
  <?php echo $this->Form->end(__('Save')); ?>
</td></tr>
</table>