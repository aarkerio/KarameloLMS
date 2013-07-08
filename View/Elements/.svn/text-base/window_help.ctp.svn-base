<?php
# help popup window 
if ( !isset($blogger)):
    $o = (string) '/admin/'.$this->name .'/'.$this->action;
    $o = strtolower(str_replace('admin_', '', $o));
else:
    $o = strtolower('/'.$this->name .'/'.$this->action);
endif;
$path = '/helps/display' . $o;
#echo $o; 
$t="javascript:window.open('".$path."', 'blank', 'toolbar=no, scrollbars=yes,width=800,height=800')";
      
echo $this->Html->link($this->Html->image('admin/help.gif', array('alt'=>__('Help'), 'title'=>__('Help'))), 
		 '#header', array('onclick'=>$t, 'escape'=>False));
?>