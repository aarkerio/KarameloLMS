<?php
 echo $this->Form->create('Topic');
 echo $this->Form->input('Topic.subject', array('size'=>50, 'maxlength'=>150, 'class'=>'required'));
 echo $this->Form->input('Topic.message', array('rows'=>50, 'columns'=>50, 'type'=>'textarea'));
 echo $this->Ck->load('TopicMessage', 'Karamelo', $this->Session->read('Auth.User.lang'));
 echo $this->Form->input('Topic.status', array('type'=>'checkbox', 'value'=>'1'));
 echo $this->Form->end(__('Save'));

# ? > EOF