<?php 
 $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
 echo $this->Html->getCrumbs(' > ');

 echo $this->Html->div('title_section', $this->Html->image('areas.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Subjects'), 'title'=>__('Subjects'))).' '.__('Subjects'));
 echo $this->Html->para(Null, $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add news'))), '/admin/subjects/add', array('escape'=>False)));
?>
<table class="tbadmin">
<?php
$th = array (__('Edit'), __('Code'), __('Title'), __('Delete'));
echo $this->Html->tableHeaders($th, array('style'=>'text-align:left'));
foreach ($data as $val):
       $tr = array (
        $this->Gags->sendEdit($val['Subject']['id'], 'Subject'),
        $val['Subject']['code'],
        $val['Subject']['title'],
        $this->Gags->confirmDel($val['Subject']['id'], 'Subject')
        );
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow); 
endforeach;

echo '</table>';

# ? > EOF
