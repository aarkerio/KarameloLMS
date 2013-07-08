<?php
echo $this->Html->div('title_section', __('Select the type of Kandie that you want to link to this vClassroom'));
echo $this->Form->create();
echo $this->Form->hidden('Vclassroom.id', array('value'=>$vclassroom_id));

$types = array(' '=>' ',__('Quizz Test'), __('Webquest'), __('Scavenger Hunt'), __('Gap filling'),  'SCORM');

echo $this->Form->input('Vclassroom.type', array('options'=>$types, 'between'=>': '));

echo '</form>';
$before   =  $this->Gags->ajaxBefore('active');
$complete =  $this->Gags->ajaxComplete('active','loading', 'fadeOut', 'slideDown');

$this->Js->get('#VclassroomType')->event('change',
      $this->Js->request('/admin/vclassrooms/type/',
        array('update'         =>'#activ',
              'dataExpression' => True,
              'evalScripts'    => True,
              'before'         => $before,
              'complete'       => $complete,
              'method'         => 'post',
              'data'           => $this->Js->serializeForm(array('isForm' => False, 'inline' => True))
        )));

echo $this->Gags->ajaxDiv('activ').$this->Gags->divEnd('activ');

echo $this->Js->writeBuffer();

# ? > EOF