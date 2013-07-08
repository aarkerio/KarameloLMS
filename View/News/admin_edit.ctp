<?php
  echo $this->Html->script('ckeditor/ckeditor');
  $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
  $this->Html->addCrumb(__('News'), '/admin/news/listing'); 
  echo $this->Html->getCrumbs(' > '); 

  echo $this->Form->create('News', array('action' => 'edit'));
  if ( isset($this->data['News']['id']) ): 
    echo $this->Form->hidden('News.id');
    $legend = __('Edit new');
  else:
    $legend = __('Add new');
  endif;
?>
<fieldset><legend><?php echo $legend; ?></legend>
<table>
<tr>
<td><?php echo $this->Form->input('News.title', array('size' => 40, 'maxlength' => 120, 'class'=>'required', 'label'=>__('Title'))); ?></td>
<td><?php echo $this->Form->input('News.theme_id', array('type'=>'select', 'label'=>__('Theme'))); ?>
</td>
<td><?php echo $this->Form->input('News.reference', array('size'=> 30, 'maxlength' => 340)); ?></td>
<td><?php echo $this->Gags->setImages(); ?></td>
</tr>
<tr><td colspan="4">
  <?php 
    echo $this->Form->input('News.body', array('cols'=>90, 'rows'=>35, 'class'=>'required', 'type'=>'textarea'));
    echo $this->Ck->load('NewsBody', 'Karamelo'); 
  ?>
</td></tr>
<tr>
<td><?php echo $this->Form->input('News.status', array('value'=>'1', 'type'=>'checkbox',  'label'=>__('Published'))); ?></td>
<td><?php echo $this->Form->input('News.comments',  array('value'=>'1', 'type'=>'checkbox', 'label'=>__('Allow comments'))); ?></td>
<td colspan="2">
<?php echo $this->Form->input('News.end',  array('value'=>'1', 'type'=>'checkbox','label'=> __('Finish edition'))); ?>
</td>
</tr>
<tr><td colspan="4"> <?php echo $this->Form->end(__('Save')); ?></td></tr>
</table>
</fieldset>
