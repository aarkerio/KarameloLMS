<?php
#die(debug($data)); 
$this->Html->addCrumb('Control Panel', '/admin/entries/start');  
echo $this->Html->getCrumbs(' > '); 

echo $this->Html->div('title_section', $this->Html->image('phorum.png', array('style'=>'width:35px;margin-right:6px;','alt'=>__('Messages'),'title'=>__('Messages'))).' '.__('Messages'));

echo $this->Html->para(null,$this->Html->link($this->Html->image('admin/compose_on.gif', array('alt'=>__('Compose new message'), 'title'=>__('Compose new message'))), '/admin/messages/add', array('escape'=>False)));

if ( $this->Session->read('Auth.User.group_id') == 1):   # if user belongs to admin group
    echo '<div style="position:absolute;right:300px;top:75px;">';
    echo $this->Html->link($this->Html->image('admin/message_board.gif', array('alt'=>__('General Message'), 'title'=>__('General Message'))), 
                                              '/admin/messages/general', array('escape'=>False));
    echo '</div>';
endif;

echo $this->Form->create('Message', array('action'=>'delete', 'onsubmit'=>'return chkList();', 'name'=>'privmsg_list'));
echo '<table class="tbadmin">';
if ( $data ):
    $th = array(__('Flag'), __('Subject'), __('From'), __('Date'), __('Mark'));
    echo $this->Html->tableHeaders($th);
endif;

foreach ($data as $val):
    switch ($val['Message']['status']):
           case 0:
                $status = __('New');
                $img    = 'message_n.gif';
                break;
           case 1:
                $status = __('Readed');
                $img    = 'message_r.gif';
                break;
           case 2:
                $status = __('Reply');
                $img    = 'message_e.gif';
                break;
    endswitch;

    $tr = array(
        $this->Html->link($this->Html->image('admin/'.$img, array('alt'=>$status,'title'=>$status)),'/admin/messages/display/'.$val['Message']['id'],array('escape'=>False)),
        $this->Html->link($val['Message']['title'], '/admin/messages/display/'.$val['Message']['id']),
        $this->Html->link($val['Sender']['username'], '/users/about/'.$val['Sender']['username']),
        $val['Message']['created'] . "\n",
        $this->Form->checkbox('Message.id'.$val['Message']['id'], array('value'=>$val['Message']['id'], 'id'=>'fieldid'.$val['Message']['id']))
        );
   echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;
 
echo '<tr><td colspan="5" style="text-align:right">';
 
if ( count($data) > 0 ):
    echo $this->Html->link(__('Mark all'), "javascript:select_switch(true)", array('style'=>'font-size:7pt')) . ' | ';
    echo $this->Html->link(__('Unmark all'), "javascript:select_switch(false)", array('style'=>'font-size:7pt')) . '<br /><br />';
    echo $this->Form->end(__('Delete marked'));
endif;
?>
</form>
</td></tr>
</table>
<?php
if ( $data ):
    $t  = $this->Html->div(null,$this->Paginator->prev('« '.__('Previous'),Null,Null,array('class'=>'disabled')),
                                         array('style'=>'width:100px;float:left'));
    $t .= $this->Html->div(null,$this->Paginator->next(__('Next').' »', Null, Null, array('class' => 'disabled')),
                                         array('style'=>'width:100px;float:right'));
    $t .= $this->Html->div(null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
    echo  $this->Html->div(null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));
endif;
?>
<script language="Javascript" type="text/javascript">
	//
	// Should really check the browser to stop this whining ...
	//
	function select_switch(status)
	{
		for (i = 0; i < document.privmsg_list.length; i++)
		{
			document.privmsg_list.elements[i].checked = status;
		}
	}
    
	function chkList()
	{   
        var j = 0;
        for (i = 0; i < document.privmsg_list.length; i++)
	{
	    if (document.privmsg_list.elements[i].checked == true)
            {
                j++;
            }
	}
        //alert('Inside '+ j);
        
        if (j == 0 )
        {
            alert('<?php __('You must select at least one message');?>');
            return false;
        }
        
        return true;
    }
</script>
