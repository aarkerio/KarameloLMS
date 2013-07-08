<?php
/**
 *  Chipotle Software(c) 2006-2012
 *  Virtual classroom main view 
 *  @license GPLv3
 */
#die(debug($data));
$this->set('title_for_layout',  $data['Vclassroom']['name']);

echo $this->Html->div(Null, Null, array('style'=>'border:1px dotted gray;margin:0 auto 20px auto;padding:5px;width:920px;'));
 
echo $this->Html->div(Null, $this->Html->image('static/vclassroom-02.jpg', array('alt'=>'vClassroom', 'title'=>'vClassroom', 'id'=>'vcimg')));
echo $this->element('window_help', array('blog'=>True));
echo  '<h1>' . $data['Vclassroom']['name'] . '</h1>';

# Superuser sudo hack (Show to owner only even if not public yet)
if ( !$belongs and $this->Session->read('Auth.User.sudo')):
    $belongs = True;
endif;

#check if student is logged in and belongs to this vClassroom
if ( $belongs === True ):
  echo $this->Html->div(Null,  __('Welcome') . '!<b> '. $this->Session->read('Auth.User.username') .'</b>');
  # Prepare ecourse activities
  #die(debug($data['activities']));
  $acts   = array();
  $i      = (int) 0;
  $points = (int) 0;
  foreach ($data['activities'] as $a):
       $i++;
       $points += $a['Activity']['points'];
       $acts[$a['Activity']['id']] = __('Activity') . ' '.$i .' '.$a['Activity']['title']; 
  endforeach;
  
  echo $this->Html->div(Null, __('This eCourse contains').' <b>'.$i . '</b> '.__('Activities') . ' por un total de <b>'.$points .'</b> ' .__('points'));
  if ($points > 0):
      $percentage = (($student_points / $points) * 100); # student
  else:
      $percentage=0;
  endif;
  $advance = number_format($percentage, 0);
  echo $this->Html->div(Null,  __('Your current points') . ': '. $student_points .'. '. __('Advance') .': <b>'.$advance .'%.</b>');
  if (  $percentage >=  $data['Ecourse']['percentage'] and  $data['Vclassroom']['diploma'] == 1):
     $link  =  '/vclassrooms/diploma/'.$data['Vclassroom']['id'];
     $style = array('style'=>'width:500px;padding:9px;margin:11px auto;border:1px dotted orange;text-align:center;');
     $img   = $this->Html->link($this->Html->image('static/finish.jpg', array('alt'=>'Great!', 'title'=>'Great!')), $link, array('escape'=>False));
     echo $this->Html->div(Null, $img .'<br />'.__('You are approved this course') .'<br />'.$this->Html->link(__('Get your diploma'),$link), $style);
  endif;
  echo  $this->Html->div(Null);
  echo  '<b>'.__('eCourse starts on'). '</b> :' . $data['Vclassroom']['sdate'] .' <br />';
  echo  '<b>'.__('eCourse ends on'). '</b> :' . $data['Vclassroom']['fdate'] .' <br />';
  echo  '<b>'.__('Minimum points percentage required to aprobe course'). '</b>: ' . $data['Ecourse']['percentage'] .'% <br />';
  echo  '<b>'.__('Subject').'</b> : ' . $data['Ecourse']['title'];
  echo '</div>';
  echo $this->Html->para(Null, '<b>'.__('eCourse description').'</b>'. $this->Js->link($this->Html->image('static/arrow_down.png',array('alt'=>__('Course description'), 'title'=>__('Course description'))),'/vclassrooms/description/'.$data['Vclassroom']['ecourse_id'], 
       array('update'      => '#qn',
             'evalScripts' => True,
             'before'      => $this->Gags->ajaxBefore('qn', 'loading3'),
             'complete'    => $this->Gags->ajaxComplete('qn', 'loading3'),
             'escape'      => False
             )));
  $points    = (int) 0;
  
  echo $this->Gags->imgLoad('loading3');
  echo $this->Gags->ajaxDiv('qn', array('style'=>'padding:3px')).$this->Gags->divEnd('qn');
  
  echo $this->Html->script('ckeditor/ckeditor');
  #clock
  echo $this->element('clock');
  
  # hello teacher!
  if ( $blogger['User']['id'] == $this->Session->read('Auth.User.id') && $data['Vclassroom']['message']):
      echo $this->element('helloteacher', array('vclassroom_id'=>$data['Vclassroom']['id'], 'code'=>$data['Vclassroom']['secret'], 
'username'=> $blogger['User']['username']));
  endif;
    
  # check if teacher has set a Google Calendar to this vClass
 if ( strlen($data['Vclassroom']['gcalendar_id']) > 10 ):
     echo $this->element('google_calendar', array('gcalendar_id'=>$data['Vclassroom']['gcalendar_id']));  
 endif;
  
 echo $this->Html->div('titentry', $this->Html->image('static/activities_icon.png', array('width'=>'30px', 'alt'=>__('Activities'), 'title'=>__('Activities'))).' '.__('Activities'));

 if ( count($acts) > 0 ): # are activities exist
     $before   =  $this->Gags->ajaxBefore('activ', 'loading4');
     $complete =  $this->Gags->ajaxComplete('activ', 'loading4', 'fadeOut', 'slideDown');

     echo $this->Form->input('Activity.id', array('options'=>$acts, 'label'=>False, 'empty' =>__('Activities')));
     echo $this->Js->get('#ActivityId')->event('change',$this->Js->request('/ecourses/activity/',
                 array(
                       'update'         =>'#activ',
                       'before'         => $before,
                       'complete'       => $complete,
                       'dataExpression' => True,
                       'evalScripts'    => True,
                       'method'         => 'post',
                       'data'           => $this->Js->serializeForm(array('isForm' => True, 'inline' => True))
                       )));
  
     echo $this->Gags->ajaxDiv('activ').$this->Gags->divEnd('activ');
     echo $this->Gags->imgLoad('loading4');
  else:
      echo $this->Html->div(Null, __('No activities yet'));
  endif;
  echo $this->Html->div(Null, ' ', array('style'=>'clear:both;margin:24px 3px 15px 0;')); # just clear zone
  #end activities
  # Three buttons panel
  echo $this->Html->div(Null, Null, array('style'=>'margin:25px auto;padding:5px 5px 5px 200px;text-align:left;overflow:auto;width:600px;'));
  # if chat is actived show the link to popup window
  if ( $data['Vclassroom']['chat'] == 1 ):
     echo $this->Html->div(Null, Null, array('style'=>'padding:4px;margin:3px;width:100px;text-align:center;float:left;border:1px solid #FFC826;'));
     # popup window for chat
     $t="javascript:window.open('/vclassrooms/chat/".$blogger['User']['username'].'/'.$data['Vclassroom']['id']."', '_blank', 'toolbar=no, resizable=yes, scrollbars=yes,width=700,height=800')"; 
      echo $this->Html->link(
         $this->Html->image('static/chat-icon.jpg', array('alt'=>'Chatroom','title'=>'Chatroom','style'=>'margin-right:12px')), '#', 
         array('onclick'=>$t, 'escape'=>False));    
     echo '</div>';
  endif;
  
  # participation using Ajax
  echo $this->Html->div(Null, Null, array('style'=>'padding:4px;margin:3px;width:100px;text-align:center;float:left;border:1px solid #FFC826;'));
  echo $this->Form->create();   
  echo $this->Form->hidden('Participation.vclassroom_id', array('value'=>$data['Vclassroom']['id']));
  echo $this->Form->hidden('Participation.blogger_username', array('value'=>$blogger['User']['username']));
  echo $this->Form->hidden('Participation.blogger_id', array('value'=>$blogger['User']['id']));  # this to return after save participation
  echo $this->Js->submit('/img/static/icon_write.png', 
                                   array('url'         => '/vclassrooms/participation/', 
                                         'update'      => '#setform',
                                         'title'       => __('Write participation'),
                                         'evalScripts' => True,
                                         'before'      => $this->Gags->ajaxBefore('setform', 'loadform'),
                                         'complete'    => $this->Gags->ajaxComplete('setform', 'loadform')));
  echo '</form>'; 
  echo '</div>';

  # Show upload form using ajax
  echo $this->Html->div(Null, Null, array('style'=>'padding:4px;margin:3px;width:100px;text-align:center;float:left;border:1px solid #FFC826;'));
  echo $this->Form->create();     
  echo $this->Form->hidden('Upload.vclassroom_id', array('value'=>$data['Vclassroom']['id']));
  echo $this->Form->hidden('Upload.blogger_id', array('value'=>$blogger['User']['id']));  # this to return
  echo $this->Form->hidden('Upload.blogger_username', array('value'=>$blogger['User']['username']));
  echo $this->Js->submit('/img/static/icon_file.png', array(
                                         'url'         => '/vclassrooms/upload/', 
                                         'update'      => '#setform',
                                         'title'       => __('Upload file'),
                                         'evalScripts' => True,
                                         'before'      => $this->Gags->ajaxBefore('setform', 'loadform'),
                                         'complete'    => $this->Gags->ajaxComplete('setform', 'loadform')));
  echo '</form>'; 
  # empty ajax div
  echo '</div>';
  echo '</div>';
  echo $this->Gags->imgLoad('loadform');
  echo $this->Gags->ajaxDiv('setform') . $this->Gags->divEnd('setform');  
  # Kandie image
  echo $this->Html->div(Null, $this->Html->image('static/kandiesinclass.jpg', array('alt'=>'Karamelo network didactic elements', 'title'=>'Karamelo network didactic elements')));

  #End three buttons panel
  echo '<div style="width:100%;"><!-- container -->'; 
  echo '<div style="width:400px;position:relative;float:left;">'; 
  #  Show the Forums created to this vclass
  if ( isset($data['Forum']) && count($data['Forum']) > 0):
        echo $this->Html->div('titentry', $this->Html->image('static/forums.png', array('alt'=>'Forums', 'title'=>'Forums', 'width'=>'22')) .' '.__('Forums'));
        foreach($data['Forum'] as $f):
             echo $this->Html->para(Null,$this->Html->link($f['title'],'/forums/display/'.$blogger['User']['username'].'/'.$f['id'].'/'.$data['Vclassroom']['id']));
        endforeach;
  endif;
  # Wikipages
  if ( isset($data['Wiki']) && count($data['Wiki']) > 0):
       echo $this->Html->div('titentry', $this->Html->image('wikis.png', array('alt'=>'Wikis', 'title'=>'Wikis', 'width'=>'22')) .' '.'Wiki Pages');

       foreach($data['Wiki'] as $w):
                echo $this->Html->para(Null, $this->Html->link($w['title'], '/wikis/view/'.$blogger['User']['username'].'/'.$w['slug']));
       endforeach;
  endif;
  # Tests 
  if ( isset($data['Test']) && count($data['Test']) > 0):
       echo $this->Html->div('titentry', $this->Html->image('admin/tests.png', array('alt'=>'Tests', 'title'=>'Tests', 'width'=>'22')).' '.__('Quizz Tests'));
       foreach($data['Test'] as $t):
                echo $this->Html->para(Null, $this->Html->link($t['title'], 
                                 '/tests/view/'.$blogger['User']['username'].'/'.$t['id'].'/'.$data['Vclassroom']['id']));
       endforeach;
  endif;  
  # Gaps fillings
  if ( isset($data['Gap']) && count($data['Gap']) > 0):
       echo $this->Html->div('titentry', $this->Html->image('static/gap_filling_icon.png', array('alt'=>'Clozes', 'width'=>'22')).' '.__('Gap fillings'));
       foreach($data['Gap'] as $gf):
                echo $this->Html->para(Null, $this->Html->link($gf['title'],
                                    '/gaps/view/'.$blogger['User']['username'].'/'.$gf['id'].'/'.$data['Vclassroom']['id']));
       endforeach;
  endif;
  # Webquests
  if ( isset($data['Webquest']) && count($data['Webquest']) > 0):
       echo $this->Html->div('titentry', $this->Html->image('webquests.png', array('alt'=>'Webquests', 'width'=>'22')) .' '.'Webquests');
       foreach($data['Webquest'] as $wq):
         echo $this->Html->para(Null, $this->Html->link($wq['title'], '/webquests/view/'.$blogger['User']['username'].'/'.$wq['id'].'/'.$data['Vclassroom']['id']));
       endforeach;
  endif;
  # Treasures aka Scavenger Hunts
  if ( isset($data['Treasure']) && count($data['Treasure']) > 0):
       echo $this->Html->div('titentry', $this->Html->image('thunt.png', array('alt'=>'Treasures', 'width'=>'22')) .' '.__('Treasure Hunts'));
       foreach($data['Treasure'] as $t):
             echo $this->Html->para(Null, $this->Html->link($t['title'], '/treasures/view/'.$blogger['User']['username'].'/'.$t['id'].'/'.$data['Vclassroom']['id']));
	   endforeach;
  endif;

  # SCORM
  if ( isset($data['Scorm']) && count($data['Scorm']) > 0):
       echo $this->Html->div('titentry', $this->Html->image('scorm-icon.png', array('alt'=>'Scorms', 'width'=>'22')) .' SCORMS');
       foreach($data['Scorm'] as $s):
             echo $this->Html->para(Null, $this->Html->link($s['name'], 
                                     '/scorm/scorms/view/'.$s['id'].'/'.$blogger['User']['username'].'/'.$data['Vclassroom']['id']));
	   endforeach;
  endif;
 echo '</div>';
 #echo $this->element('fbconnect');  # facebook connect
 echo '<div style="clear:both;"></div>';
 echo '</div>'; #<!-- container -->
 endif; # user is logged in and member

  if ( $this->Session->check('Auth.User') && $this->Session->read('Auth.User.group_id') < 4 && $belongs === False): # student is login in portal but does not belongs to VC, so, show "Join" button   
     echo $this->Html->para(Null, __('In order to join this classroom you must know the access code, if you do not know it, please put in contact with classroom teacher'));
     echo $this->Form->create();
     echo $this->Form->hidden('UserVclassroom.vclassroom_id', array('value'=>$data['Vclassroom']['id']));
     echo $this->Form->input('UserVclassroom.code', array('size' => 9, 'maxlength'=>9, 'title'=>__('Access code'), 'between'=>': '));
     echo $this->Js->submit(__('Join to this class').'  '.$this->Session->read('Auth.User.username'),
                                    array('url'         => '/vclassrooms/jointoclass/',
                                          'update'      => '#updater',
                                          'evalScripts' => True,
                                          'before'      => $this->Gags->ajaxBefore('updater'),
                                          'complete'    => $this->Gags->ajaxComplete('updater')));
     echo '</form>';
     # empty ajax div
     echo $this->Gags->ajaxDiv('updater') . $this->Gags->divEnd('updater');
  endif;

echo $this->Gags->imgLoad('loading');

if ( !$this->Session->check('Auth.User') ):   # the user is anonymus
     echo $this->Html->link(__('Login to join this group'), '/users/login');
endif;
?>
</div><!-- border 1px solid black -->

<?php echo $this->Html->scriptStart(); ?>

//var myService;
// var feedUrl = 'feedUrl';

function setupMyService() {
  myService = new google.gdata.calendar.CalendarService('exampleCo-exampleApp-1');
}
//function getMyFeed() {
//  setupMyService();
 
//  myService.getEventsFeed(feedUrl, handleMyFeed, handleError);
//}
function chkPart()
{ 
  var title  = document.getElementById("ParticipationTitle");
  
  if (title.value.length < 2)
  {
    alert('<?php __('Title cannot be empty'); ?>');
    title.focus();
    return false;
  }
  return true;
}

function chkSubmit()
{ 
  var file  = document.getElementById("ReportFile");
  
  if (title.file.length < 4)
  {
    alert('<?php __('File cannot be empty'); ?>');
    file.focus();
    return false;
  }
  return true;
}

 function hideCourse() 
 {
    var Div = document.getElementById('qn');
    Div.innerHTML = "";
 }
<?php 
echo $this->Html->scriptEnd();
# ? > EOF
