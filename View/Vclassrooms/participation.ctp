<?php
$lang = $this->Session->read('Auth.User.lang');
echo $this->Html->script(array('jquery.form', 'jquery.CKEditor', 'ckeditor/adapters/jquery'));
echo $this->Html->div(Null, Null, array('style'=>'margin:20px 5px 38px 5px;padding:5px;border:1px dotted gray;'));
echo $this->Html->div(Null, __('Write participation'), array('style'=>'margin:4px;font-size:12pt;font-weight:bold;'));
echo $this->Html->div(Null, __('participa'), array('style'=>'margin:8px;font-size:7pt;'));
 
echo $this->Form->create('Participation', array('action'=>'add', 'id'=>'partiForm', 'onsubmit'=>"return validateForm();")); 
echo $this->Form->hidden('Participation.vclassroom_id', array('value'=>$vclassroom_id)); 
echo $this->Form->hidden('Participation.blogger_id', array('value'=>$blogger_id));
echo $this->Form->hidden('Participation.blogger_username', array('value'=>$blogger_username));

echo $this->Form->input('Participation.activity_id', array('type'=>'select', 'between'=>': ', 'options'=>$activities, 'label'=>__('Activity'))).'<br />';
echo $this->Form->input('Participation.title', array('size'=>40, 'maxlength'=>80, 'label'=>__('Title'), 'between'=>': ')).'<br />';
echo $this->Form->textarea('Participation.participation', array('cols'=>50, 'rows'=>15, 'label'=>__('Write'))); 
echo $this->Html->scriptBlock("$('textarea#ParticipationParticipation').ckeditor({ toolbar:'Basic', lang:'$lang',width:400, height:300 });");
echo $this->Form->end(__('Send'));

echo '</div>';

echo $this->Html->scriptStart();
?>

function validateForm ()
{
    
    var title = document.getElementById('ParticipationTitle').value;
    
    if ( title.length < 4 )
    {
        alert ('<?php __('Please write the participation title'); ?>');
        return false;
    }

    return true;
}
<?php
echo $this->Html->scriptEnd();
# ? > EOF