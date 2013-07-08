<?php 
#die(debug($data));
echo $this->Html->script(array('jquery-min', 'jquery-plugins/jquery.jeditable'));
$this->set('title_for_layout', __('Participations'));

$this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
$this->Html->addCrumb(__('vClassrooms'), '/admin/vclassrooms/listing');
$this->Html->addCrumb(__('Back to Vclassroom'), '/admin/vclassrooms/members/'.$vclassroom_id);
echo $this->Html->getCrumbs(' > ');

echo $this->Html->div('title_section', $this->Html->image('static/icon_write.png', array('style'=>'width:28px;margin-right:6px;', 'alt'=>__('Participations'), 'title'=>__('Participations'))).' '.__('Participations'));

echo $this->Gags->imgLoad('loading');

echo $this->Gags->ajaxDiv('updater') . $this->Gags->divEnd('updater');

if ( !$data ):
    $tmp = __('Oops, there are no participations yet', True);
else:
    $msg   = __('Are you sure you want to permanently delete ALL reports?');
    $tmp = $this->Html->link($this->Html->image('static/delete_icon.png', array('width'=>'16px','alt'=>__('Delete all'),'title'=>__('Delete all'))), 
                       '/admin/participations/unlink/'.$vclassroom_id,  array('onclick'=>"return confirm('".$msg."')", 'escape'=>False));
endif;

echo $this->Html->div('notice-message', $tmp);


echo '<table class="ajax_table">';
# Table headers
echo '<tr style="text-align:left;font-size:8pt;font-weight:bold;"><td>'.$this->Paginator->sort('Participation.description',__('Description')).'</td>';
echo '<td>'.__('Points').'</td>'; 
echo '<td>'.$this->Paginator->sort('Participation.created',__('Created')).'</td><td>'. $this->Paginator->sort('User.name',__('Student')).'</td><td>'. __('View').'</td><td>'.__('Granded').'</td><td>'. __('Checked').'</td><td>'. __('Delete').'</td></tr>';

#end of table header
$msg   = __('Are you sure to want to delete this?');
$counter = (int) 1;
foreach ($data as $val):
    $counter++;
    $participation_id = (int) $val['Participation']['id'];
    $div_id           = 'rep'.$participation_id; 
   
    if ( $val['Participation']['checked'] == 0 ):
        $img = 'static/img_correct_gray.gif';
        $alt = __('Participation not rating yet');
        $lk  = $this->Html->link($this->Html->image($img, array('alt'=>$alt, 'title'=>$alt)),'/admin/participations/share/'.$participation_id, array('escape'=>False));
    else:
        $img = 'static/img_correct.gif';
        $alt = __('Participation already rated');
        $lk  = $this->Html->image($img, array('alt'=>$alt, 'title'=>$alt));
    endif;

    if ( $counter%2 ):
        $class = 'class="altRow" onmouseover="this.className=&#039;highlight&#039;" onmouseout="this.className=&#039;altRow&#039;"';
    else:
        $class = 'class="evenRow" onmouseover="this.className=&#039;highlight&#039;" onmouseout="this.className=&#039;evenRow&#039;"';
    endif;
 
    echo '<tr '.$class.'">';
echo '<td title="'.__('Click to edit').'" class="editable_textile" id="participation_'.$participation_id.'">'.Sanitize::html($val['Participation']['title']).'</td>';
    echo '<td id='.$div_id.'>'.$val['Participation']['points'].' '.__('Points').'</td>';
    echo '<td><span style="font-size:7pt;">'. $val['Participation']['created']. '</span></td>';
    echo '<td>'. $val['User']['name'].' '. $this->Html->image('avatars/'.$val['User']['avatar'], array('width'=>'24px', 'alt'=> $val['User']['name'], 'title'=> $val['User']['username'])).'</td>';
    echo '<td>'.$this->Html->link($this->Html->image('static/eye_icon.gif', array('alt'=>__('View'), 'title'=>__('View'))), '#', array('onclick'=>"window.open('/admin/participations/show/".$participation_id."','mywin','left=20,top=20,width=700,height=700,toolbar=0,resizable=1');return false;", 'escape'=>False)).'</td>';
    echo '<td>'; 
    echo $this->Js->link($this->Html->image('static/adownmod.png', array('alt'=>__('Points down'), 'title'=>__('Points down'))) ,
                           '/admin/participations/points/'.$participation_id.'/down',
                        array('update'      => '#rep'.$participation_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'loading'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'loading'), 
                              'escape'      => False ));
    echo $this->Js->link($this->Html->image('static/aupmod.png', array('alt'=>__('Points up'), 'title'=>__('Points up'))),
                           '/admin/participations/points/'.$participation_id.'/up',
                        array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'loading'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'loading'),
                              'escape'      => False ));
    echo '</td>';
    echo '<td>'.$lk.'</td>';
    echo '<td>'. $this->Html->link($this->Html->image('static/delete_icon.png', array('width'=>'14px', 'alt'=>__('Delete'), 'title'=>__('Delete'))),
                                  '/admin/participations/delete/'.$participation_id.'/'.$vclassroom_id, array('onclick'=>"return confirm('".$msg."')", 'escape'=>False));
    echo '</td></tr>';     
endforeach;

echo '</table>';

if ($data):
    $t  = $this->Html->div(Null,$this->Paginator->prev('« '.__('Previous'),null,null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
    $t .= $this->Html->div(Null,$this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
    $t .= $this->Html->div(Null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
    echo  $this->Html->div(Null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));
endif;

echo $this->Html->scriptStart();
?>
    $(document).ready(function() {
            $(".editable_textile").editable("/admin/participations/edit/", { 
                        indicator : "<img src='/img/static/loading.gif'>",
                        type   : 'text',
                        maxlength: 38,
                        submitdata: { _method: "put" },
                        select : true,
                        submit : 'OK',
                        tooltip   : 'Click to edit...',
                        cancel : 'cancel',
                        cssclass : "editable"
                        });
        });
<?php 
echo $this->Html->scriptEnd();
# ? > EOF