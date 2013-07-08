<?php 
#die(debug($data));
 
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
echo $this->Html->getCrumbs(' > '); 
echo $this->Html->div('title_section', $this->Html->image('static/medias_icon.jpg', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Messages'), 'title'=>__('Messages'))).' '.__('Books & Collections') . ' ('.__('School library') .')'); 

echo $this->Html->para(null, $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))), '/admin/collections/edit', array('escape'=>False)) . ' &nbsp;&nbsp;  '.$this->Html->link($this->Html->image('static/borrow_icon.gif', array('alt'=>__('Lent'),'title'=>__('Lent'), 'width'=>25)), '/admin/collections/record', array('escape'=>False)));
 $lent =  __('New lent');

echo '<table class="tbadmin">';

if ($data):
    $th = array(__('Edit'), $this->Paginator->sort(__('Title'), 'title'), 
    $this->Paginator->sort('author',__('Author')), $this->Paginator->sort('status',__('Status')), $lent,  __('Delete'));
    echo $this->Html->tableHeaders($th);
endif;
$msg   = __('Are you sure to want to delete this?');
foreach ($data as $val):
     if ($val['Collection']['status'] == 1):
        $img   = 'static/status_1_icon.png';
        $st    = __('Published');
     else:
        $img   = 'static/status_0_icon.png';
        $st    = __('Draft');
        $order = $st;
    endif;
    if ( $val['Collection']['copies'] > count( $val['Lending']) ):
        $share = 'static/icon_share.png';
        $lent  =  __('New lent');
        $str   =  $this->Html->link($this->Html->image($share, array('width'=>'14px', 'alt'=>$lent, 'title'=>$lent)), 
                    '/admin/collections/add/'.$val['Collection']['id'], array('escape'=>False));
    else:
        $share = 'static/icon_share_gray.png';
        $lent  =  __('All copies lented');
        $str   =  $this->Html->image($share, array('width'=>'14px', 'alt'=>$lent, 'title'=>$lent));
    endif;
    $tr = array (
        $this->Html->link($this->Html->image('static/edit_icon.gif', array('width'=>'16px', 'alt'=>__('Edit'), 'title'=>__('Edit'))), '/admin/collections/edit/'.$val['Collection']['id'], array('escape'=>False)),
        $val['Collection']['title'],
        $val['Collection']['author'],
        $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
        '/admin/collections/change/'.$val['Collection']['id'].'/'.$val['Collection']['status'], array('escape'=>False)),
        $str,
        $this->Html->link($this->Html->image('static/delete_icon.png', array('width'=>'16px', 'alt'=>__('Delete'), 
                        'title'=>__('Delete'))), '/admin/collections/delete/'.$val['Collection']['id'],
                          array('onclick'=>"return confirm('".$msg."')", 'escape'=>False)) 
    );
       
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow); 
endforeach;

echo '</table>';

if ($data):
    $t  = $this->Html->div(Null,$this->Paginator->prev('« '.__('Previous'),Null,Null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
    $t .= $this->Html->div(Null,$this->Paginator->next(__('Next').' »', Null, Null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
    $t .= $this->Html->div(Null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
    echo  $this->Html->div(Null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));
endif;

# ? > EOF