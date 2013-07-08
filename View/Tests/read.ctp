<?php
#debug($answers);
$linked = $data['t']['TestVclassroom'];
$data   = $data[0]; # dirty trick
$this->set('title_for_layout', __('Test') .' '.$data['Test']['title']);
# No crum here!!

# student belongs to vclassroom, kandie is in correct date and test has not been answered by student
if ( $permissions['belongs'] == True and $permissions['chkdate'] == True and $permissions['already'] == False): 
    echo $this->Html->para(Null, 'hi! '.$this->Session->read('Auth.User.username'), array('style'=>'font-weight:bold;font-size:12pt;'));
    echo $this->Html->div('title', $blogger['User']['username'] .'s '.__('Quizz Test'));
    echo $this->Html->div('mes',__('Start date').': '.$linked['sdate']);
    echo $this->Html->div('mes',__('Finish date').': '.$linked['fdate']);
    echo '<h1>'. $data['Test']['title'] . '</h1>';
    echo $this->Html->para(Null, $data['Test']['description']);
    echo $this->Html->div('title', __('Confirmation screen, check your answers before send it'), array('style'=>'color:red;font-size:16pt;font-weight:bold;'));
    echo $this->Html->div(Null, __('Please click back button to change answers')); 
    $msg = __('Are you sure?');
    echo $this->Form->create('Test',          array('action'=>'result', 'onsubmit'=>"return confirm('$msg')")); 
    echo $this->Form->hidden('test_id',       array('value'=>$data['Test']['id']));
    echo $this->Form->hidden('blogger',       array('value'=>$blogger['User']['username']));
    echo $this->Form->hidden('vclassroom_id', array('value'=>$linked['vclassroom_id']));

    $maxpoints     = (int) 0; 
    $num_questions = (int) 0; 
    foreach ($data['Question'] as $val):
        if ( count($val['Answer']) > 0 || $val['type'] == 2): # question actually have answers
            #exit(debug($val));
            $maxpoints += (int) $val['worth'];
            $num_questions++;
            echo '<div style="border:1px dotted gray;margin:3px;padding:6px 0 0 6px;">';  
            echo $this->Form->label($val['id'], __('Value').' '.$val['worth'].' '.__('points').'.<br /><b>'.$num_questions.'.- '.$val['question']);
            echo '</b><br /><br />';
            if ( $val['type'] == 1 ): # multiple option
                $options = array(); # to build options radio buttons 
                foreach ($val['Answer'] as $v):
                    $options[$v['id']] = $v['answer'];
                endforeach;
                # In next line we use $answer array to set default in radio array
                # see: http://book.cakephp.org/view/1429/radio
                echo $this->Form->radio($val['id'], $options, array('separator'=>'&nbsp;<br />','default'=>$answers[$val['id']],'legend'=>False,
                                                         'disabled'=>'disabled')) . '<br /><br />';
                echo $this->Form->input($val['id'], array('type'=>'hidden', 'value'=>$answers[$val['id']])); # this is for "disable" option in radio button
            else:   # open question
                echo $this->Form->input($val['id'],array('type'=>'textarea','cols'=>70,'rows'=>4,'label'=>False,'readonly'=>'readonly','value'=>$answers[$val['id']]));
            endif;
            
            if ( strlen($val['hint']) > 1): # if teacher give hints
                echo $this->Html->para(Null, '<b>'.__('Hint').':</b> '.$val['hint']);
            endif;
            echo '</div>';
        endif;
    endforeach;

    echo $this->Html->para(Null, __('Top score').' : ' . $maxpoints);
    echo $this->Form->hidden('maxpoints', array('value'=>$maxpoints));
    echo $this->Html->para(Null, $this->Form->end(__('Send')));

else:
    echo $this->element('permissions', array('permissions'=>$permissions, 'dates'=>$linked, 'kandie_user_id'=>$blogger['User']['id']));
endif;

# ? > EOF
