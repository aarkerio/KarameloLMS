<?php 
#die(debug($data));
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb(__('Collections'), '/admin/collections/listing');
echo $this->Html->getCrumbs(' > ');
 
echo $this->Html->div('title_section', __('Lent')); 

?>
<table class="tbadmin">
<?php
$msg   = __('Are you sure to want to delete this?');
$todays_date = date("Y-m-d");
echo $this->Html->tableHeaders(array(__('Edit'), __('Title'), __('Finish date'), __('User'), __('Status')));
foreach ($data as $val):
     if ($val['Lending']['status'] == 1):
        $img   = 'static/status_1_icon.png';
        $st    = __('Published');
     else:
        $img   = 'static/status_0_icon.png';
        $st    = __('Draft');
    endif;
    $over =  strtotime($todays_date) > strtotime($val['Lending']['fdate']) ? __('Over') : '' ; # lent date is over
    $tr = array(
        $this->Html->link($this->Html->image('static/edit_icon.gif', array('width'=>'16px', 'alt'=>__('Edit'), 'title'=>__('Edit'))), 
                    '/admin/collections/edit/'.$val['Collection']['id'],array('escape'=>False)),
        $val['Collection']['title'],
        $val['Lending']['fdate'] . ' '.$over,
        $val['User']['username'],
        $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
        '/admin/collections/change/'.$val['Lending']['id'].'/'.$val['Lending']['status'], array('escape'=>False)),
    );
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow); 
endforeach;
?>
</table>
<?php
/* $t  = $this->Html->div(null,$this->Paginator->prev('« '.__('Previous'),null,null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
$t .= $this->Html->div(null,$this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
$t .= $this->Html->div(null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
echo  $this->Html->div(null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;')); */

# ? > EOF