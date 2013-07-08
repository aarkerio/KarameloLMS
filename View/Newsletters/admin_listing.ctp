<?php 
$this->set('title_for_layout',  __('Newsletters'));
$this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
echo $this->Html->getCrumbs(' > '); 

echo $this->Html->div('title_section', $this->Html->image('static/newsletter-icon.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Newsletters'), 'title'=>__('Newsletters'))).' '.__('Newsletters'));

 echo $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))), '/admin/newsletters/edit', array('escape'=>False));

echo '<table class="tbadmin">';
if ($data):
    $th = array(__('Edit'), __('Title'), 'Status', __('Delivered'), __('Public'), __('Sent'), __('Delete'));
    echo $this->Html->tableHeaders($th, array('style'=>'text-align:left;'));
endif;

foreach ($data as $val):
       $st = $this->Gags->setStatus($val['Newsletter']['status']);
       $pb = ($val['Newsletter']['public'] == 0) ? 'No' : __('Yes');
       $delivered = ($val['Newsletter']['delivered'] == 0) ? 'No' : __('Yes');
       $tr = array (
         $this->Gags->sendEdit($val['Newsletter']['id'], 'newsletters'),
         $val['Newsletter']['title'],
         $this->Html->link($st, '/admin/newsletters/change/'.$val['Newsletter']['id'].'/'.$val['Newsletter']['status']),
         $delivered, 
         $this->Html->link($pb, '/admin/newsletters/public/'.$val['Newsletter']['id'].'/'.$val['Newsletter']['public']),
         $this->Html->link($this->Html->image('admin/send.gif', array('alt'=>__('Send'), 'title'=>__('Send'))),
                    '/admin/newsletters/share/'.$val['Newsletter']['id'], array('escape'=>False)),
         $this->Gags->confirmDel($val['Newsletter']['id'], 'newsletters')
        );
        
        echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow); 
endforeach;

echo '</table>';
 
#echo $pagination;

# ? > EOF

