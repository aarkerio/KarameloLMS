<?php 
echo $this->set('title_for_layout', __('Chat Record'));
#die(debug($msgs));
$helps = $this->Session->read('Auth.User.helps'); # helps enabled
echo $this->Html->image('static/chat_logo.jpg', array('alt'=>'Chat'));
echo '<h2>'.__('All chats in vClassroom').': '.$data['Vclassroom']['name'].'</h2>';
$msg   = __('Are you sure to want to delete this?');
#echo $this->Gags->helps('Delete all chats in this vClassroom', $helps);

#chat
if ($data['Vclassroom']['chat'] == 1):
   $img  = 'static/chat_ena.png'; 
   $tit  = __('Disable chat');
else:
    $img = 'static/chat_dis.png';
    $tit = __('Active chat');
endif;

#Videoconference
if ($data['Vclassroom']['videoconference'] == 1):
   $vc  = 'static/icon_webcam.jpg';
   $vctit  = __('Disable Videoconference');
else:
    $vc = 'static/icon_webcam_disabled.jpg';
    $vctit = __('Active videconference');
endif;

if ($data['Vclassroom']['videoconference'] == 1):
    echo $this->Gags->imgLoad('loading');
    echo $this->Gags->ajaxDiv('qn', array('style'=>'padding:0;')) . $this->Gags->divEnd('qn');
    echo $this->Form->create(False);
    echo $this->Form->input('Vclassroom.id', array('type'=>'hidden','value'=>$data['Vclassroom']['id']));
    echo $this->Form->input('Vclassroom.streaming', array('type'=>'textarea', 'cols'=> 80, 'rows'=>5, 'label'=>'Stream code','between'=>'<br />','value'=>$data['Vclassroom']['streaming']));
    echo $this->Js->submit(__('Save'), 
             array('url'      => array('controller'=>'chats', 'action'=>'admin_edit'),
                   'update'   => '#qn', 
                   'before'   => $this->Gags->ajaxBefore('qn'), 
                   'complete' => $this->Gags->ajaxComplete('qn')));
    echo $this->Form->end(); 
endif;


echo $this->Html->para(Null,
            $this->Html->link($this->Html->image($img, array('width'=>20,'alt'=>$tit, 'title'=>$tit)), '/admin/vclassrooms/chat/'.$data['Vclassroom']['id'].'/'.$data['Vclassroom']['chat'], array('escape'=>False)) .'&nbsp;&nbsp;' .
            $this->Html->link($this->Html->image($vc, array('width'=>20,'alt'=>$vctit, 'title'=>$vctit)), '/admin/vclassrooms/edactivity/'.$data['Vclassroom']['id'].'/'.$data['Vclassroom']['videoconference'], array('escape'=>False)) .'&nbsp;&nbsp;' .
            $this->Html->link($this->Html->image('static/delete_icon.png', 
                array('width'=>'16px','alt'=>__('Delete'),'title'=>__('Delete'))), 
                     '/admin/chats/delete/'.$data['Vclassroom']['id'],  array('onclick'=>"return confirm('".$msg."')", 'escape'=>False)). '  '.
            $this->Html->link($this->Html->image('static/historial-icon.png',array('width'=>'16px','alt'=>__('Reset'),'title'=>__('Reseat'))),
                                   '/admin/chats/export/'.$data['Vclassroom']['id'], array('escape'=>False)).' '.
            $this->Html->link($this->Html->image('static/eye_icon.gif',array('width'=>'16px','alt'=>__('View all'),'title'=>__('View all'))),
                                   '/admin/chats/record/'.$data['Vclassroom']['id'].'/1', array('escape'=>False))
             );
if (!$msgs):
    echo $this->Html->para(Null, __('No chats in this vClassroom'));
endif;

if ( isset($historic) ):
    echo $this->Html->para(Null, __('Historical  chats in this vClassroom'));
endif;

echo $this->Html->div(Null, Null, array('style'=>'width:700px;border:1px dotted gray;padding:8px;margin:auto;font-family:Verdana;'));
echo $this->element('chat_messages', array('msgs'=>$msgs));

echo '</div>';

# ? > OEF 