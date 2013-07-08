<?php
# In this screen teacher can add a participation if some activty was made out of internet
$helps = $this->Session->read('Auth.User.helps'); # helps enabled ?
echo $this->Html->div(Null, Null, array('style'=>'margin:20px 5px 38px 5px;padding:5px;border:1px dotted gray;'));
echo $this->Html->div(Null, __('Add participation'), array('style'=>'margin:4px;font-size:12pt;font-weight:bold;'));
echo $this->Html->div(Null, __('If student made some test or activity outside Karamelo, here you can add points to student').'.', array('style'=>'margin:8px;font-size:7pt;'));
 
echo $this->Form->create('Participation', array('action'=>'add')); 
echo $this->Form->hidden('Participation.vclassroom_id', array('value'=>$vclassroom_id)); 
echo $this->Form->hidden('Participation.user_id', array('value'=>$student_id));
echo $this->Form->input('Participation.title', array('size'=>40, 'maxlength'=>80, 'label'=>__('Title')));

#Points
echo $this->Gags->helps('How many points activity worthed', $helps);
echo $this->Form->input('Participation.points', array('type'=>'select', 'options'=>range(0,50)));
echo $this->Form->textarea('Participation.participation', array('cols'=>50, 'rows'=>15)); 
echo $this->Form->end(__('Send')); 
# ? > EOF
