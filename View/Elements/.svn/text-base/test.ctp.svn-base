<?php
#debug($data);
# $next id question to show
$num_answers      = (int) 0;
$current_question = (int) 0;
$num_question     = count($data['Question']);
 
if ( $data and $next):
    foreach ($data['Question'] as $val ):
        $current_question++;
        if ($val['id'] == $next):
            if ( count($val['Answer']) > 0 || $val['type'] == 2): # question actually have answers
                echo $this->Html->div('numbers',  $current_question.'/'.$num_question);
                echo $this->Html->div('numbers',  __('Points earned'). ': '.$points);
                echo $this->Html->div('question', __('Value').': '.$val['worth'].' '.__('points').'.<br />   '.__('Question').':'.$val['question']);
                if ( $val['type'] == 1 ): #   multiple options
                    foreach ($val['Answer'] as $v):
                        $num_answers++;
                        $url =  '/questions/save/'.$val['id'] .'/'. $v['id'].'/'.$val['test_id'].'/'.$vclassroom_id; 
                        echo $this->Html->div('buttonlink',$this->Js->link($v['answer'], $url,
                                                      array('update'      => '#answerDiv',
                                                            'evalScripts' => True,
                                                            'before'      => $this->Gags->ajaxBefore('answerDiv'),
                                                            'complete'    => $this->Gags->ajaxComplete('answerDiv')
                                                            )));
                    endforeach;
                else:
                    echo $this->Form->create(Null, array('type'=>'get','default'=>False));
                    echo $this->Form->input('Result.answer', array('type'=>'textarea', 'cols'=>70, 'rows'=>4, 'label'=>False));
                    echo $this->Js->submit(__('Save'), array(
                                               'url'         => '/questions/save/'.$val['id'].'/0/'.$val['test_id'].'/'.$vclassroom_id, 
                                               'update'      => '#answerDiv',
                                               'method'      => 'get',
                                               'before'      => $this->Gags->ajaxBefore('answerDiv'),
                                               'complete'    => $this->Gags->ajaxComplete('answerDiv')
                         ));
                    echo '</form>';
                    echo $this->Html->para(Null, __('This answer will be graded later'));
                endif;
                if ( strlen($val['hint']) > 1):
                    echo $this->Html->para(Null, '<b>'.__('Hint').':</b> '.$val['hint']);
                endif; 
            endif;
        endif;
    endforeach;
else:
    echo $this->Html->para('finish', __('Congratulations, you have finished this Quiz Test'). '!');
    echo $this->Html->para('finish', 'Total :'. $points .' '.__('points'));
    echo $this->Html->para(Null, __('Push the blue arrow to go back to Virtual Classroom'));
endif;

echo $this->Js->writeBuffer();

# ? > EOF
