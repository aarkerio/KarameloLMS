<?php 
#die(debug($data)));
$this->set('title_for_layout', __('Gap fillings'));

$this->Html->addCrumb('Control Panel', '/admin/entries/start');
echo $this->Html->getCrumbs(' > '); 

echo $this->Html->div('title_section', $this->Html->image('static/gap_filling_icon.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Gap fillings'), 'title'=>__('Gap fillings'))).' '.__('Gap filling')); 
echo $this->Html->para(null, $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))), '/admin/gaps/edit', array('escape'=>False)));

echo '<table class="tbadmin">';

if ($data):
    $th = array (__('Edit'), __('Title'), __('Status'), __('Delete'));
    echo $this->Html->tableHeaders($th);
endif;
foreach ($data as $val):
  if ($val['Gap']['status'] == 1):
      $img   = 'static/status_1_icon.png';
      $st    = __('Published');
  else:
      $img   = 'static/status_0_icon.png';
      $st    = __('Draft');
  endif;
  $tr = array (
        $this->Gags->sendEdit($val['Gap']['id'], 'Gap'),
        $val['Gap']['title'],
        $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
                    '/admin/gaps/change/'.$val['Gap']['id'].'/'.$val['Gap']['status'], array('escape'=>False)),
        $this->Gags->confirmDel($val['Gap']['id'], 'Gap')
        );
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow); 
 endforeach;
echo '</table>';

if ($data):
    $t  = $this->Html->div(null,$this->Paginator->prev('« '.__('Previous'),null,null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
    $t .= $this->Html->div(null,$this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
    $t .= $this->Html->div(null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
    echo  $this->Html->div(null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));
endif;
# ? > EOF