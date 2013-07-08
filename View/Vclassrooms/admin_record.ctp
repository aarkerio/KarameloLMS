<?php
#die(debug($data));
echo $this->Html->script(array('jquery-min', 'jquery-plugins/jquery.jeditable'));
$this->set('title_for_layout','Student record');

$this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
$this->Html->addCrumb(__('vClassrooms'), '/admin/vclassrooms/listing');
$this->Html->addCrumb($data['Vclassroom']['name'], '/admin/vclassrooms/members/'.$data['Vclassroom']['id']);  
echo $this->Html->getCrumbs(' > ');

$tp = 'tp('.$data['User']['id'].','.$data['Vclassroom']['id'].');'; # javascript function to get total stundent points below

echo '<div style="border: 1px dotted black;width:80%;padding:9px;margin:15px auto;">';
echo $this->Html->div('title_section', $data['User']['name']. '  &nbsp;&nbsp;<span style="font-size:8pt;">('.$data['User']['username'].')</span> '.$this->Html->image('avatars/'.$data['User']['avatar'], array('alt'=>$data['User']['username'], 'title'=> $data['User']['username'])));

echo $this->Html->div(Null, $this->Html->link($data['User']['email'], 'mailto:'.$data['User']['email']));

 # send message, send record to student && write participation
echo $this->Html->para(Null,
       $this->Js->link($this->Html->image('admin/compose_on.gif', array('alt'=>__('Compose message'), 'title'=>__('Compose message'))),
                           '/admin/messages/compose/'.$data['User']['id'],
	                    array('update'      => '#compose',
                              'evalScripts' => True,
                              'escape'      => False,
                              'before'      => $this->Gags->ajaxBefore('compose'),
                              'complete'    => $this->Gags->ajaxComplete('compose'))) . '&nbsp;&nbsp;'.
       $this->Js->link($this->Html->image('static/email.gif',array('alt'=>__('Send record to student'),'title'=>__('Send record to student'))), '/admin/vclassrooms/add/'.$data['User']['id'].'/'.$data['Vclassroom']['id'],
	                    array('update'     => '#compose',
                              'evalScripts' => True,
                              'escape'      => False,
                              'before'      => 'return confirm(\''.__('Are you sure you wanna send this information to student').'?\');'.$this->Gags->ajaxBefore('compose'),
                              'complete'    => $this->Gags->ajaxComplete('compose'))) . '&nbsp;&nbsp;'.
       $this->Js->link($this->Html->image('static/icon_write.png',array('width'=>'20px','alt'=>__('Write participation'),'title'=>__('Write participation'))),
                           '/admin/participations/add/'.$data['User']['id'].'/'.$data['Vclassroom']['id'],
	                    array('update'     => '#compose',
                              'evalScripts' => True,
                              'escape'      => False,
                              'before'      => $this->Gags->ajaxBefore('compose'),
                              'complete'    => $this->Gags->ajaxComplete('compose')))
                 );

 echo $this->Gags->imgLoad('loading'); 
 echo $this->Gags->ajaxDiv('compose').$this->Gags->divEnd('compose'); 
 $points = (int) 0; # total points used in the end of script
 
 # 1) Tests
 $test_points = (int) 0;
 echo '<h1>'. __('Tests solved').'</h1>';
  if ( isset($data['tests']) && count($data['tests']) > 0 ):
      $msg_test = __('Reset test deleting answers, this allow to this student answer the test again in the Virtual Classroom');
      foreach ($data['tests'] as $t):
          #die(debug( $t ));    
          $div_id = 'te'.$t['Test']['id'];
          echo '<div style="border:1px dotted gray;padding:4px;margin:2px;height:20px;">';

          if ($t['Test']['points'] === False):  # not answered yet
              echo $this->Html->div(Null, __('Not answered this test yet'), array('id'=>$div_id,'style'=>'width:220px;float:left;font-size:7pt;'));
              echo $this->Html->div(Null, $t['Test']['title'], array('style'=>'width:350px;float:right;'));
          else:
              echo $this->Html->div(Null, $t['Test']['points'].' '.__('points'),array('id'=>$div_id,'style'=>'width:180px;float:left;'));
              echo '<div style="width:450px;float:right;">';
              echo $this->Html->link($t['Test']['title'], '#'.$div_id, array('title'=>'View test', 'onclick'=>
	    "window.open('/admin/tests/see/".$data['User']['id'].'/'.$t['Test']['id'].'/'.$data['Vclassroom']['id']."','mywin','left=20,top=10,width=700,height=700,scrollbars=1,toolbar=0,resizable=1')")) . '&nbsp;&nbsp;';
              $img_test =  $this->Html->image('static/icon_reload.gif', array('alt'=>$msg_test, 'title'=>$msg_test));
              echo $this->Html->link($img_test, '/admin/tests/delactivity/'.$t['Test']['id'].'/'.$data['User']['id'].'/'.$data['Vclassroom']['id'], array('confirm'=>__('Are you sure to delete the answers?'), 'escape'=>False));
              echo '</div>';
          endif;
      echo '</div>';
      $test_points += (int) $t['Test']['points'];
    endforeach;
 else:
     echo $this->Html->para(Null, __('No tests found in this classroom'));
 endif;

 # 2) Webquests --> ResultWebquest
 $webquest_points = (int) 0;    # webquest points
 echo '<h1>'. __('Webquests solved').'</h1>';
 if ( count($data['webquests']) > 0 ):
   foreach ($data['webquests'] as $w):
     $webquest_points += $w['ResultWebquest']['points'];
     $div_id   = 'w'.$w['Webquest']['id'];
     echo '<div style="border:1px dotted gray;padding:4px;margin:2px;height:20px;">';
     echo $this->Html->div(null, $w['ResultWebquest']['points'] .' '.__('points'),  array('id'=>$div_id, 'style'=>'width:150px;float:left;'));
     echo '<div style="width:450px;float:right;">';
     echo $this->Html->link($w['Webquest']['title'], '#'.$div_id, array('title'=>__('View text'), 'onclick'=>
	    "window.open('/admin/webquests/see/".$data['User']['id']."/".$w['Webquest']['id']."','mywin','left=20,top=20,width=700,height=700,toolbar=0,resizable=1')")) . '&nbsp;&nbsp;';

      echo $this->Js->link($this->Html->image('static/adownmod.png', array('alt'=>__('Points down'), 'title'=>__('Points down'))),
                           '/admin/webquests/points/'.$w['ResultWebquest']['id'].'/down',
                        array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'loadingweb'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'loadingweb').$tp,
                              'escape'      => False ));
      echo $this->Js->link($this->Html->image('static/aupmod.png', array('alt'=>__('Points up'), 'title'=>__('Points up'))),
                           '/admin/webquests/points/'.$w['ResultWebquest']['id'].'/up',
                        array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'loadingweb'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'loadingweb').$tp, 
                              'after '      => 'tp('.$data['User']['id'].','.$data['Vclassroom']['id'].')',
                              'escape'      => False ));
      echo '</div>';  
    echo '</div>'; 
    endforeach;
   echo $this->Gags->imgLoad('loadingweb');
 else:
    echo $this->Html->para(null, __('No Webquests found in this classroom'));
 endif;
 
 # 3) wiki  participations points 
 $wiki_points = (int) 0; 
 echo '<h1>'. __('Participations on WikiPages').'</h1>';

 if ( count($data['wikis']) > 0 ):
   foreach ($data['wikis'] as $wk):
     echo $this->Html->div('wikidiv', $this->Html->link($wk['Wiki']['title'], '/wikis/view/'.$data['Owner'].'/'.$wk['Wiki']['slug'], array('target'=>'_blank')));

   if ( count($wk['Revision']) > 0):
	     foreach ($wk['Revision'] as $Rev):
                $div_id = 'wk'.$Rev['id'];
                echo '<div style="border:1px dotted gray;padding:4px;margin:2px;height:20px;">';
                $wiki_points += (int) $Rev['points'];
                echo $this->Html->div(null, $Rev['points'].' '.__('points'), array('id'=>$div_id,'style'=>'width:150px;float:left;'));

                echo '<div style="width:450px;float:right;">';    
                echo __('WikiEdition').': '.$this->Html->link($wk['Wiki']['title'],'/wikis/revision/'.$data['Owner'].'/'.$wk['Wiki']['slug'].'/'.$Rev['id'], 
                                                               array('target'=>'_blank','title'=>__('View Wiki'))).'  ';

                echo $this->Js->link($this->Html->image('static/adownmod.png', array('alt'=>__('Points down'), 'title'=>__('Points down'))),
                           '/admin/wikis/points/'.$Rev['id'].'/down',
                        array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'loadw'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'loadw').$tp, 
                              'escape'      => False ));
                echo $this->Js->link($this->Html->image('static/aupmod.png', array('alt'=>__('Points up'), 'title'=>__('Points up'))),
                           '/admin/wikis/points/'.$Rev['id'].'/up',
                        array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'loadw'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'loadw').$tp, 
                              'escape'      => False ));
                   echo '</div>'; # end arrows div
                echo '</div>';  # end wrapper div
              endforeach;
           else:
	       echo $this->Html->div(Null, __('Student has no participated in this WikiPage'));
           endif;
         endforeach;
       echo $this->Gags->imgLoad('loadw');
 else:
    echo  $this->Html->para(Null, __('No WikiPages found'));
 endif;

 
 # 4) Gap fillings points 
 $gf_points = (int) 0; 
 echo '<h1>'. __('Gap fillings resolved').'</h1>';

 if ( count($data['gaps']) > 0 ):
     foreach ($data['gaps'] as $gf):
         echo '<div style="border:1px dotted gray;padding:4px;margin:2px;height:20px;">';
         $gf_points += (int) $gf['Gap']['points'];
         echo $this->Html->div(null, $gf['Gap']['points'].' '.__('points'), array('style'=>'width:150px;float:left;'));

         echo '<div style="width:450px;float:right;">';    
         echo __('Gap filling').': ';
         echo $this->Html->link($gf['Gap']['title'], '#', array('title'=>__('View Gap filling'), 'onclick'=>"window.open('/admin/gafs/revision/'".$gf['Gap']['id']."','mywin','left=20,top=20,width=700,height=700,toolbar=0,resizable=1')")).'  ';
         echo '</div>'; # end arrows div
         echo '</div>';  # end wrapper div
     endforeach;
 else:
     echo  $this->Html->para(Null, __('No Gap fillings on this vclassroom'));
 endif;


# 5) Treasures. Model: Treasure (aka Scavenger hunts) 
 $treasure_points = (int) 0; # treasure points
 echo '<h1>'. __('Scavengers hunts').'</h1>';
 if ( count($data['treasures']) > 0 ):
  foreach ($data['treasures'] as $tr):
     $treasure_points += (int) $tr['ResultTreasure']['points'];
     $div_id   = 'tr'.$tr['Treasure']['id'];
     echo '<div style="border:1px dotted gray;padding:4px;margin:2px;height:20px;">';
     echo $this->Html->div(Null, $tr['ResultTreasure']['points'] .' '.__('points'),  array('id'=>$div_id, 'style'=>'width:150px;float:left;'));
     echo '<div style="width:450px;float:right;">';
     $url  = '/admin/treasures/answers/'.$data['User']['id'].'/'.$tr['Treasure']['id'];
     echo $this->Html->link($tr['Treasure']['title'], '#'.$div_id, array('title'=>__('View text'), 'onclick'=>"window.open('".$url."','mywin','left=20,top=20,width=700,height=700,toolbar=0,resizable=1')")) . '&nbsp;&nbsp;';

     # the points can change
     echo $this->Js->link($this->Html->image('static/adownmod.png', array('alt'=>__('Points down'), 'title'=>__('Points down'))),
                           '/admin/treasures/points/'.$tr['ResultTreasure']['id'].'/down',
                        array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'loadtre'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'loadtre').$tp, 
                              'escape'      => False ));
     echo $this->Js->link($this->Html->image('static/aupmod.png', array('alt'=>__('Points up'), 'title'=>__('Points up'))),
                           '/admin/treasures/points/'.$tr['ResultTreasure']['id'].'/up',
                        array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'loadtre'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'loadtre').$tp, 
                              'escape'      => False ));
     echo '</div>';
     echo '</div>';
     endforeach;
     echo $this->Gags->imgLoad('loadtre');
 else:
     echo $this->Html->para(Null, __('No Scavenger hunts found'));
 endif;

 # Replies on forums. Model: Topic  
 echo '<h1>'.__('Participations in forums').'</h1>';
 $reply_points = (int) 0;
 if ( count($data['replies']) > 0 ):
   foreach ($data['replies'] as $re):  
       $div_id = 'rep'.$re['Reply']['id'];
       echo '<div style="border:1px dotted gray;padding:4px;margin:2px;height:20px;">';
       echo $this->Html->div(Null,$re['Reply']['points'].' '.__('points'),  array('id'=>$div_id, 'style'=>'width:150px;float:left;'));
       echo '<div style="width:450px;float:right;">';
       echo $this->Html->link(__('See participation') .' '.$re['Reply']['created'], '#'.$div_id, array('title'=>__('See participation'), 'onclick'=>"window.open('/admin/topics/reply/".$re['Reply']['id']."','mywin','left=20,top=20,width=700,height=700,toolbar=0,resizable=1')")) . '&nbsp;&nbsp;';

      echo $this->Js->link($this->Html->image('static/adownmod.png', array('alt'=>__('Points down'), 'title'=>__('Points down'))),
                           '/admin/replies/points/'.$re['Reply']['id'].'/down',
                        array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'lorep'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'lorep').$tp, 
                              'escape'      => False ));

      echo $this->Js->link($this->Html->image('static/aupmod.png', array('alt'=>__('Points up'), 'title'=>__('Points up'))),
                           '/admin/replies/points/'.$re['Reply']['id'].'/up',
                       array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'lorep'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'lorep').$tp, 
                              'escape'      => False ));
         echo '</div>'; 
         echo '</div>';
         $reply_points += (int) $re['Reply']['points'];
     endforeach;
     echo $this->Gags->imgLoad('lorep');
 else:
     echo  $this->Html->para(Null, __('No reply found'));
 endif;
 
 # Participations, model:  Participation
 $participation_points = (int) 0;  # participation points
 echo '<h1>'.__('Participations').'</h1>'; 
 if ( count($data['participations']) > 0 ):
     foreach ($data['participations'] as $p):
         echo '<div style="border:1px dotted gray;padding:4px;margin:2px;height:20px;">';
         if ( $p['Participation']['checked'] == 0 ):
             $img = 'static/img_correct_gray.gif';
             $alt = __('Participation not evaluated yet');
             $lk  = $this->Html->link($this->Html->image($img, array('alt'=>$alt, 'title'=>$alt)),'/admin/participations/share/'.$p['Participation']['id'], array('escape'=>False));
         else:
             $img = 'static/img_correct.gif';
             $alt = __('Participation evaluated');
             $lk  = $this->Html->image($img, array('alt'=>$alt, 'title'=>$alt));
         endif;
         $div_id = 'pa'.$p['Participation']['id'];
         $participation_points += (int) $p['Participation']['points'];
  
         echo $this->Html->div(Null, $p['Participation']['points'].' '.__('points'), array('id'=>$div_id,'style'=>'width:90px;float:left;'));
echo $this->Html->div(Null,$lk,  array('style'=>'width:90px;float:left;'));

         echo '<div style="width:450px;float:right;" title="'.$p['Participation']['points'].'">';    
         echo __('Participation').': '. $this->Html->link($p['Participation']['title'], '#', array('title'=>__('View text'), 
                 'onclick'=>"window.open('/admin/participations/show/".$p['Participation']['id']."','mywin','left=20,top=20,width=700,height=700,toolbar=0,resizable=1')")).'  ';

         echo $this->Js->link($this->Html->image('static/adownmod.png', array('alt'=>__('Points down'), 'title'=>__('Points down'))),
                           '/admin/participations/points/'.$p['Participation']['id'].'/down',
                        array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'loadingpa'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'loadingpa').$tp, 
                              'escape'      => False ));
         echo $this->Js->link($this->Html->image('static/aupmod.png', array('alt'=>__('Points up'), 'title'=>__('Points up'))),
                           '/admin/participations/points/'.$p['Participation']['id'].'/up',
	                    array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'loadingpa'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'loadingpa').$tp,
                              'escape'      => False ));
         echo '</div>';
         echo '</div>';
     endforeach;     
     echo $this->Gags->imgLoad('loadingpa');
 else:
     echo  $this->Html->para(null, __('No participation found'));
 endif;

 # Reports, model:  Report
 $report_points = (int) 0;  # report points
 echo '<h1>'.__('Reports').'</h1>'; 
 if ( count($data['reports']) > 0 ):
   $counter = (int) 0;
   echo '<table class="ajax_table">';
   foreach ($data['reports'] as $r):
       $counter++;
       if ( $r['Report']['checked'] == 0 ):
           $img = 'static/img_correct_gray.gif';
           $alt = __('Report not evaluated yet');
           $lk  = $this->Html->link($this->Html->image($img, array('alt'=>$alt, 'title'=>$alt)),'/admin/reports/share/'.$r['Report']['id'], array('escape'=>False));
       else:
           $img = 'static/img_correct.gif';
           $alt = __('Report evaluated');
           $lk  = $this->Html->image($img, array('alt'=>$alt, 'title'=>$alt));
       endif;
       $download = __('Download') . ': '.$r['Report']['filename'].'. Submitted: '. $r['Report']['created'];
       $link = strlen($r['Report']['description']) > 1 ? $r['Report']['description'] : __('Report');
       if ( $counter%2 ):
           $class = 'class="altRow" onmouseover="this.className=&#039;highlight&#039;" onmouseout="this.className=&#039;altRow&#039;"';
       else:
           $class = 'class="evenRow" onmouseover="this.className=&#039;highlight&#039;" onmouseout="this.className=&#039;evenRow&#039;"';
       endif;

       $div_id = 're'.$r['Report']['id'];
      
       $report_points += (int) $r['Report']['points'];
       echo '<tr '.$class.'><td>'.$this->Html->div(Null, $r['Report']['points'].' '.__('points'), 
                                                        array('id'=>$div_id,'style'=>'width:90px;')).'</td>';

       echo '<td>'.$this->Html->link($this->Html->image('static/button_download.gif', array('alt'=>$download, 'title'=>$download)), 
                              '/admin/reports/download/'.$r['Report']['id'], array('escape'=>False)).'</td>';
       echo '<td>'.$lk.'</td>';
       echo '<td class="editable_report" id="report_'.$r['Report']['id'].'">'.Sanitize::html($r['Report']['description']).'</td>';
       
       echo '<td>'; 
       echo $this->Js->link($this->Html->image('static/adownmod.png', array('alt'=>__('Points down'), 'title'=>__('Points down'))) ,
                           '/admin/reports/points/'.$r['Report']['id'].'/down',
                        array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'loadingrep'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'loadingrep').$tp, 
                              'escape'      => False ));
       echo $this->Js->link($this->Html->image('static/aupmod.png', array('alt'=>__('Points up'), 'title'=>__('Points up'))),
                           '/admin/reports/points/'.$r['Report']['id'].'/up',
                        array('update'      => '#'.$div_id,
                              'evalScripts' => True,
                              'before'      => $this->Gags->ajaxBefore($div_id, 'loadingrep'),
                              'complete'    => $this->Gags->ajaxComplete($div_id, 'loadingrep').$tp,
                              'escape'      => False ));
       echo '</td></tr>';
    endforeach;
    echo '</table>';
    echo $this->Gags->imgLoad('loadingrep');
 else:
     echo  $this->Html->para(Null, __('No reports found'));
 endif;

 # Scorm, model:Scorm,   Plugin:True
 $scorm_points = (int) 0;  # scorm points
 echo '<h1>'.__('Scorms').'</h1>'; 
 if ( count($data['scorms']) > 0 ):
     foreach ($data['scorms'] as $r):
         #die(debug($r));
         echo '<div style="border:1px dotted gray;padding:4px;margin:2px;height:20px;">';
         $div_id = 'sco'.$r['id'];
         $report_points += (int) $r['points'];
         echo $this->Html->div(Null, $r['points'].' '.__('points'),  array('id'=>$div_id,'style'=>'width:150px;float:left;'));
         echo '<div style="width:450px;float:right;">'. __('Scorm').': '. $r['name'] .'   </div></div>';
     endforeach;
 else:
     echo  $this->Html->para(Null, __('No scorms found'));
 endif;

 echo  $this->Html->div(Null, __('Test') .' ' .__('points') .': '. $test_points);
 echo  $this->Html->div(Null, __('Scavengers hunts') .' ' .__('points') .': '. $treasure_points);
 echo  $this->Html->div(Null, __('WikiPages') .' ' .__('points') .': '. $wiki_points);
 echo  $this->Html->div(Null, __('Gap fillings') .' ' .__('points') .': '. $gf_points);
 echo  $this->Html->div(Null, 'Webquests ' .__('points') .': '. $webquest_points);
 echo  $this->Html->div(Null, __('Replies'). ' ' .__('points') .': '. $reply_points);
 echo  $this->Html->div(Null, __('Participations') .' '. __('points') .': '. $participation_points, array('id'=>'parpoints'));
 echo  $this->Html->div(Null, __('Reports') .' '. __('points') .': '. $report_points, array('id'=>'reppoints'));
 echo  $this->Html->div(Null, 'SCORMs' .' '. __('points') .': '. $scorm_points, array('id'=>'scormpoints'));
 $points = ($test_points + $treasure_points + $gf_points + $webquest_points + $reply_points + $wiki_points + $participation_points + $report_points);
 
 echo  $this->Gags->ajaxDiv('totalpoints') .'<b>'.__('Total points').': ' . $points .'</b>'. $this->Gags->divEnd('totalpoints');
 echo '</div>';

echo $this->Html->scriptStart();
?>
    $(document).ready(function() {
            $(".editable_report").editable("/admin/reports/edit/", { 
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