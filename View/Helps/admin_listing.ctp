<?php
 $this->Html->addCrumb('Control Panel', '/admin/entries/start');
 echo $this->Html->getCrumbs(' > '); 

 echo $this->Html->div('title_section', __('Helps'));
 echo $this->Html->div(null, $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))), '/admin/helps/edit', array('escape'=>False)));
 echo '<table class="tbadmin">';
 $th = array (__('Edit'), __('Title'), 'URL', 'Lang', __('Delete'));
 echo $this->Html->tableHeaders($th, array('style'=>'text-align:center'));
 foreach ($data as $v):
       $tr = array (
        $this->Gags->sendEdit($v['Help']['id'], 'helps'),
        $v['Help']['title'],
        $v['Help']['url'],
        $v['Help']['lang'],
        $this->Gags->confirmDel($v['Help']['id'], 'helps')
        );
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
 endforeach;

echo '</table>';

# ? > EOF
