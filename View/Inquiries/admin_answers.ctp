<?php
#debug($data);
if ( count($data['Answer']) < 1 ):
    echo $this->Html->div(Null, __('Not answers in this question'));
endif;

$question_id   = $data['Question']['id'];
$AnswerDiv     = 'answers'.$question_id;

if ( !isset($ajax) ):
    $qdiv          = 'questions_'.$question_id;
    $new_answer    = 'Answer'.$qdiv;
    $DivForm       = 'DivForm'.$question_id;
    $FormId        = 'NewForm'.$question_id;

    echo $this->Html->para(Null, $this->Html->link($this->Html->image('actions/new.png',array('alt'=>__('Add new answer'),'title'=>__('Add new answer'))), 
                           "#$qdiv", array('onclick'=>"$('#$DivForm').toggleDiv();", 'escape'=>False)));

    echo $this->Html->div(Null, Null, array('id'=>$DivForm, 'style'=>'display:none;')); # hidden field
 
    echo $this->Form->create(Null, array('url'=>'/admin/answers/add/', 'id'=>$FormId));
    echo $this->Form->input('Answer.question_id', array('type'=>'hidden', 'value'=>$data['Question']['id']));
    echo '<fieldset style="padding: 0;border:none;"><legend>'. __('New answer') . '</legend>';
    echo $this->Form->input('Answer.answer', array('size'=>55, 'maxlength'=>120, 'label'=>__('Answer')));
    echo $this->Form->input('Answer.correct',array('type'=>'checkbox', 'label'=>__('Answer is correct'))); 

    $complete = $this->Gags->ajaxComplete($AnswerDiv)."$('#$FormId').clearAnswer();".$this->Js->get("#$DivForm")->effect('slideUp',array('buffer'=>False));
    echo $this->Js->submit(__('Save'), array(
               'url'       => '/admin/answers/add',
               'update'    => "#$AnswerDiv",
	           'before'    => $this->Gags->ajaxBefore($AnswerDiv).$this->Js->get($AnswerDiv)->effect('fadeOut',array('buffer' => False)),
 	           'complete'  => $complete,
               'controller'=> 'posts',
               'action'    => 'add'
 	        ));
    echo "</fieldset></form></div><!-- '$DivForm ends' -->";
endif;

echo $this->Gags->ajaxDiv($AnswerDiv); # starts
# if already are answers to this question display them
foreach ($data['Answer'] as $val):
    echo $this->element('answer', array('val'=>$val));
endforeach;
echo $this->Gags->divEnd($AnswerDiv);  #ends

if ( !isset($ajax) ):
    # Next button: Close answers
    echo $this->Html->div(Null, Null, array('style'=>'text-align:right;margin:1px;padding:1px;clear:both;'));
    echo $this->Js->link($this->Html->image('static/icon_hide.gif',array('alt'=>__('Hide Answers'), 'title'=>__('Hide answers'))),
                                        '/admin/answers/listing/'.$data['Question']['id'], 
                       array('update'      => "#$new_answer",
                             'evalScripts' => True,
                             'before'      => $this->Gags->ajaxBefore($new_answer),
                             'complete'    => $this->Gags->ajaxComplete($new_answer, 'loading', 'slideUp'),
                             'escape'      => False
                             ));

    echo '</div>';
endif;

echo $this->Js->writeBuffer();

# ? > EOF
