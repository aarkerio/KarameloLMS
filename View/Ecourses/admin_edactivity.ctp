<?php
echo $this->Html->script(array('ckeditor/ckeditor'));

$edit  =  isset($this->data['Activity']) ? True : False ; # edit or add form
$helps = $this->Session->read('Auth.User.helps'); # helps enabled ?

if ( $edit ):
   $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
   $this->Html->addCrumb('eCourses', '/admin/ecourses/activities/'.$this->data['Activity']['ecourse_id']);
   echo $this->Html->getCrumbs(' > ');
   echo '<br /><br />'. $this->Html->div('title_section', __('Edit activity')).'<br />';
else:
   $value  = (string) '<strong>'. __('Activity aims') .'</strong>:<br />';
   $value .= '<strong>'.__('Anticipated problems during the class')    .'</strong>:<br />';
   $value .= '<strong>'.__('Aids/resources')          .'</strong>:<br />';
   $val    = '<strong>'.__('Procedure')               .'</strong>:<br />';
endif;

echo $this->Html->div('grayblock');
echo $this->Form->create('Ecourse', array('action'=>'edactivity'));

if ( $edit ):
   echo $this->Form->hidden('Activity.id');
   echo $this->Form->hidden('Activity.ecourse_id');
else:
   echo $this->Form->hidden('Activity.ecourse_id', array('value'=>$ecourse_id));
endif;

echo $this->Form->input('Activity.title', array('size'=>40, 'maxlength'=>40, 'class'=>'required', 'label'=>__('Title')));

# Description
$btw = $this->Gags->helps('Activity description and directions for students', $helps);
$params = array('type'=>'textarea','cols'=>50, 'rows'=>15, 'between'=>$btw, 'label'=> __('Activity description'));
 if ( !$edit ):
    $params['value'] = $value;
endif;
echo $this->Form->input('Activity.activity', $params);

echo '<br />';

# pedagogic notes 
$btw = $this->Gags->helps('Teacher pedagogic notes, students do not see this information', $helps);
$params = array('type'=>'textarea', 'between'=>$btw, 'label'=> __('Teacher notes'),'cols'=>50, 'rows'=>15);
if ( !$edit ):
    $params['value'] = $value;
endif;
echo $this->Form->input('Activity.notes', $params);
  
#Points 
echo '<br />';
echo $this->Gags->helps('If you assign a task like Quizz test, Clozez or Webquest the points of that task must coincide here', $helps);
echo $this->Form->input('Activity.points', array('type'=>'select', 'options'=>range(0,50)));

#Minutes 
echo '<br />';
$minutes = array(5=>5,10=>10,20=>20,30=>30,40=>40,50=>50,60=>60,70=>70,80=>80,90=>90,100=>100,110=>110,120=>120,130=>130,140=>140,150=>150,160=>160,170=>170,180=>180);
echo $this->Gags->helps('Minutes', $helps);
echo $this->Form->input('Activity.minutes', array('type'=>'select', 'options'=>$minutes));

#Status
echo $this->Form->input('Activity.status', array('type'=>'checkbox', 'value'=>'1', 'label'=>__('Published'))); 
echo $this->Form->input('Activity.end', array('type'=>'checkbox', 'value'=>'1', 'label'=>__('Finish edition'))); 
echo $this->Html->para(Null, $this->Form->end(__('Save')));

# Ck stuff
echo $this->Ck->load('ActivityActivity', 'Basic', $this->Session->read('Auth.User.lang'), 800, 150);
echo $this->Ck->load('ActivityNotes', 'Basic', $this->Session->read('Auth.User.lang'), 800, 150);

echo '</div>';

# ? > EOF