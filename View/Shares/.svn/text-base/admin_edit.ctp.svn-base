<?php
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb(__('Shares'), '/admin/shares/listing');
echo $this->Html->getCrumbs(' > ');
echo $this->Form->create('Share', array('action'=>'edit')); 
echo $this->Gags->maxUploadSize();
?>
  <fieldset>
     <legend><?php __('Edit'); ?></legend>
     <?php 
     echo $this->Form->input('Share.description', array('size'=>50, 'label'=> __('Description'), 'class'=>'required'));
     echo $this->Form->input('Share.subject_id', array('label'=> __('Subject'), 'options'=>$subjects));
     echo $this->Form->input('Share.knet',   array('type'=>'checkbox', 'value'=>'1', 'label'=> __('Share in Knet')));
     echo $this->Form->input('Share.public', array('type'=>'checkbox', 'value'=>'1', 'label'=> __('Public')));
     echo $this->Form->input('Share.status', array('type'=>'checkbox', 'value'=>'1', 'label'=> __('Published')));
     echo $this->Html->para(null, $this->Form->end(__('Save')));
    ?>
</fieldset>
</div>
