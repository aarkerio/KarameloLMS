<?php
#debug($xtradata);
$correct = (int) 0;
echo '<h2>' . __('Answers') . '</h2>';
foreach ($data as $k => $v):
    if ( $v['s1'] == $v['s2']):
        $ans = __('Correct')  .' '.$this->Html->image('static/img_correct.gif', array('alt'=>'Correct'));
        $correct++;
    else:
        $ans = __('Incorrect').' '.$this->Html->image('static/img_incorrect.gif', array('alt'=>'Incorrect'));         
    endif;
    echo $this->Html->div(Null, __('Answer to sentence number') . ' <b>'. $k . '</b> ' . __('is') . ' '. $ans); 
endforeach;

# next form only if all answers are correct
if (count($data) == $correct):
    echo $this->Form->create('Gap', array('action'=>'save'));
    echo $this->Form->hidden('ResultGap.vclassroom_id', array('value'=>$xtradata['vclassroom_id']));
    echo $this->Form->hidden('ResultGap.gap_id',        array('value'=>$xtradata['gap_id']));
    echo $this->Form->hidden('ResultGap.blogger_id',    array('value'=>$xtradata['blogger_id']));
    echo $this->Form->hidden('ResultGap.blogger',    array('value'=>$xtradata['blogger']));
    echo $this->Form->end(__('Finish exercise') );
endif;

# ? > EOF
