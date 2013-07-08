<?php 
# die(debug($data));
echo $this->Html->link($this->Html->image('admin/compose_on.gif', array('alt'=>'Compose New Message', 'title'=>'Compose New Message')), 
'/messages/compose', array('escape'=>False)) . '  ';

$th = array('Subject', __('To'), __('Date'));

e('<table style="width:100%;border:1px dotted orange;padding:3px;">');

echo $this->Html->tableHeaders($th, array('style'=>'text-align:center'));

foreach ($data as $val):
   $tr = array(
        $this->Html->link($val['Message']['title'], '/messages/display/'.$val['Message']['id']),
        $this->Html->link($val['User']['username'], '/vclassrooms/aboutme/'.$val['User']['username']),
        $val['Message']['created'] . "\n"
        );
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;
?>
</table>
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
