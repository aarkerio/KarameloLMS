<?php
#die(debug($data));
$this->set('title_for_layout', __('Quizz test') . ' ' .$data['Test']['title']);

$linked = $data['t']['TestVclassroom']; # linked vclassroom

echo $this->element('vccrumb', array('blogger'=> $blogger['User']['username'], 'vclassroom_id'=>$linked['vclassroom_id']));

# student belongs to vclassroom, kandie is in correct date and test has not been answered by student
if ( $permissions['belongs'] == True and $permissions['chkdate'] == True and $permissions['already'] == False): 
    echo $this->Html->para(Null, 'hi! '.$this->Session->read('Auth.User.username'), array('style'=>'font-weight:bold;font-size:12pt;'));
    echo $this->Html->para(Null, '<b>Tip</b>:'.__('Avoid data loss, first write and save your answers in a text editor and then copy and paste here').'.');
    echo $this->Html->div('title', $blogger['User']['username'] .'s '.__('Quizz Test'));
    echo $this->Html->div('mes',__('Start date').': '.$linked['sdate']);
    echo $this->Html->div('mes',__('Finish date').': '.$linked['fdate']);
    echo '<h1>'. $data['Test']['title'] . '</h1>';
    echo $this->Html->para(Null, $data['Test']['description']);
    echo $this->Form->create('Test',          array('action'=>'read')); 
    echo $this->Form->input('test_id',       array('type'=>'hidden', 'value'=>$data['Test']['id']));
    echo $this->Form->input('blogger',       array('type'=>'hidden', 'value'=>$blogger['User']['username']));
    echo $this->Form->input('vclassroom_id', array('type'=>'hidden', 'value'=>$linked['vclassroom_id']));
    
    if (count($data['Question']) == 0):
        echo $this->Html->div('titentry', __('Oops, looks there is no questions in this Quizz test'));
    endif;
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
            if ( $val['type'] == 1 ):
                $options = array(); # to build options radio buttons 
                foreach ($val['Answer'] as $v):
                    $options[$v['id']] = $v['answer'];
                endforeach;
                echo $this->Form->radio($val['id'], $options, array('separator'=>'&nbsp;<br />', 'legend'=>False)) . '<br /><br />';
            else:
                echo $this->Form->input($val['id'], array('type'=>'textarea', 'cols'=>70, 'rows'=>4, 'label'=>False));
            endif;
            if ( strlen($val['hint']) > 1):
                echo $this->Html->para(Null, '<b>'.__('Hint').':</b> '.$val['hint']);
            endif;
            echo '</div>'; 
        endif;
  endforeach;

  echo $this->Html->para(Null, __('Top score').' : ' . $maxpoints);
  echo $this->Form->hidden('maxpoints', array('value'=>$maxpoints));
  echo $this->Form->end(__('Send'));
else:
  echo $this->element('permissions', array('permissions'=>$permissions, 'dates'=>$linked, 'kandie_user_id'=>$blogger['User']['id']));
endif;

# ? > EOF
