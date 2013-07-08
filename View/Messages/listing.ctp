<?php 
# die(debug($data));
echo $this->Html->link($this->Html->image('admin/compose_on.gif', array('alt'=>__('Compx1ose New Message'), 'title'=>__('Compose New Message'))), 
'/messages/compose', array('escape'=>False)) . '  ';

echo $this->Html->link($this->Html->image('static/sent_icon.gif', array('alt'=>__('Sent Messages'), 'title'=>__('Sent Messages'))), 
'/messages/sentmessages', array('escape'=>False));

echo $this->Form->create('Message', array('action'=>'delete', 'onsubmit'=>'return chkList();', 'name'=>'privmsg_list'));

$th = array(__('Flag'), 'Subject', 'From', __('Date'), 'Mark');

echo '<table style="width:100%;border:1px dotted orange;padding:3px;">';

echo $this->Html->tableHeaders($th, array('style'=>'text-align:center'));

foreach ($data as $val):
       switch ($val['Message']['status']):
           case 0:
                $status = __('New');
                $img    = 'message_n.gif';
                break;
           case 1:
                $status = __('Read');
                $img    = 'message_r.gif';
                break;
           case 2:
                $status = __('Reply');
                $img    = 'message_e.gif';
                break;
        endswitch;
       
       $tr = array($this->Html->link($this->Html->image('admin/'.$img, array('alt'=>$status, 'title'=>$status)),
                                     '/messages/display/'.$val['Message']['id'], array('escape'=>False)),
        $this->Html->link($val['Message']['title'], '/messages/display/'.$val['Message']['id']),
        $this->Html->link($val['Sender']['username'], '/users/about/'.$val['Sender']['username']),
        '<span style="font-size:6pt;">'.$val['Message']['created'] . '</span>',
        $this->Form->checkbox('Message.id'.$val['Message']['id'], array('value'=>$val['Message']['id'], 'id'=>'fieldid'.$val['Message']['id']))
        );   
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;
 
echo '<tr><td colspan="5" style="text-align:right">';
 
if ( count($data) > 0 ):
    echo $this->Html->link(__('Mark all'),  "javascript:select_switch(true)", array("style"=>"font-size:7pt")) . ' &nbsp;|&nbsp;';
    echo $this->Html->link(__('Unmark all'), "javascript:select_switch(false)", array("style"=>"font-size:7pt")) . '<br /><br />';
    echo $this->Form->end(__('Delete marked'), array('style'=>'font-size:7pt'));
endif;
?>
</form>
</td></tr>
</table>
<?php
echo $this->Html->div(null,null, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));
echo $this->Html->div(null,$this->Paginator->prev('« '.__('Previous'),Null,Null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
echo $this->Html->div(null,$this->Paginator->next(__('Next').' »', Null, Null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
echo $this->Html->div(null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
?>
</div>
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
            alert('You must select at least one message');
            return false;
        }
        
        return true;
    }
</script>
