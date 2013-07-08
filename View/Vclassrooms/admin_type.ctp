<?php 
#debug($data);
#Test
if ($data['Type'] == 'Test' and count($data['Test']) > 0):
    echo $this->Form->create('Test', array('action'=>'link2class'));
    echo $this->Form->hidden('TestVclassroom.vclassroom_id', array('value'=>$data['vclassroom_id']));
    echo $this->Form->hidden('TestVclassroom.popup', array('value'=>'1'));
    $tests = array();
    foreach ($data['Test'] as $t):
        $tests[$t['Test']['id']] = $t['Test']['title'];
    endforeach;
    
    echo $this->Form->input('TestVclassroom.test_id', array('type'=>'select','between'=>':<br />','label'=>__('Test'), 'options'=>$tests)); 
    echo $this->Form->input('TestVclassroom.sdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Starting date')));
    echo $this->Form->input('TestVclassroom.fdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Finishing date')));
    echo $this->Form->end(__('Save'));
elseif(  $data['Type'] == 'Test' && count($data['Test']) == 0 ):
    echo $this->Html->para(Null, __('You do not have any Quizz Test to assign, be sure to create one in New Test menu option'));
endif;

#Webquest
if ($data['Type'] == 'Webquest' and count($data['Webquest']) > 0):
    echo $this->Form->create('Webquest', array('action'=>'link2class'));
    echo $this->Form->hidden('VclassroomWebquest.vclassroom_id', array('value'=>$data['vclassroom_id']));
    echo $this->Form->hidden('VclassroomWebquest.popup', array('value'=>'1'));
    $wqs = array();
    foreach ($data['Webquest'] as $t):
        $wqs[$t['Webquest']['id']] = $t['Webquest']['title'];
    endforeach;
    echo $this->Form->input('VclassroomWebquest.webquest_id', array('type'=>'select', 'between'=>':<br />', 'options' => $wqs, 'label'=> __('Webquest'))); 
    echo $this->Form->input('VclassroomWebquest.sdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Starting date')));
    echo $this->Form->input('VclassroomWebquest.fdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Finishing date')));
    echo $this->Form->end(__('Save'));
elseif(  $data['Type'] == 'Webquest' && count($data['Webquest']) == 0 ):
    echo $this->Html->para(Null, __('You do not have any Webquest available to assign, be sure to create one in New Webquest menu option'));
endif;

# Scavenger
if ($data['Type'] == 'Treasure'and count($data['Treasure']) > 0):
    echo $this->Form->create('Treasure', array('action'=>'link2class'));
    echo $this->Form->hidden('TreasureVclassroom.vclassroom_id', array('value'=>$data['vclassroom_id']));
    echo $this->Form->hidden('TreasureVclassroom.popup', array('value'=>'1'));
    $treasures = array();
    foreach ($data['Treasure'] as $t):
        $treasures[$t['Treasure']['id']] = $t['Treasure']['title'];
    endforeach;
    echo $this->Form->input('TreasureVclassroom.treasure_id',array('type'=>'select','between'=>':<br />','options'=>$treasures,'label'=>__('Treasure hunt'))); 
    echo $this->Form->input('TreasureVclassroom.sdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Starting date')));
    echo $this->Form->input('TreasureVclassroom.fdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Finishing date')));
    echo $this->Form->end(__('Save'));
elseif(  $data['Type'] == 'Treasure' && count($data['Treasure']) == 0 ):
    echo $this->Html->para(Null, __('You do not have any Scavenger Hunt to assign, be sure to create one in New Scavenger menu option'));
endif;

# Gap fillings
if ($data['Type'] == 'Gap' && count($data['Gap']) > 0):
    echo $this->Form->create('Gap', array('url' => array('controller' => 'gaps', 'action' => 'link2class')));
    echo $this->Form->hidden('GapVclassroom.vclassroom_id', array('value'=>$data['vclassroom_id']));
    echo $this->Form->hidden('GapVclassroom.popup', array('value'=>'1'));
    $gaps = array();
    foreach ($data['Gap'] as $t):
        $gaps[$t['Gap']['id']] = $t['Gap']['title'];
    endforeach;
    echo $this->Form->input('GapVclassroom.gap_id',array('label'=>__('Gap filling'), 'between'=>':<br />', 'options'=>$gaps)); 
    echo $this->Form->input('GapVclassroom.sdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Starting date')));
    echo $this->Form->input('GapVclassroom.fdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Finishing date')));
    echo $this->Form->end(__('Save'));
elseif( $data['Type'] == 'Gap' && count($data['Gap']) == 0 ):
    echo $this->Html->para(null, __('You do not have any Gap Filling to assign, be sure to create one in New Gap Filling menu option'));
endif;

# SCORMs
if ($data['Type'] == 'SCORM' && count($data['Scorm']) > 0):
    echo $this->Form->create('Scorm', array('url'=>'/admin/scorm/scorms/link2class'));
    echo $this->Form->hidden('ScormVclassroom.vclassroom_id', array('value'=>$data['vclassroom_id']));
    echo $this->Form->hidden('ScormVclassroom.popup', array('value'=>'1'));
    $scorms = array();
    foreach ($data['Scorm'] as $v):
        $scorms[$v['Scorm']['id']] = $v['Scorm']['name'];
    endforeach;
    echo $this->Form->input('ScormVclassroom.scorm_id', array('label'=>'SCORM', 'options'=> $scorms)); 
    echo $this->Form->input('ScormVclassroom.sdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Starting date')));
    echo $this->Form->input('ScormVclassroom.fdate', array('type'=>'datetime','between'=>':<br />', 'label'=>__('Finishing date')));
    echo $this->Form->end(__('Save'));
elseif(  $data['Type'] == 'SCORM' && count($data['Scorm']) == 0 ):
    echo $this->Html->para(Null, __('You do not have any SCORM to assign'));
endif;

# ? > EOF
