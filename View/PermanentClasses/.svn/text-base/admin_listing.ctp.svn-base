<?php 
$this->set('title_for_layout',  __('Permanent list'));
echo $this->Html->para(Null, __('You can create lists of students and impor them in several Virtual Classrooms later'));
$this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
echo $this->Html->getCrumbs(' > '); 

echo $this->Html->div('title_section', $this->Html->image('static/newsletter-icon.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Permanent Class'), 'title'=>__('permanent_class'))).' '.__('Permanent Class'));

echo $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))), '/admin/permanent_classes/edit', array('escape'=>False));

echo '<table class="tbadmin">';
if ($data):
    $th = array(__('Edit'), __('Title'), __('Students'),  __('Archived'), __('Created'), __('Delete'));
    echo $this->Html->tableHeaders($th, array('style'=>'text-align:left;'));
endif;

foreach ($data as $val):
       $archived = ($val['PermanentClass']['archived'] == 0) ? 'No' : __('Yes');
       $tr = array (
         $this->Gags->sendEdit($val['PermanentClass']['id'], 'permanent_classes'),
         $val['PermanentClass']['title'],
         $this->Html->image('admin/assign_icon.png', array('alt'=>__('Display'),'title'=>__('Display'),'url'=> '/admin/permanent_classes/record/'.$val['PermanentClass']['id'])), 
         $this->Html->image('admin/historic.png',array('alt'=>__('Archives'),'title'=>__('Archived'),'url'=>'/admin/permanent_classes/change/'.$val['PermanentClass']['id'])),
         $val['PermanentClass']['created'],
         $this->Gags->confirmDel($val['PermanentClass']['id'], 'permanent_classes')
        );
        
        echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow); 
endforeach;

echo '</table>';
 

# ? > EOF

