<?php
  echo $this->Html->div('title_section', $this->Html->image('news-icon.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('News'), 'title'=>__('News'))).' '.__('News'));
  echo $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))), '/admin/news/edit',  array('escape'=>False));
  echo '&nbsp;&nbsp;&nbsp;'; 
  echo $this->Html->link($this->Html->image('static/forum.gif', array('alt'=>__('See comments'),'title'=>__('See comments'))), '/admin/discussions/listing',  array('escape'=>False));
?>
<table class="tbadmin">
<?php
$th = array(__('Edit'), __('Title'), __('Author'), __('Status'), __('Delete'));
echo $this->Html->tableHeaders($th);	
foreach ($data as $key=>$val):
     if ($val['News']['status'] == 1):
         $img   = 'static/status_1_icon.png';
         $st    = __('Published');
     else:
         $img   = 'static/status_0_icon.png';
         $st    = __('Draft');
         $order = $st;
    endif;

       $tr = array (
        $this->Gags->sendEdit($val['News']['id'], 'news'),
        $val['News']['title'],
        $val['User']['username'],
        $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
                          '/admin/news/change/'.$val['News']['status'].'/'.$val['News']['id'], array('escape'=>False)),
        $this->Gags->confirmDel($val['News']['id'], 'news')
        );
       
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
    
endforeach;

echo '</table>';

$t  = $this->Html->div(null,$this->Paginator->prev('« '.__('Previous'). ' ',Null,Null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
$t .= $this->Html->div(null, $this->Paginator->next(' '.__('Next'). ' »', Null, Null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
$t .= $this->Html->div(null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
echo  $this->Html->div(null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));
?>