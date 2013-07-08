<?php
#die(debug($data));
$this->set('title_for_layout', __('Quizz test') . ' ' .$data['Test']['title']);

echo $this->Html->para(Null, 'hi! '.$this->Session->read('Auth.User.username'), array('style'=>'font-weight:bold;font-size:12pt;'));

echo '<h1>'. $data['Test']['title'] . '</h1>';
echo $this->Html->para(Null, $data['Test']['description']);
echo $this->Form->create('Test',  array('id'=>'TestForm')); 

if (count($data['Question']) == 0):
    echo $this->Html->div('titentry', __('Oops, looks there is no questions in this Quizz test'));
endif;
$maxpoints     = (int) 0; 
$num_questions = (int) 0;
foreach ($data['Question'] as $val):
    $MultipleChoiceAndAnswers = False;
    if ( count($val['Answer']) > 0 and $val['type'] == 1):
        $MultipleChoiceAndAnswers = True;
        echo 'sadsadsad';
    endif;
    if ( $MultipleChoiceAndAnswers or $val['type'] == 2): # question actually have answers
        #exit(debug($val));
        $maxpoints += (int) $val['worth'];
        $num_questions++;
        echo '<div style="border:1px dotted gray;margin:3px;padding:6px 0 0 6px;" id="question_id">';  
        echo $this->Form->label($val['id'], __('Value').': '.$val['worth'].' '.__('points').'.<br /><b>'.$num_questions.'.- '.$val['question']);
        echo '</b><br /><br />';
        if ( $val['type'] == 1 ):
            $options = array(); # to build options radio buttons 
            foreach ($val['Answer'] as $v):
                $correct = $v['correct'] == 1 ?  'Correct ': 'Incorrect';
                $options[$v['id']] = $v['answer'] . '  <span class="'.$correct.'">'.__($correct).'</span>';
            endforeach;
            echo $this->Form->input($val['id'], array('type'=>'radio', 'options'=>$options, 'separator'=>'&nbsp;<br />', 'legend'=>False)).'<br /><br />';
        else:
            echo $this->Form->input($val['id'], array('type'=>'textarea', 'cols'=>70, 'rows'=>4, 'label'=>False));
        endif;
        if ( strlen($val['hint']) > 1):
                echo $this->Html->para(Null, '<b>'.__('Hint').':</b> '.$val['hint']);
        endif;
        echo '</div><!-- question_id -->';
    elseif ( !$MultipleChoiceAndAnswers ):
        echo $this->Html->div(Null, __('A Question is marked as Multile Choice but not answers are set, so I am not showing it'));
    endif;
endforeach;

echo $this->Html->para(Null, __('Top score').' : ' . $maxpoints);
echo $this->Form->hidden('maxpoints', array('value'=>$maxpoints));
echo $this->Form->end(__('Send'));


echo $this->Html->scriptStart();
?>
$(document).ready( function() {
        $('#TestForm').submit( function() {
                alert('This is a Quizz Test preview');
                return false;
            });
    });
<?php
echo $this->Html->scriptEnd();
# ? > EOF
