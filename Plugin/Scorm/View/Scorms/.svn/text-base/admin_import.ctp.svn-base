<?php 
 $this->set('title_for_layout', __('Import SCORM'));
 $helps = $this->Session->read('Auth.User.helps');
 $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
 $this->Html->addCrumb('SCORMs', '/admin/scorm/scorms/listing');
 echo $this->Html->getCrumbs(' > ');  
 echo $this->Html->div('title_section', __('Import SCORM'));

 echo $this->Gags->maxUploadSize();
 echo $this->Form->create('Scorm', array('action'=>'add','enctype'=>'multipart/form-data'));
?>
<fieldset>
  <legend><?php __('Import zip file '); ?></legend>  
<?php 
 echo $this->Form->input('Scorm.name'); 
 echo $this->Form->input('Scorm.summary', array('cols'=>20, 'rows'=>4, 'label,'=>__('Description')));
 echo $this->Form->input('Scorm.file', array('type'=>'file', 'label'=>__('ZIP File')));

 echo $this->Gags->helps('Defines max number of attempts student can do', $helps, True);
 echo $this->Form->input('Scorm.maxattent',array('options'=>array(1=>1,2=>2,3=>3,4=>4,5=>5,0=>__('Unlimited')),'label'=>__('Max number of attemtps')));
 echo $this->Form->input('Scorm.knet', array('type'=>'checkbox', 'label'=> __('Share on Knet')));
 echo $this->Form->input('Scorm.status', array('type'=>'checkbox', 'label'=> __('Published'))); 
   
 echo $this->Form->end(__('Upload')); 
?>
</fieldset>
