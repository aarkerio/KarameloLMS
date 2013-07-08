<?php
echo $this->Gags->imgLoad('charging2'); 

echo $this->Gags->ajaxDiv('updater') . $this->Gags->divEnd('updater'); 

$tmp = $this->Form->create(); 

$tmp .= '<fieldset><legend>'.__('Recover password').':</legend>';
$tmp .= $this->Html->para(null, __('Type the email used on your account')); 
$tmp .= $this->Form->input('User.email', array('size' => 30, 'maxlength' => 50, 'value'=>'@'));
    
$tmp .= $this->Js->submit(__('Send'), array(
                                         'url'         => '/recovers/confirm/', 
                                         'update'      => '#updater',
                                         'evalScripts' => True,
                                         'before'      => $this->Gags->ajaxBefore('updater','charging2'),
                                         'complete'    => $this->Gags->ajaxComplete('updater','charging2')    )); 
$tmp .= '</fieldset></form>';

echo $this->Html->div('spaced', $tmp, array('id'=>'form_register'));
# ? >