<?php
#die( debug( $data ));
$this->set('title_for_layout', __('Tests'));

$this->Html->addCrumb('Control Panel', '/admin/entries/start');
echo $this->Html->getCrumbs(' > '); 

echo $this->Html->div('title_section', $this->Html->image('admin/tests.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Tests'), 'title'=>__('Tests'))).' '.__('Tests'));

echo $this->Html->para(null, 
                 $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))), '/admin/tests/edit',array('escape'=>False))); 

echo '<table class="tbadmin">';

if ($data):
    $th = array (__('Edit'), $this->Paginator->sort('title',__('Title')),  __('Questions'), __('Display'),$this->Paginator->sort('status',__('Status')), __('View'),__('Delete'));
    echo $this->Html->tableHeaders($th);
endif;

foreach ($data as $val):
    if ($val['Test']['status'] == 1):
        $img   = 'static/status_1_icon.png';
        $st    = __('Published');
    else:
        $img   = 'static/status_0_icon.png';
        $st    = __('Draft');
    endif;  
    if ($val['Test']['type'] == 1 ):
        $icon   = 'static/icon_write.png'; 
        $iconst = __('Display all questions in one single page'); 
    else: 
        $icon='static/icon_test.jpg';
        $iconst = __('Display one question at a time'); 
    endif;
    $tr = array(
              $this->Gags->sendEdit($val['Test']['id'], 'tests'),
              $val['Test']['title'],
              $this->Html->link($this->Html->image('admin/questions_icon.gif', array('alt'=>__('Questions'), 'title'=>__('Questions'))), 
                          '/admin/tests/questions/'.$val['Test']['id'], array('escape'=>False)),
              $this->Html->link($this->Html->image($icon, array('width'=>'14px', 'alt'=>$iconst, 'title'=>$iconst)), 
                          '/admin/tests/change/'.$val['Test']['id'].'/'.$val['Test']['type'].'/True', array('escape'=>False)),
              $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
                          '/admin/tests/change/'.$val['Test']['id'].'/'.$val['Test']['status'], array('escape'=>False)),
              $this->Html->link($this->Html->image('static/eye_icon.gif', array('alt'=>__('See Test'), 'title'=>__('See Test'))), '#', array('onclick'=>"javascript:window.open('/admin/tests/view/".$val['Test']['id']."', 'blank', 'toolbar=no, scrollbars=yes,width=700,height=500')", 'escape'=>False)),
              $this->Gags->confirmDel($val['Test']['id'], 'tests')
              );
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;
 
echo '</table>';

# ? > EOF
