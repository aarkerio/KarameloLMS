<?php
#teacher form to share vclassrooms
if ( $teachers ):
    echo $this->Form->create('Vclassroom', array('action'=>'share'));
    echo $this->Form->hidden('UserVclassroom.vclassroom_id', array('value'=>$vclassroom_id));
    echo $this->Form->input('UserVclassroom.user_id', array('type'=>'select', 'options'=>$teachers, 'label'=>__('Teachers')));
    echo $this->Form->end(array('label'=>__('Save')));
else:
    echo $this->Html->div(Null, __('There is no teacher to share!'));
endif;

# ? > EOF
