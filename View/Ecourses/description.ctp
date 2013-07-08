<?php
#debug($data);
$hours = ($minutes / 60);
$hours = number_format($hours, 2, '.', ' ');
echo $this->Html->div(Null, '<b>'.__('Hours').'</b>: '.$hours);
echo $data;

/* echo '<fieldset><legend>'.__('Request Info for this course').'</legend>';
echo $this->Form->create('Ecourse', array('action'=>'ask'));
echo $this->Form->hidden('Ecourse.user_id', array('value'=>$data['Ecourse']['user_id']));
echo $this->Form->input('Ecourse.name',  array('size'=>50, 'maxlength'=>60));
echo $this->Form->input('Ecourse.email', array('size'=>50, 'maxlength'=>80));
echo $this->Form->end(__('Send'));
echo '</fieldset>'; */
# ? > EOF