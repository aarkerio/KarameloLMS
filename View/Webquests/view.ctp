<?php
#die(debug($data));
$this->set('title_for_layout', $data['Webquest']['title']);
$linked = $data['VclassroomWebquest'][0]; # shortcut
#die(debug($linked));
echo $this->element('vccrumb', array('blogger'=> $blogger['User']['username'], 'vclassroom_id'=>$linked['vclassroom_id']));
if ( $permissions['belongs'] == True and $permissions['chkdate'] == True and $permissions['already'] == False):
    echo $this->Html->para(Null, 'hi! '.$this->Session->read('Auth.User.username'), array('style'=>'font-weight:bold;font-size:12pt;'));
    echo $this->Html->div('title_section', $data['Webquest']['title']);

    echo '<div style="margin:10px auto;padding:5px;border:1px dotted red;">'; 
    echo '<h2>'.__('Introduction').'</h2>';
    echo $this->Html->div(Null, $data['Webquest']['introduction']);

    echo '<h2>'.__('Tasks').'</h2>';
    echo  $this->Html->div(Null, $data['Webquest']['tasks']);

    echo '<h2>'.__('Process').'</h2>';
    echo  $this->Html->div(Null, $data['Webquest']['process']);

    if ( strlen($data['Webquest']['roles']) > 10 ):
        echo '<h2>Roles</h2>';
        echo  $this->Html->div(Null, $data['Webquest']['roles']);
    endif;
  
    echo '<h2>'.__('Evaluation').'</h2>';
    echo  $this->Html->div(Null, $data['Webquest']['evaluation']);

    echo '<h2>'.__('Conclusion').'</h2>';
    echo  $this->Html->div(Null, $data['Webquest']['conclusion']);

    echo $this->Html->para(Null, __('Created') .': <b>'. $data['Webquest']['created'].'</b>');
    echo '</div>';

    echo '<fieldset>';
    echo $this->Form->create('Webquest', array('action'=>'result', 'onsubmit'=>'return chkForm()'));
    echo $this->Form->hidden('ResultWebquest.points', array('value'=>$data['Webquest']['points']));
    echo $this->Form->hidden('ResultWebquest.webquest_id', array('value'=>$data['Webquest']['id']));
    echo $this->Form->hidden('ResultWebquest.vclassroom_id', array('value'=>$linked['vclassroom_id']));
    echo $this->Form->hidden('ResultWebquest.blogger_id', array('value'=>$blogger['User']['id']));
    echo $this->Form->hidden('ResultWebquest.blogger', array('value'=>$blogger['User']['username']));
    echo $this->Form->input('ResultWebquest.answer', array('type'=>'textarea', 'between'=>'<br />', 'label' =>__('Answer'), 'cols'=>50, 'rows'=>20));
    echo $this->Form->end(__('Send'));
    echo '</fieldset>';
else:
    echo $this->element('permissions', array('permissions'=>$permissions, 'dates'=>$linked, 'kandie_user_id'=>$blogger['User']['id']));
endif;

# ? > EOF
