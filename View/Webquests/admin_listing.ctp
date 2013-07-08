<?php
$this->Html->addCrumb('Control Panel', '/admin/entries/start');  
echo $this->Html->getCrumbs(' > ');
 
echo $this->Html->div('title_section', $this->Html->image('webquests.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Webquests'), 'title'=>__('Webquets'))).' Webquests');

echo $this->Gags->imgLoad('loading');

echo $this->Gags->ajaxDiv('envelope');

echo $this->Js->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))),
                 '/admin/webquests/start', array('update'  => '#setform',
                                                 'before'  => $this->Gags->ajaxBefore('setform'), 
                                                 'complete'=> $this->Gags->ajaxComplete('setform'), 
                                                 'escape'  => False));

echo $this->Gags->ajaxDiv('setform') . $this->Gags->divEnd('setform');

echo $this->Gags->divEnd('envelope');
echo '<table class="tbadmin">';
if ($data):
    $th = array (__('Edit'), __('Title'),  __('Points'), __('Status'), __('Delete'));
    echo $this->Html->tableHeaders($th);
endif;
foreach ($data as $val):
    if ($val['Webquest']['status'] == 1):
         $img   = 'static/status_1_icon.png';
         $st    = __('Published');
    else:
         $img   = 'static/status_0_icon.png';
         $st    = __('Draft');
         $order = $st;
    endif;
    $tr = array($this->Gags->sendEdit($val['Webquest']['id'], 'webquests'),
            $val['Webquest']['title'], 
            $val['Webquest']['points'],
            $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
                        '/admin/webquests/change/'.$val['Webquest']['id'].'/'.$val['Webquest']['status'], array('escape'=>False)),
            $this->Gags->confirmDel($val['Webquest']['id'], 'webquests')
    );
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;
?>
</table>
<?php echo $this->Html->scriptStart(); ?>
function validateWebquest()
{ 
  var title = document.getElementById('WebquestTitle');
  
  //alert('I am here');
  
  if (title.value.length < 5)
  {
    alert('The title must have five letters at least');
    title.focus();
    return false;
  }

return true;
}

<?php
 echo $this->Html->scriptEnd();
 echo $this->Js->writeBuffer();
# ? > EOF