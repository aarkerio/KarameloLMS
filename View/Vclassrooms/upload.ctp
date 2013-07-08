<div style ="margin:25px 5px">
<?php
 echo '<b>'.$this->Gags->maxUploadSize().'</b>';

 echo $this->Form->create('Report', array('action'=>'add', 'enctype'=>'multipart/form-data', 'onsubmit'=>"return validateForm();"));
 echo $this->Form->hidden('Report.vclassroom_id', array('value'=>$vclassroom_id));
 echo $this->Form->hidden('Report.blogger_id', array('value'=>$blogger_id));
 echo $this->Form->hidden('Report.blogger_username', array('value'=>$blogger_username));
?>
 <fieldset>
   <legend><?php __('Upload file'); ?></legend> 
<?php
 echo $this->Form->input('Report.activity_id', array('type'=>'select', 'between'=>': ', 'options'=>$activities, 'label'=>__('Activity'))).'<br />';
 echo $this->Form->input('Report.file',        array('type'=>'file', 'between'=>': ', 'label'=> __('File'))).'<br />';
 echo $this->Form->input('Report.description', array('size'=>40, 'maxlength'=>40, 'between'=>': ','label'=>__('Description')));
 echo $this->Form->end(__('Upload')); 

echo '</fieldset>';
echo '</div>';

echo $this->Html->scriptStart();
?>

function validateForm ()
{
    
    var title = document.getElementById('ReportDescription').value;
    var file  = document.getElementById('ReportFile').value;
    //alert(file);
    if ( file.length < 4 )
    {
        alert ('<?php __('Please select a file'); ?>');
        return false;
    }
    if ( title.length < 4 )
    {
        alert ('<?php __('Please describe the file you are uploading'); ?>');
        return false;
    }

    return true;
}
<?php
echo $this->Html->scriptEnd();
# ? > EOF
