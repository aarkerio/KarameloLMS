<?php
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
echo $this->Html->getCrumbs(' > ');

echo $this->Html->div('title_section', $this->Html->image('static_pages.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Lessons'), 'title'=>__('Lessons'))).' '.__('Lessons'));
echo $this->Html->para(Null, $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))), '/admin/lessons/edit', array('escape'=>False)) .'   '.
       $this->Html->link($this->Html->image('static/forum.gif', array('alt'=>__('See comments'),'title'=>__('See comments'))), '/admin/lessons/comments', array('onmouseover'=>"Tip('".__('View lasts comments wrote in your lessons')."')", 'onmouseout'=>"UnTip()", 'escape'=>False))
); 
?>
<table class="tbadmin">
<?php
if ( $data ): # rows in database
                  $th = array(__('Edit'), $this->Paginator->sort('title',__('Title')), $this->Paginator->sort('status',__('Status')),  
                              $this->Paginator->sort('public', __('Public')), __('Remove comments'), __('Delete'));
    echo $this->Html->tableHeaders($th);
endif;

foreach ($data as $val):
    if ($val['Lesson']['status'] == 1):
         $img   = 'static/status_1_icon.png';
         $st    = __('Published');
    else:
         $img   = 'static/status_0_icon.png';
         $st    = __('Draft');
         $order = $st;
    endif;
        if ($val['Lesson']['public'] == 1):
         $img1   = 'static/icon_public.png';
         $d1    = __('Public');
    else:
         $img1   = 'static/icon_nonpublic.png';
         $d1   = __('Non public');
    endif;

    $tr = array (
    $this->Gags->sendEdit($val['Lesson']['id'], 'lessons'),
    $this->Html->link($val['Lesson']['title'],'/lessons/view/'.$this->Session->read('Auth.User.username').'/'.$val['Lesson']['id']),
    $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)),
               '/admin/lessons/change/'.$val['Lesson']['id'] .'/'. $val['Lesson']['status'], array('escape'=>False)),
    $this->Html->link($this->Html->image($img1, array('width'=>'14px', 'alt'=>$d1, 'title'=>$d1)),
                    '/admin/lessons/public/'.$val['Lesson']['id'].'/'.$val['Lesson']['public'], array('escape'=>False)),
    $this->Html->link($this->Html->image('static/icon_close.gif', array('width'=>'14px', 'alt'=>__('Remove all comments'), 'title'=>__('Remove all comments'))),
                    '/admin/annotations/delete/'.$val['Lesson']['id'].'/True', array('escape'=>False),
                    sprintf(__('Are you sure you want to delete all messages %s?'), $val['Lesson']['title'])),
    $this->Gags->confirmDel($val['Lesson']['id'], 'lessons')
     );
   
    echo $this->Html->tableCells($tr,GagsHelper::$aRow, GagsHelper::$eRow);     
endforeach;

echo '</table>';

if ( $this->Paginator->counter() > 10):
    $t = $this->Html->div(Null,$this->Paginator->prev('« '.__('Previous'),null,null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
    $t .= $this->Html->div(Null,$this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
    $t .= $this->Html->div(Null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
    echo  $this->Html->div(Null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));
endif;

# ? > EOF

