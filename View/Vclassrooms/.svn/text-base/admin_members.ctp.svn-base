<?php
#die(debug($data));
$vclassroom_id = (int) $data['Vclassroom']['id'];

$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb('vClassrooms', '/admin/vclassrooms/listing');
echo $this->Html->getCrumbs(' > ');

echo $this->Html->div('info',  'eCourse: '.$data['Ecourse']['title'] .'. '.__('Max points') .': '. $data['Ecourse']['points']);
echo $this->Gags->imgLoad();
#die( debug($data));
echo '<div style="padding:4px;margin:10px auto 10px;width:900px;text-align:center;">';
echo $this->Js->link($this->Html->image('static/icon_student.png', array('width'=>17,'alt'=>__('Enroll student to this classroom'), 'title'=>__('Enroll student to this classroom'))),
     '/admin/vclassrooms/items/'.$vclassroom_id,
                                 array('update'      => '#qn',
                                       'evalScripts' => True,
                                       'escape'      => False,
                                       'before'      => $this->Gags->ajaxBefore('qn'),
                                       'complete'    => $this->Gags->ajaxComplete('qn'))) .'&nbsp;&nbsp;';

$link ="javascript:window.open('/admin/vclassrooms/dide/".$vclassroom_id."', '_blank', 'toolbar=no, scrollbars=yes,width=800,height=500')"; 

echo $this->Html->link(
                       $this->Html->image('admin/icon_jigsaw.png', array('alt'=>__('Link Kandie to this classroom'), 'title'=>__('Link Kandie to this classroom'), 'style'=>'margin-right:12px')), '#', array('onclick'=>$link, 'escape'=>False));

# Show participations
echo $this->Html->link($this->Html->image('static/icon_write.png', array('width'=>'22px', 'alt'=>__('Participations in vClassroom'), 'title'=>__('Participations in vClassroom'))), '/admin/participations/listing/'.$vclassroom_id, array('escape'=>False)).'&nbsp;&nbsp;';

# Show reports
echo $this->Html->link($this->Html->image('admin/icon_report.png', array('alt'=>__('Show last reports'), 'title'=>__('Show last reports'))), '/admin/reports/listing/'.$vclassroom_id, array('escape'=>False)).'&nbsp;&nbsp;';

#Chat options
$link ="javascript:window.open('/admin/chats/record/".$vclassroom_id."', '_blank', 'toolbar=no, scrollbars=yes,width=800,height=500')"; 
echo $this->Html->link($this->Html->image('static/icon_log.png', array('width'=>20,'alt'=>__('Chat options'), 'title'=>__('Chat options'))), '#', array('onclick'=>$link, 'escape'=>False)).'&nbsp;&nbsp;';

# Export PDF
echo $this->Html->link(
        $this->Html->image('static/gnome-pdf.gif', array('alt'=>__('Export report'), 'title'=>__('Export report'))), '/admin/vclassrooms/export/'.$vclassroom_id, array('escape'=>False)).'&nbsp;&nbsp;';

# Export to LibreOffice Calc (yea right)
echo $this->Html->link(
                  $this->Html->image('static/spreadsheet_icon.png', array('alt'=>__('Export Spreadsheet'), 'title'=>__('Export Spreadsheet'))), '/admin/vclassrooms/spexport/'.$vclassroom_id, array('escape'=>False)).'&nbsp;&nbsp;';

# See Vclassroom
echo $this->Html->link($this->Html->image('static/icon_blackboard.jpg', array('alt'=>__('See vClassroom as your students do'), 'title'=>__('See vClassroom as your students do'))), '/vclassrooms/show/'.$data['owner'].'/'.$vclassroom_id, array('target'=>'_blank', 'escape'=>False)).'&nbsp;&nbsp;';

# Show tests
echo $this->Html->link($this->Html->image('admin/tests.png', array('width'=>'24px', 'alt'=>__('Show last Quizz Tests'), 'title'=>__('Show last Quizz Tests'))), 
                       '/admin/tests/record/'.$vclassroom_id, array('escape'=>False)).'&nbsp;&nbsp;';

# more 2 or more students to send a vClassroom message ()
if ( count($data) > 2 ):
 echo $this->Js->link($this->Html->image('admin/message_board.gif', array('width'=>21,'alt'=>__('Compose message to group'), 'title'=>__('Compose message to group'))),
     '/admin/messages/allclass/'.$vclassroom_id,
                                            array('update'      => '#qn',
                                                  'evalScripts' => True,
                                                  'escape'      => False,
                                                  'before'      => $this->Gags->ajaxBefore('qn'),
                                                  'complete'    => $this->Gags->ajaxComplete('qn', 'loading', 'fadeOut', 'slideDown')));
 echo '&nbsp;&nbsp;';
endif;

if ( count($data) > 2 ):
 echo $this->Js->link($this->Html->image('admin/icon_save.png', array('width'=>21,'alt'=>__('Create permanent group of students'), 'title'=>__('Create permanent group of students'))),
     '/admin/permanent_classes/new/'.$vclassroom_id,
                                            array('update'      => '#qn',
                                                  'evalScripts' => True,
                                                  'escape'      => False,
                                                  'before'      => $this->Gags->ajaxBefore('qn'),
                                                  'complete'    => $this->Gags->ajaxComplete('qn', 'loading', 'fadeOut', 'slideDown')));
endif;
echo '&nbsp;&nbsp;';

echo $this->Js->link($this->Html->image('admin/icon_import.png', array('width'=>21,'alt'=>__('Import group of students'), 'title'=>__('Import group of students'))),
     '/admin/permanent_classes/get/'.$vclassroom_id,
                                            array('update'      => '#qn',
                                                  'evalScripts' => True,
                                                  'escape'      => False,
                                                  'before'      => $this->Gags->ajaxBefore('qn'),
                                                  'complete'    => $this->Gags->ajaxComplete('qn', 'loading', 'fadeOut', 'slideDown')));
echo '&nbsp;&nbsp;';
echo '</div>';
echo $this->Gags->imgLoad('loading3');
echo $this->Gags->ajaxDiv('qn', array('style'=>'padding:0')) . $this->Gags->divEnd('qn');


echo $this->Html->div('title_section', __('Students belonging to'). ': ' . $data['Vclassroom']['name']);

if ( count($data['U']) == 0 ):
    echo $this->Html->div('divblock', __('No students in this vClassroom yet'));
endif;
 
echo '<table class="tbadmin">';
# die(print_r($data));
 
$ays = (string) __('Are you sure?'); 
$th  = array (__('Name'), 'Username', 'Email', __('Send message'), __('Unlink'), __('Points'), __('Full Record'));

echo $this->Html->tableHeaders($th, array('style'=>'font-weight:bold;font-size:15pt;')); 
foreach ($data['U'] as $v):
    $alt = $v['User']['username'] .' '.__('Last login').':'.  $v['User']['last_visit'];
    $tr = array (
	  $v['User']['name'],
	  $this->Html->image('avatars/'.$v['User']['avatar'], array('alt'=>$alt, 'title'=>$alt, 'width'=>30)),
	  $this->Html->link($v['User']['email'], 'mailto:'.$v['User']['email']),
      $this->Html->link($this->Html->image('admin/compose_on.gif', array('alt'=>__('Compose to') .' '.$v['User']['username'], 'title'=>__('Compose to') .' '.$v['User']['username'])), '/admin/messages/add/'.$v['User']['username'], array('escape'=>False)),
		 $this->Html->link($this->Html->image('static/unlink.png', array('alt'=>__('Unlink'), 'title'=>__('Unlink'))),
               '/admin/vclassrooms/unlink/'.$v['User']['id'].'/'.$vclassroom_id, array('onclick'=>"return confirm('$ays')",'escape'=>False)),
                 $v['User']['points'],
                 $this->Html->link($this->Html->image('static/historial-icon.png', array('alt'=>__('Student record'), 'title'=>__('Student record'))), 
                             '/admin/vclassrooms/record/'.$v['User']['id'].'/'.$vclassroom_id, array('escape'=>False))
	         );
          echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;

echo '</table>';

echo $this->Html->scriptStart(); 

?>
function hideDiv()
{ 
  var div  = document.getElementById("qn");
  div.style.display = 'none';
  return true;
  }

<?php
echo $this->Html->scriptEnd(); 
# ? >
