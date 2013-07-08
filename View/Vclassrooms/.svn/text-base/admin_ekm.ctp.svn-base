<?php
#die(debug($data));
echo $this->Html->div('title_section', $data['Vclassroom']['name']);
$i = (int) 0;
$green = '<span style="font-size:8pt;color:green;font-weigth:bold;">';
$red   = '<span style="font-size:8pt;color:red;font-weigth:bold;">';
?>
<table style="width:100%;border-collapse:collapse;">
<?php
# Test

foreach($data['TestVclassroom'] as $t):
         $i++;
         $bgcolor = ($i % 2 === 0) ? '#fff' : '#e1e1e1';
         $tdiv = (string) 'tdiv'.$t['id'];
         echo '<tr style="background-color:'.$bgcolor.'"><td>';
         echo $this->Form->create('Test', array('action'=>'unlink2class'));
         echo $this->Form->hidden('TestVclassroom.id', array('value'=>$t['id']));
         echo $this->Form->hidden('TestVclassroom.vclassroom_id', array('value'=>$t['vclassroom_id']));
         echo $this->Form->hidden('TestVclassroom.popup', array('value'=> '1'));
         echo $this->Form->end(__('Unlink')); 
         echo '</td>';
         echo '<td>'.__('Test').': '.$t['Test']['title'].'  '.$green.$t['sdate'].'</span> &nbsp;'.$red.$t['fdate'].'</span></td><td>';
         echo $this->Form->create();
         echo $this->Form->hidden('TestVclassroom.id', array('value'=>$t['id']));
         echo $this->Js->submit(__('Edit'), array('url'         => '/admin/tests/ekandie',
                                                        'update'      => '#'.$tdiv,
                                                        'evalScripts' => True,
                                                        'before'      => $this->Gags->ajaxBefore($tdiv),
                                                        'complete'    => $this->Gags->ajaxComplete($tdiv)
                           ));
         echo '</form></td></tr>';
         echo '<tr><td colspan="3">'.$this->Gags->ajaxDiv($tdiv).$this->Gags->divEnd($tdiv) .'</td></tr>';
endforeach; 


# Gaps

foreach($data['GapVclassroom'] as $g):
          $i++;
         $bgcolor = ($i % 2 === 0) ? '#fff' : '#e1e1e1';
         $tdiv = (string) 'gapdiv'. $g['id'];
         echo '<tr style="background-color:'.$bgcolor.'"><td>';
         echo $this->Form->create('Gap', array('action'=>'unlink2class'));
         echo $this->Form->hidden('GapVclassroom.id', array('value'=> $g['id']));
         echo $this->Form->hidden('GapVclassroom.popup', array('value'=> '1'));
         echo $this->Form->hidden('GapVclassroom.vclassroom_id', array('value'=> $g['vclassroom_id']));
         echo $this->Form->end(__('Unlink')); 
         echo '</td>';
         echo '<td>'. __('Gap filling').': ' . $g['Gap']['title'] .'  '.$green.$g['sdate'].'</span> &nbsp;'.$red.$g['fdate'].'</span></td><td>';
         echo $this->Form->create();
         echo $this->Form->hidden('GapVclassroom.id', array('value'=> $g['id']));
         echo $this->Js->submit(__('Edit'), array('url'         => '/admin/gaps/ekandie',
                                                        'update'      => '#'.$tdiv,
                                                        'evalScripts' => True,
                                                        'before'      => $this->Gags->ajaxBefore($tdiv),
                                                        'complete'    => $this->Gags->ajaxComplete($tdiv)
                           ));
         echo '</form></td></tr>';
         echo '<tr><td colspan="3">'.$this->Gags->ajaxDiv($tdiv).$this->Gags->divEnd($tdiv) .'</td></tr>';
endforeach; 

# Treasure
foreach($data['TreasureVclassroom'] as $tr):
         $i++;
         $bgcolor = ($i % 2 === 0) ? '#fff' : '#e1e1e1';
         $tdiv = (string) 'trediv'. $tr['id'];
         echo '<tr style="background-color:'.$bgcolor.'"><td>';
         echo $this->Form->create('Treasure', array('action'=>'unlink2class'));
         echo $this->Form->hidden('TreasureVclassroom.id', array('value'=> $tr['id']));
         echo $this->Form->hidden('TreasureVclassroom.popup', array('value'=> '1'));
         echo $this->Form->hidden('TreasureVclassroom.vclassroom_id', array('value'=> $tr['vclassroom_id']));
         echo $this->Form->end(__('Unlink')); 
         echo '</td>';
         echo '<td>'.__('Scavenger Hunt').': '.$tr['Treasure']['title'].'  '.$green.$tr['sdate'].'</span> &nbsp;'.$red.$tr['fdate'].'</span></td><td>';
         echo $this->Form->create();
         echo $this->Form->hidden('TreasureVclassroom.id', array('value'=> $tr['id']));
         echo $this->Js->submit(__('Edit'), array('url'         => '/admin/treasures/ekandie', 
                                                        'update'      => '#'.$tdiv,
                                                        'evalScripts' => True,
                                                        'before'      => $this->Gags->ajaxBefore($tdiv),
                                                        'complete'    => $this->Gags->ajaxComplete($tdiv)
                           ));
         echo '</form></td></tr>';
         echo '<tr><td colspan="3">'.$this->Gags->ajaxDiv($tdiv).$this->Gags->divEnd($tdiv) .'</td></tr>';
endforeach; 

# Webquest
foreach($data['VclassroomWebquest'] as $w):
         $i++;
         $bgcolor = ($i % 2 === 0) ? '#fff' : '#e1e1e1';
         $tdiv = (string) 'webdiv'. $w['id'];
         echo '<tr style="background-color:'.$bgcolor.'"><td>';
         echo $this->Form->create('Webquest', array('action'=>'unlink2class'));
         echo $this->Form->hidden('VclassroomWebquest.id', array('value'=> $w['id']));
         echo $this->Form->hidden('VclassroomWebquest.popup', array('value'=> '1'));
         echo $this->Form->hidden('VclassroomWebquest.vclassroom_id', array('value'=> $w['vclassroom_id']));
         echo $this->Form->end(__('Unlink')); 
         echo '</td>';
         echo '<td>Webquest: ' . $w['Webquest']['title'].'  '.$green.$w['sdate'].'</span> &nbsp;'.$red.$w['fdate'].'</span></td><td>';
         echo $this->Form->create();
         echo $this->Form->hidden('VclassroomWebquest.id', array('value'=> $w['id']));
         echo $this->Js->submit(__('Edit'), array('url'         => '/admin/webquests/ekandie', 
                                                        'update'      => '#'.$tdiv,
                                                        'evalScripts' => True,
                                                        'before'      => $this->Gags->ajaxBefore($tdiv),
                                                        'complete'    => $this->Gags->ajaxComplete($tdiv)
                           ));
         echo '</form></td></tr>';
         echo '<tr><td colspan="3">'.$this->Gags->ajaxDiv($tdiv).$this->Gags->divEnd($tdiv) .'</td></tr>';
endforeach; 

# SCORM
foreach($data['ScormVclassroom'] as $s):
     $i++;
         $bgcolor = ($i % 2 === 0) ? '#fff' : '#e1e1e1';
         $tdiv = (string) 'webdiv'. $s['id'];
         echo '<tr style="background-color:'.$bgcolor.'"><td>';
         echo $this->Form->create('Scorm', array('url'=>'/admin/scorm/scorms/unlink2class'));
         echo $this->Form->hidden('ScormVclassroom.id', array('value'=> $s['id']));
         echo $this->Form->hidden('ScormVclassroom.popup', array('value'=> '1'));
         echo $this->Form->hidden('ScormVclassroom.vclassroom_id', array('value'=> $s['vclassroom_id']));
         echo $this->Form->end(__('Unlink')); 
         echo '</td>';
         echo '<td>Scorm: '.$s['Scorm']['name'].'  '.$green.$s['sdate'].'</span> &nbsp;'.$red.$s['fdate'].'</span></td><td>';
         echo $this->Form->create();
         echo $this->Form->hidden('ScormVclassroom.id', array('value'=> $s['id']));
         echo $this->Js->submit(__('Edit'), array('url'         => '/admin/scorm/scorms/ekandie',
                                                        'update'      => '#'.$tdiv,
                                                        'evalScripts' => True,
                                                        'before'      => $this->Gags->ajaxBefore($tdiv),
                                                        'complete'    => $this->Gags->ajaxComplete($tdiv)
                           ));
         echo '</form></td></tr>';
         echo '<tr><td colspan="3">'.$this->Gags->ajaxDiv($tdiv).$this->Gags->divEnd($tdiv) .'</td></tr>';
endforeach; 

echo '</table>';

if ( $i == 0 ):
    echo $this->Html->div('title_section', __('You do not have any Kandie in this vClassroom'));
endif;

echo $this->Js->writeBuffer();

# ? > EOF