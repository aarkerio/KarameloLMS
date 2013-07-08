<?php
#die(debug($data));
$this->set('title_for_layout', __('Scavenger Hunt') .' '. $data['Treasure']['title']);

$linked = $data['t']['TreasureVclassroom']; # shortcut
echo $this->element('vccrumb', array('blogger'=> $blogger['User']['username'], 'vclassroom_id'=>$linked['vclassroom_id']));

if ( $permissions['belongs'] == True and $permissions['chkdate'] == True  and $permissions['already'] == False):
    echo $this->Html->para(Null, 'hi! '.$this->Session->read('Auth.User.username'), array('style'=>'font-weight:bold;font-size:12pt;'));
    echo $this->Html->div('title', $blogger['User']['username'] .'s Treasure Hunt');

    echo '<h1>'. $data['Treasure']['title'] . '</h1>';
    echo $this->Html->div(Null, '<b>'. __('Points') .':</b> '.$data['Treasure']['points']);
    echo $this->Html->div(Null, $data['Treasure']['instructions']);

    # ajax beggins
    echo $this->Gags->imgLoad();
    echo $this->Form->create();
    echo $this->Form->hidden('ResultTreasure.vclassroom_id', array('value'=>$linked['vclassroom_id']));
    echo $this->Form->hidden('ResultTreasure.treasure_id',   array('value'=>$data['Treasure']['id']));
    echo $this->Form->hidden('ResultTreasure.points',        array('value'=>$data['Treasure']['points']));
    echo $this->Form->input('ResultTreasure.secret',         array('size' => 15, 'maxlength'=>15, 'title'=>__('Secret code'), 'between'=>': '));
    echo $this->Js->submit(__('Send final code').' '. $this->Session->read('Auth.User.username'), 
                                    array(
                                         'url'      => array('controller'=>'treasures', 'action'=>'chksw'), 
                                         'update'   => '#updater',
                                         'evalScripts' => True,
                                         'before'      => $this->Gags->ajaxBefore(),
                                         'complete'    => $this->Gags->ajaxComplete()));
    # empty ajax div
    echo $this->Gags->ajaxDiv('updater') . $this->Gags->divEnd('updater');
else:
    echo $this->element('permissions', array('permissions'=>$permissions, 'dates'=>$linked, 'kandie_user_id'=>$blogger['User']['id']));
endif;

# ? > EOF
