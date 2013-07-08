<?php
#die(debug($data));
$this->set('title_for_layout', __('Gap filling'));
$linked = $data['t']['GapVclassroom']; # shortcut
echo $this->element('vccrumb', array('blogger'=> $blogger['User']['username'], 'vclassroom_id'=>$linked['vclassroom_id']));
 
if ( $permissions['belongs'] == True and $permissions['chkdate'] == True and $permissions['already'] == False):
    echo $this->Html->para(Null, 
             $this->Html->image('static/gap_filling_icon.png', array('width'=>'25px', 'title'=>__('Gap filling'), 'alt'=>__('Gap filling'))));
    echo '<h1>'  .$data['title']   . '</h1>';
    echo $this->Html->para(null,  __('gap_message'));
    echo $this->Html->para(null,  __('This exercise has a value of') . ' <b>' . $data['points'] . ' ' . __('points').'</b>');
    echo $this->Html->para('grayblock', '<b>'.__('Instructions') . '</b>:<br /> ' . nl2br($data['instructions']));
    echo $this->Form->create();
    echo $this->Form->hidden('Gap.id',            array('value'=>$data['gap_id']));
    echo $this->Form->hidden('Gap.blogger_id',    array('value'=>$blogger['User']['id']));
    echo $this->Form->hidden('Gap.blogger',       array('value'=>$blogger['User']['username']));
    echo $this->Form->hidden('Gap.vclassroom_id', array('value'=>$linked['vclassroom_id']));
    $i = (int) 0;
    foreach($data as $k => $gap):
        if ( intval($k) ):
           $i++;
           $field = $this->Form->input('Gap.try'.$i, array('size'=>$gap['length'], 'maxlength'=>$gap['length'], 'div' =>False, 'label'=>False, 'style'=>'display:inline'));
          $line  = str_replace("&&&", $field, $gap['line']); 
          echo $this->Html->div(Null, $i . '.- '.$line, array('style'=>'margin-top:10px'));
        endif;
    endforeach;
    echo '<br />';
    echo $this->Js->submit(__('Ready').'!', array(
                                  'url' => '/gaps/result',
		                          'update'=>'#somediv',
                                  'evalScripts' => True,
                                  'before'      => $this->Gags->ajaxBefore('somediv'),
                                  'complete'    => $this->Gags->ajaxComplete('somediv') ));
    echo '</form>';
    echo $this->Gags->imgLoad('loading');  
    echo $this->Gags->ajaxDiv('somediv').$this->Gags->divEnd('somediv');
else:
    echo $this->element('permissions', array('permissions'=>$permissions, 'dates'=>$linked, 'kandie_user_id'=>$blogger['User']['id']));
endif;

# ? > EOF