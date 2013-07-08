<?php 
$this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
echo $this->Html->getCrumbs(' > '); 

echo $this->Html->div('title_section', $this->Html->image('Poll.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Polls'), 'title'=>__('Polls'))).' '.__('Polls'));
echo $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))),'/admin/polls/add/', array('escape'=>False)); 
?>
<table class="tbadmin">
<?php
$th = array (__('Edit'), __('Question'), __('Created'), __('Status'), __('Delete'));

echo $this->Html->tableHeaders($th, array('style'=>'text-align:left;'));

foreach ($data as $val):
     if ($val['Poll']['status'] == 1):
         $img   = 'static/status_1_icon.png';
         $st    = __('Published');
     else:
         $img   = 'static/status_0_icon.png';
         $st    = __('Draft');
         $order = $st;
    endif;
    $tr = array (
        $this->Gags->sendEdit($val['Poll']['id'], 'polls'),
        $val['Poll']['question'],
        $val['Poll']['created'],
        $this->Html->link($this->Html->image($img,array('width'=>'14px', 'alt'=>$st, 'title'=>$st)),
                    '/admin/polls/change/'.$val['Poll']['id'].'/'.$val['Poll']['status'], array('escape'=>False)),
        $this->Gags->confirmDel($val['Poll']['id'], 'polls')
        );
       echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow); 
endforeach;
?>
</table>