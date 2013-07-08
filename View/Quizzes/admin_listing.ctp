<?php
#die( debug( $data ));
$this->set('title_for_layout', __('Quizzes'));

$this->Html->addCrumb('Control Panel', '/admin/entries/start');
echo $this->Html->getCrumbs(' > '); 

echo $this->Html->div('title_section', $this->Html->image('admin/icon-quiz.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Quick Quiz'), 'title'=>__('Quick Quiz'))).' '.__('Quick Quiz'));

echo $this->Html->para(null, 
                 $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))), '/admin/quizzes/edit',array('escape'=>False))); 
 
echo '<table class="tbadmin">';

if ($data):
    $th = array (__('Edit'), $this->Paginator->sort('title',__('Title')),  __('Questions'),  $this->Paginator->sort('status',__('Status')), __('View'),__('Delete'));
    echo $this->Html->tableHeaders($th);
endif;

foreach ($data as $val):
    if ($val['Quiz']['status'] == 1):
        $img   = 'static/status_1_icon.png';
        $st    = __('Published');
    else:
        $img   = 'static/status_0_icon.png';
        $st    = __('Draft');
    endif;  

    $tr = array(
              $this->Gags->sendEdit($val['Quiz']['id'], 'quizzes'),
              $val['Quiz']['title'],
              $this->Html->link($this->Html->image('admin/questions_icon.gif', array('alt'=>__('Questions'), 'title'=>__('Questions'))), 
                          '/admin/quizzes/questions/'.$val['Quiz']['id'], array('escape'=>False)),
              $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
                          '/admin/quizzes/change/'.$val['Quiz']['id'].'/'.$val['Quiz']['status'], array('escape'=>False)),
              $this->Html->link($this->Html->image('static/eye_icon.gif', array('alt'=>__('See Quiz'), 'title'=>__('See Quiz'))), '#', array('onclick'=>"javascript:window.open('/admin/quizzes/view/".$val['Quiz']['id']."', 'blank', 'toolbar=no, scrollbars=yes,width=700,height=500')", 'escape'=>False)),
              $this->Gags->confirmDel($val['Quiz']['id'], 'quizzes')
              );
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;
 
echo '</table>';

# ? > EOF
