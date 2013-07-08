<?php
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
echo $this->Html->getCrumbs(' > '); 

echo $this->Html->div('title_section', $this->Html->image('wikis.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('WikiPages'), 'title'=>__('WikiPages'))).' '.__('WikiPages')); 

echo $this->Html->para(Null, $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))), '/admin/wikis/edit', array('escape'=>False)));
?>
<table class="tbadmin">
<?php
$th = array(__('Edit'), __('Title'), __('Status'), __('See'),__('Public'), __('Delete'));
echo $this->Html->tableHeaders($th);
foreach ($data as $val):
  if ($val['Wiki']['status'] == 1):
         $img   = 'static/status_1_icon.png';
         $st    = __('Published');
  else:
         $img   = 'static/status_0_icon.png';
         $st    = __('Draft');
  endif;

  if ($val['Wiki']['public'] == 1):
         $img2   = 'static/icon_public.png';
         $st2    = __('Public');
  else:
         $img2   = 'static/icon_nonpublic.png';
         $st2    = __('Non public');
  endif;

  $tr = array(
	     $this->Gags->sendEdit($val['Wiki']['id'], 'Wiki'),
	     $val['Wiki']['title'],
	     $this->Html->link($this->Html->image($img, array('width'=>'14px','alt'=>$st, 'title'=>$st)),'/admin/wikis/change/'.$val['Wiki']['id'].'/'.$val['Wiki']['status'], array('escape'=>False)), 
             $this->Html->link($this->Html->image('static/view-icon.png', array('alt'=>__('See WikiPage'), 'title'=>__('See WikiPage'))), '/wikis/view/'.$this->Session->read('Auth.User.username').'/'.$val['Wiki']['slug'],  array('escape'=>False)),
             $this->Html->link($this->Html->image($img2, array('width'=>'17px','alt'=>$st2, 'title'=>$st2)),'/admin/wikis/public/'.$val['Wiki']['id'].'/'.$val['Wiki']['public'],  array('escape'=>False)),
	     $this->Gags->confirmDel($val['Wiki']['id'], 'Wiki')
	     );
   echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow); 
endforeach;

echo '</table>';

# echo $pagination; 
# ? >  EOF

