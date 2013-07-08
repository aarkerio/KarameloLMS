<?php
$qdiv    = 'questions_'.$val['question_id']; 
$answer_div = 'answerdiv_'.$val['id'];
$new_answer = 'Answer'.$qdiv;
if ($val['correct'] == 1):
    $st  = __('Yes');
    $img = $this->Html->image('static/img_correct.gif', array('alt'=>$st, 'title'=>$st));
else:
    $st  = 'No';
    $img = $this->Html->image('static/img_incorrect.gif', array('alt'=>$st, 'title'=>$st));
endif; 

echo $this->Gags->ajaxDiv($answer_div, 'grayblock');

echo __('Answer') .': ' . $val['answer']   . '<br />';

echo __('Correct').': ' . $this->Js->link($img, '/admin/answers/change/'.$val['id'].'/'.$val['correct'],
                       array('update'      => "#$answer_div",
                             'evalScripts' => True,
                             'before'      => $this->Gags->ajaxBefore($answer_div),
                             'complete'    => $this->Gags->ajaxComplete($answer_div),
                             'escape'      => False
                             ));

echo $this->Html->div(Null);

echo $this->Js->link($this->Html->image('static/delete_icon.png',array('alt'=>__('Delete'), 'title'=>__('Delete'))),
                                        '/admin/answers/delete/'.$val['id'].'/'.$val['question_id'], 
                       array('update'      => "#$answer_div",
                             'evalScripts' => True,
                             'confirm'     => __('Are you sure to want to delete this?'),
                             'before'      => $this->Gags->ajaxBefore($answer_div),
                             'complete'    => $this->Gags->ajaxComplete($answer_div),
                             'escape'      => False
                             ));

echo '&nbsp;&nbsp;&nbsp; ';

echo $this->Js->link($this->Html->image('static/edit_icon.gif',array('alt'=>__('Edit'), 'title'=>__('Edit'))),
                                        '/admin/answers/edit/'.$val['id'], 
                       array('update'      => "#$answer_div",
                             'evalScripts' => True,
                             'before'      => $this->Gags->ajaxBefore($answer_div),
                             'complete'    => $this->Gags->ajaxComplete($answer_div),
                             'escape'      => False
                             ));



echo '</div><!--Div null -->';
echo $this->Gags->divEnd($answer_div);
echo $this->Js->writeBuffer();
# ? > EOF
