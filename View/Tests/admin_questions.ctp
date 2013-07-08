<?php 
 $helps = $this->Session->read('Auth.User.helps'); # helps enabled ?
 if ($this->Session->check('Message.flash')): 
     echo $this->Session->flash(); 
 endif;
 if ( !isset($ajax) ):
     $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
     $this->Html->addCrumb(__('Tests'), '/admin/tests/listing'); 
     echo $this->Html->getCrumbs(' > '); 
     echo $this->Html->div('title_section', __('Test')); 

     echo $this->Gags->imgLoad('loading');

     echo '<b>'.__('Title').'</b> ' . $data['Test']['title'] . '<br />';
     echo '<b>'.__('Description').'</b> ' . $data['Test']['description'];

     echo '  '. count($data['Question']) .' '. __('questions');

     echo $this->Html->para(Null,
                   $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new question'),'title'=>__('Add new question'))), 
                     '#addquestion',   array('onclick'=>"$('#addquestion').toggleDiv();", 'escape'=>False)). "           ".
                   $this->Html->link($this->Html->image('static/eye_icon.gif', array('alt'=>__('See Test'), 'title'=>__('See Test'))), '#', 
                                     array('onclick'=>"javascript:window.open('/admin/tests/view/".$data['Test']['id']."', 'blank', 
                                           'toolbar=no, scrollbars=yes,width=700,height=500')", 'escape'=>False))
                           ); 

 if ( count($data['Question']) > 0):
     echo $this->Html->div('title_section',  __('Questions'));
 endif;

 echo '<!-- Ajax add question beggin --><div id="addquestion" style="display:none">';
 echo $this->Form->create();
 echo $this->Form->hidden('Question.test_id', array('value'=>$data['Test']['id'])); 

 echo '<fieldset><legend>'. __('New question').'</legend>';
 echo $this->Gags->helps('Write the question to student', $helps);
 echo $this->Form->input('Question.question', array('type'=>'textarea', 'cols' => 50, 'rows' => 5, 'class'=>'required', 'label'=>__('Question'))); 
 
 echo $this->Gags->helps('You can give a hint to student about the question, if do not want left this field empty', $helps);
 echo $this->Form->input('Question.hint', array('size'=> 40,'maxlength' => 120, 'label'=>__('Hint'))); 

 echo $this->Gags->helps('Briefly explain the right answer to the question in order to give feedback to student, student can see this explanation only after hi/she finished the test', $helps);
 echo $this->Form->input('Question.explanation', array('cols' => 50, 'rows' => 3,  'class'=>'required','label'=> __('Explanation'))); 

 echo $this->Gags->helps('Assign a value to question', $helps);
 echo $this->Form->input('Question.worth', array('options'=>range(0,10), 'label' => __('Points'))); 

 echo $this->Gags->helps('Here you can choice between an open answer or multiple choice', $helps);
 echo $this->Form->input('Question.type', array('options'=> array('1'=>__('Multiple choice'), '2'=>__('Open question')), 'label' => __('Question type'))); 
 
 echo '<div style="clear:both;margin-top:15px;"></div>';
 echo $this->Js->submit(__('Save'), array(
                'url'      => '/admin/questions/add',
 	            'update'   => '#questions',
	            'before'   => $this->Gags->ajaxBefore('questions').$this->Js->get('#addquestion')->effect('fadeOut',array('buffer' => False)),
 	            'complete' => $this->Gags->ajaxComplete('questions').'clear();'
 	        ));
    echo '</fieldset></form>';

    echo $this->Gags->divEnd('addquestion');  # Ajax addquestion div ends 
else:
    echo $this->Html->scriptBlock('timedMsg()');
endif;

echo $this->Html->div(Null, Null, array('id'=>'questions')); # beggins column in Sortable Ajax

$i = 0;
echo $this->Html->div(Null, '<!--just break -->',array('style'=>'clear:both;'));
$msg       = __('Are you sure to want to delete this?');
$sortable  = __('Drag and drop to reorder this question');
foreach ($data['Question'] as $val):
    $qdiv    = 'questions_'.$val['id'];
    $answers = count($val['Answer']);
    $i++;
    echo '<div class="portlet" id="'.$qdiv.'" title="'.$sortable.'">';

    $tmp  = $this->Form->create('QuestionEdit'.$val['id']);
    $tmp .= $this->Form->input('Question.id', array('type'=>'hidden', 'value'=>$val['id']));
    $tmp .= $this->Form->input('Question.test_id', array('type'=>'hidden', 'value'=>$val['test_id']));
    $tmp .= $this->Js->submit(__('Edit'), array(
                'url'      => '/admin/questions/edit/',
 	            'update'   => "#$qdiv",
	            'before'   => $this->Gags->ajaxBefore($qdiv),
 	            'complete' => $this->Gags->ajaxComplete($qdiv)
 	        ));
    $tmp .= '</form>';
    echo $this->Html->div('butonright', $tmp);

    $tmp  = $this->Form->create('Question'.$val['id']);
    $tmp .= $this->Form->input('Question.test_id', array('type'=>'hidden', 'value'=>$val['test_id'])); 
    $tmp .= $this->Form->input('Question.id',      array('type'=>'hidden', 'value'=>$val['id']));
    $tmp .= $this->Js->submit(__('Delete'), array(
                'url'      => '/admin/questions/delete/',
                'confirm'  => $msg,
 	            'update'   => "#questions",
	            'before'   => $this->Gags->ajaxBefore($qdiv),
 	            'complete' => $this->Gags->ajaxComplete($qdiv)
 	        ));
    $tmp .= '</form>';
    echo $this->Html->div('butonright', $tmp);

    echo '<b>' . $i          . '.-'   . __('Question') .':</b> '. $val['question']. '<br />';
    echo '<b>'. __('Hint')              .':</b> '. $val['hint']           . '<br /><br />';
    echo '<b>'. __('Explanation')       .':</b> '. $val['explanation']    . '<br /><br />';
    echo '<b>'. __('Points')            .':</b> '. $val['worth']          . '<br /><br />';
    if (  $val['type'] == 1 ):
        echo $this->element('answerbutton', array('test_id' =>$data['Test']['id'],'question_id'=>$val['id'], 'qdiv'=>$qdiv, 'answers'=> $answers));
    else:
        echo '<b>'.__('This is an open question').'</b><br />';
    endif;

    echo  $this->Gags->ajaxDiv($qdiv).$this->Gags->divEnd($qdiv); 
    echo '</div>';
endforeach;

echo $this->Gags->divEnd('questions');  # Ajax questions div ends 

if ( !isset($ajax) ):
    $this->Js->get('#questions');
    $this->Js->sortable(array(
                              'distance'    => 5,
                              'containment' => '#questions',
                              'complete'    => '$.post("/admin/questions/order", $("#questions").sortable("serialize"));'.
"updateQuestions('".$data['Test']['id']."');",
                          ));
  echo $this->Html->scriptStart();
?>
  function updateQuestions(test_id)
  {
    $.ajax({
        type: "GET",
                url: '/admin/questions/listing/'+test_id,
                data: "test_id=" + test_id, // appears as $_GET['id'] @ ur backend side
                success: function(data) {
                $("#questions").fadeOut("slow");
                // data is ur summary
                $('#questions').html(data);
                $("#questions").fadeIn("slow");
            }
        });

}


  function clear() { // clear form
  var  question = document.getElementById('QuestionQuestion')
  var  hint     = document.getElementById('QuestionHint')
  var  explana  = document.getElementById('QuestionExplanation')
  var  selec    = document.getElementById('QuestionWorth')
  selec.value = 0
  // $("#QuestionWorth").val('0');
  question.value = '' 
  hint.value     = ''
  explana.value  = ''
  
  return true; 
}
<?php 
    echo $this->Html->scriptEnd();
else:
    echo $this->Js->writeBuffer();
endif;
?>

<style>
#questions { width: 100%; float: left; padding-bottom: 10px; }
.portlet { padding:5px;border:1px dotted gray;margin:5px auto;width:80%;float: left;}

</style>
