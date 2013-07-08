<?php
#Paginator options for ajax
$this->Paginator->options(array(
                                'url'=>array('controller'=>'shares', 'action'=>'admin_listing'),
                                'update'      => '#list',
                                'evalScripts' => True,
                                'before'      => $this->Gags->ajaxBefore(),
                                'complete'    => $this->Gags->ajaxComplete())); 

if ( $ajax == False):
    $this->Html->addCrumb('Control Panel', '/admin/entries/start');
    echo $this->Html->getCrumbs(' > ');

    echo $this->Html->div('title_section', $this->Html->image('mmultimedia.png', array('style'=>'width:35px;margin-right:6px;', 
                'alt'=>__('shared files'), 'title'=>__('shared files'))).' '.
                $this->Session->read('Auth.User.username').'\'s '. __('shared files'));
echo $this->Html->para(Null, 
                 $this->Html->link(
                             $this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'), 'onmouseover'=>'Tip("'.__('Add new share').'")', 'onmouseout' => 'UnTip()')), '#', array('escape'=>False,'onclick'=>'hU()')));

endif;
echo $this->Gags->imgLoad('loading');
echo $this->Gags->ajaxDiv('list'); #ajax div for listing 
echo $this->Session->flash();

$visibility = isset($show) ? 'block' :  'none';  # ajax validation, display or not upload form with error Model validations
echo '<div id="addshare" style="display:'.$visibility.'">'; 

echo $this->Gags->maxUploadSize();
echo $this->Form->create('Share', array('type'=>'file', 'action'=>'add'));
?>
<fieldset>
  <legend><?php __('Upload file'); ?></legend>
  <?php 
     echo $this->Form->input('Share.file', array('type'=>'file', 'label'=>__('File'), 'class'=>'required'));
     echo $this->Form->input('Share.description', array('size'=>50, 'label'=> __('Description'), 'class'=>'required'));
     echo $this->Form->input('Share.subject_id', array('label'=> __('Subject'), 'options'=>$subjects));
     echo $this->Form->input('Share.knet',   array('type'=>'checkbox', 'value'=>'1', 'label'=> __('Share in Knet')));
     echo $this->Form->input('Share.public', array('type'=>'checkbox', 'value'=>'1', 'label'=> __('Public')));
     echo $this->Form->input('Share.status', array('type'=>'checkbox', 'value'=>'1', 'label'=> __('Published')));
     echo '</fieldset>';
     echo $this->Form->end(__('Upload'));
   ?>
</div><!-- addshare -->

<table style="width:100%;;border-collapse:collapse;margin:auto;padding:5px;">
<?php
if ($data): # rows in database
    $th = array(__('Edit'),__('Download'), __('File'), 
        $this->Paginator->sort('Share.description',__('Description'), array('onmouseover'=>"Tip('".__('Sort your shares by description')."')",
                      'onmouseout'=>'UnTip()', 
                      'update'    => '#list', 
                      'before'    => $this->Gags->ajaxBefore(), 
                      'complete'  => $this->Gags->ajaxComplete())), 
        $this->Paginator->sort('Share.subject_id',__('Subject'),array('onmouseover'=>"Tip('".__('Sort your shares by subject')."')",
                      'onmouseout' => 'UnTip()', 
                      'update'     => '#list', 
                      'before'     => $this->Gags->ajaxBefore(),
                      'complete'   => $this->Gags->ajaxComplete())),
        $this->Paginator->sort( 'Share.public',__('Public'), array('onmouseover' => "Tip('".__('Sort your shares by public')."')",         
                      'onmouseout' =>'UnTip()', 
                      'update'     => '#list', 
                      'before'     => $this->Gags->ajaxBefore(), 
                      'complete'   => $this->Gags->ajaxComplete())),
        $this->Paginator->sort('Share.status',__('Published'), array("onmouseover" => "Tip('".__('Sort your shares by published')."')", 
                      'onmouseout' =>'UnTip()', 
                      'update'     => '#list', 
                      'before'     => $this->Gags->ajaxBefore(),
                      'complete'   =>  $this->Gags->ajaxComplete())),
        $this->Paginator->sort('Share.created',__('Added'), array('onmouseover' => "Tip('".__('Sort your shares by created')."')",
                      'onmouseout' =>'UnTip()', 
                      'update'     => '#list', 
                      'before'     => $this->Gags->ajaxBefore(), 
                      'complete'   => $this->Gags->ajaxComplete())), 
            __('Delete'));
echo $this->Html->tableHeaders($th, array('style'=>'font-size:7pt;'));
endif;

foreach ($data as $val):
    $share_id = (int) $val['Share']['id'];

    if ($val['Share']['public'] == 1):
         $img1   = 'static/icon_public.png';
         $d1    = __('Public');
    else:
         $img1   = 'static/icon_nonpublic.png';
         $d1   = __('Non public');
    endif;
  
    if ($val['Share']['status'] == 1):
         $img2   = 'static/status_1_icon.png';
         $d2    = __('Published');
    else:
         $img2   = 'static/status_0_icon.png';
         $d2   = __('Draft');
    endif;
 
    #Start of <tr>   
    $tr = array(
        #Edit button
        $this->Gags->sendEdit($val['Share']['id'], 'Share'),
        #Download image
        $this->Html->link($this->Html->image('static/button_download.gif', array('alt'=>__('Download'), 'title'=>__('Download'))),
                           '/shares/download/'.$val['Share']['secret'], array('escape'=>False)),
        #Link to file
        $this->Html->link($val['Share']['file'], '/files/userfiles/'.$val['Share']['file']),
        #Share description
        $val['Share']['description'],
        #Share title
        $val['Subject']['title'],
        #Ajax link to change public
        $this->Js->link($this->Html->image($img1, array('width'=>'14px', 'alt'=>$d1, 'title'=>$d1)),
         '/admin/shares/public/'.$share_id.'/'.$val['Share']['public'].'/'.$this->Paginator->current().'/'.$this->Paginator->sortKey().'/'.$this->Paginator->sortDir(), 
                   array('update'   => '#list',
                         'before'   => $this->Gags->ajaxBefore(), 
                         'complete' => $this->Gags->ajaxComplete(),
                         'escape'   => False,
                         'id'       => $share_id)),
        #Ajax link to change status
        $this->Js->link($this->Html->image($img2, array('width'=>'14px', 'alt'=>$d2, 'title'=>$d2)),
         '/admin/shares/change/'.$share_id.'/'.$val['Share']['status'].'/'.$this->Paginator->current().'/'.$this->Paginator->sortKey().'/'.$this->Paginator->sortDir(), 
                   array('update'   => '#list',
                         'before'   => $this->Gags->ajaxBefore(), 
                         'complete' => $this->Gags->ajaxComplete(),
                         'escape'   => False,
                         'id'       => $share_id)),
        #Created
        $val['Share']['created'],
        #Delete button
        $this->Gags->confirmDel($val['Share']['id'], 'shares')
        );
    #End of <tr> 
   echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow); 
endforeach;

echo '</table>';

echo $this->Html->div('pagination');

$pages_num = $this->Paginator->counter(array('format'=>'%pages%'));
if ( $pages_num > 1 ):
 
    echo  $this->Html->div(null,null, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));
    echo $this->Html->div(null,$this->Paginator->prev('« '.__('Previous'),Null,Null,array('class'=>'disabled')),
                                         array('style'=>'width:100px;float:left'));
    echo $this->Html->div(null,$this->Paginator->next(__('Next').' »', Null, Null, array('class' => 'disabled')),
                                         array('style'=>'width:100px;float:right'));
    echo $this->Html->div(null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
    echo $this->Html->div('pag_number','<br>'.__('Pages').': '.$this->Paginator->numbers(array('modulus' => 9)));

endif;
echo '</div>';
    
echo $this->Gags->divEnd('list'); #End for ajax listing
?>

<script type="text/javascript"> 
<!-- 
function hU() 
{
  var tr = document.getElementById('addshare');

  if (tr.style.display == 'none')
  {
            tr.style.display = 'block';
  } else {
            tr.style.display = 'none';
  }
}
-->
</script>
