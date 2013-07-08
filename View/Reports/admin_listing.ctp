<?php 
#die(debug($data));
echo $this->Html->script(array('jquery-min', 'jquery-plugins/jquery.jeditable'));
$this->set('title_for_layout','Reports');

$this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
$this->Html->addCrumb(__('vClassrooms'), '/admin/vclassrooms/listing');
$this->Html->addCrumb(__('Back to Vclassroom'), '/admin/vclassrooms/members/'.$vclassroom_id);
echo $this->Html->getCrumbs(' > ');

echo $this->Html->div('title_section', $this->Html->image('admin/icon_report.png', array('style'=>'margin-right:6px;', 'alt'=>__('Reports'), 'title'=>__('Reports'))).' '.__('Reports'));

echo $this->Gags->imgLoad('loading');

if ( !$data ):
    $tmp = __('Oops, there are no reports yet', False);
else:
    $msg   = __('Are you sure you want to permanently delete ALL reports?');
    $tmp = $this->Html->link($this->Html->image('static/delete_icon.png', array('width'=>'16px','alt'=>__('Delete all'),'title'=>__('Delete all'))),  
                    '/admin/reports/unlink/'.$vclassroom_id,  array('onclick'=>"return confirm('".$msg."')", 'escape'=>False));
endif;

echo $this->Html->div('notice-message', $tmp);

echo $this->Gags->ajaxDiv('updater') . $this->Gags->divEnd('updater');

echo '<table class="ajax_table">';
# Table headers
echo '<tr style="text-align:left;font-size:8pt;font-weight:bold;"><td>'.$this->Paginator->sort('Report.description',__('Description')).'</td>';
echo '<td>'.$this->Paginator->sort('Activity.id',__('Activity')).'</td>';
echo '<td>Kbytes</td>';
echo '<td>'.__('Points').'</td>';
echo '<td>'.$this->Paginator->sort('Report.created',__('Created')).'</td><td>'. $this->Paginator->sort('User.username',__('Student')).'</td><td>'. __('Download').'</td><td>'.__('Grade').'</td><td>'. $this->Paginator->sort( 'Report.checked',__('Rating')).'</td><td>'. __('Delete').'</td></tr>';
 
#end of table header
$msg   = __('Are you sure to want to delete this?');
$counter = (int) 1;
foreach ($data as $val):
    $counter++;
    $download = __('Download') . ': '.$val['Report']['filename'];
    if ( strlen($val['Report']['description']) > 1):
        $description = (string) $val['Report']['description'];
    else:
        $description = (string) __('Report');
    endif;

    if ( $val['Report']['checked'] == 0 ):
        $img = 'static/img_correct_gray.gif';
        $alt = __('Report not rating yet');
        $lk  = $this->Html->link($this->Html->image($img, array('alt'=>$alt, 'title'=>$alt)),'/admin/reports/share/'.$val['Report']['id'], array('escape'=>False));
    else:
        $img = 'static/img_correct.gif';
        $alt = __('Report already rated');
        $lk  = $this->Html->image($img, array('alt'=>$alt, 'title'=>$alt));
    endif;
    $report_id = (int) $val['Report']['id'];
    $div_id    = 'rep'.$report_id; 
    if ( $counter%2 ):
        $class = GagsHelper::$aRow;
    else:
        $class = GagsHelper::$eRow;
    endif;
    echo '<tr class="'.$class['class'].'" onmouseover="this.className=\'highlight\'" onmouseout="this.className=\''.$class['class'].'\'">'; 
    echo '<td class="editable_textile" id="report_'.$val['Report']['id'].'">'.Sanitize::html($description).'</td>';
    echo '<td>'.$val['Activity']['title'].'</td>';
    echo '<td id='.$div_id.'>'.$val['Report']['points'].' '.__('Points').'</td>';
    echo '<td style="font-weight:bold;font-size:7pt;">' .filesize('../webroot/files/studentsfiles/'.trim($val['Report']['filename'])) . '</td>';
    echo '<td><span style="font-size:7pt;">'. $val['Report']['created']. '</span></td>';
    echo '<td>'.$this->Html->link($val['User']['username'], '/admin/vclassrooms/record/'.$val['User']['id'].'/'.$vclassroom_id).' '. $this->Html->image('avatars/'.$val['User']['avatar'], 
                array('width'=>'24px', 'alt'=> $val['User']['name'], 'title'=> $val['User']['name'])).'</td>';
    echo '<td>'.$this->Html->link($this->Html->image('static/button_download.gif', array('alt'=>$download, 'title'=>$download)), '/admin/reports/download/'.$report_id, array('escape'=>False)).'</td>';
    echo '<td>'; 
    echo $this->Js->link($this->Html->image('static/adownmod.png', array('alt'=>__('Points down'), 'title'=>__('Points down'))) ,
                           '/admin/reports/points/'.$report_id.'/down',
                        array('update'      => '#rep'.$report_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'loading'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'loading'), 
                              'escape'      => False ));
    echo $this->Js->link($this->Html->image('static/aupmod.png', array('alt'=>__('Points up'), 'title'=>__('Points up'))),
                           '/admin/reports/points/'.$report_id.'/up',
                        array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'loading'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'loading'),
                              'escape'      => False ));
    echo '</td>';
    echo '<td>'.$lk.'</td>';

    echo '<td>'. $this->Html->link($this->Html->image('static/delete_icon.png', array('width'=>'14px', 'alt'=>__('Delete'), 'title'=>__('Delete'))),
                                  '/admin/reports/delete/'.$val['Report']['id'], array('onclick'=>"return confirm('".$msg."')", 'escape'=>False));
    echo '</td></tr>';
endforeach;

echo '</table>';

if ($data):
    $t  = $this->Html->div(null,$this->Paginator->prev('« '.__('Previous'),null,null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
    $t .= $this->Html->div(null,$this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
    $t .= $this->Html->div(null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
    echo  $this->Html->div(null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));
endif;

echo $this->Html->scriptStart();
?>
    $(document).ready(function() {
            $(".editable_textile").editable("/admin/reports/edit/", { 
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
