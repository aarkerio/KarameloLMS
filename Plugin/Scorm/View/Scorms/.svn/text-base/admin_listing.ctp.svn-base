<?php
 #die(debug($data));
 $this->set('title_for_layout', 'SCORMs');
 $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
 echo $this->Html->getCrumbs('>');
 echo $this->Html->div('title_section', 'SCORMs');
 echo $this->Html->para(null, 
     # $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'),'title'=>__('Add new'))), 
     #                                   '/admin/scorms/add', array('escape'=>False)).' '. 
     $this->Html->link($this->Html->image('static/file_zip.gif', array('alt'=>__('Import SCORM'),'title'=>__('Import SCORM'))), 
                   '/admin/scorm/scorms/import', array('escape'=>False)));

echo '<table style="width:100%;border-collapse: collapse;">';

$th = array (__('Edit'), __('Name'),  __('Mode View'), __('Export'), __('View'), __('Status'), __('Delete'));

echo $this->Html->tableHeaders($th, array('style'=>'text-align:left;font-size:8pt;'));
#var_dump($data);
foreach ($data as $val):
    if ($val['Scorm']['status'] == 1):
        $img   = 'static/status_1_icon.png';
	    $st    = __('Published');
    else:
        $img   = 'static/status_0_icon.png';
        $st    = __('Draft');
        $order = $st;
    endif;
    if ( $val['Scorm']['popup'] == 0):
        $view = $this->Html->image('static/icon_window.png', array('alt'=>__('Embedded'), 'title'=>__('Embedded')));
    else:
        $view = $this->Html->image('static/icon_popup.png', array('alt'=>__('Popup Window'), 'title'=>__('Popup Window'))); 
    endif;
    $tr = array (
           $this->Gags->sendEdit($val['Scorm']['id'], 'scorms'),
           $this->Html->link($val['Scorm']['name'], '/scorm/scorms/view/'.$val['Scorm']['id']),
	       $this->Html->link($view, '/admin/scorm/scorms/view/'.$val['Scorm']['id'].'/'. $val['Scorm']['popup'], array('escape'=>False)),
           $this->Html->link($this->Html->image('static/export-icon.png', array('alt'=>__('Export'), 'title'=>__('Export'))),
                    '/admin/scorm/scorms/export/'.$val['Scorm']['id'], array('escape'=>False)),
           $this->Html->link('View', '/scorm/scorms/view/'. $val['Scorm']['id'] .'/aarkerio/1'),
           $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
                    '/admin/scorm/scorms/change/'.$val['Scorm']['id'].'/'.$val['Scorm']['status'], array('escape'=>False)),
           $this->Gags->confirmDel($val['Scorm']['id'], 'scorms')
        );
       
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;
?> 
</table>
<script type="text/javascript"> 
<!-- 
function hU() {

var tr = document.getElementById('trh');

  if (tr.style.display == 'none')
  {
            tr.style.display = 'block';
  } else {
            tr.style.display = 'none';
  }
}
-->
</script>
