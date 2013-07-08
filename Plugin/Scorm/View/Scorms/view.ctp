<?php
# Chipotle Software(c) 2008-2012  GPLv3
# 
#die(debug($permissions));
$this->set('title_for_layout',  'Kandie::Scorm');
if ( $permissions['belongs'] == False || $permissions['chkdate'] == False || $permissions['already'] == True): 
    die($this->Html->div(Null, __('You already answered this SCORM, please click the Back button')));
endif;
echo $this->element('vccrumb', array('blogger'=> $blogger['User']['username'], 'vclassroom_id'=>$vclassroom_id));
echo '<div style="font-size:18pt;color:orange;position:absolute;top:10px;right:12px;width:400px;padding:4px;margin:8px;">Scorm Exercise</div>';
echo $this->Html->script('jquery-min', array('once'=>True));  #  jQuery min library

 echo $this->Html->ScriptStart();
 #$ScormVC = $data['ScormVclassroom'][0]; # Virtual classroom
 $ScormVC['id'] = 1;
 $api =  $data['Scorm']['version'] == '1.2' ?  2  : 4;   # Scorm version

?>
window.onbeforeunload = function ()
 {
  
 }

window.onunload = function ()
 {
  API.LMSFinish('');
 }

 window.onload = function ()
 {
  API = null;
  api = null;
 }

 $(window).bind('onunload', function(){
    alert("Do you really want to leave now?");
 });

 function setApi(api)
 {
   API = api; 
 }

 function myTimer()
 {
  var rt='dsfdsfdsf';
 }

 // jQuery, load data in iframes using jQuery
 function iFrame(sco_id, vclassroom_id)
 {
  $('#scoframe2').attr('src', '/scorm/scorms/loadapi/'+sco_id+'/'+vclassroom_id +'/'+<?php echo $data['Scorm']['id']." +'/'+ ".$api; ?>);
  setInterval(function(){myTimer()},80000);
  $('#scoframe1').attr('src', '/scorm/scorms/loadsco/'+sco_id+'/'+vclassroom_id);
 }

<?php  
echo $this->Html->ScriptEnd();
?> 
<div id="learnername">Learner: <?php echo $this->Session->read('Auth.User.username'); ?></div>
 <div id="scormpage" style="width:100%;margin:auto;border:1px solid black;">
    <div id="tocbox" style="width:100px;margin:auto;float:left;border:1px solid green;padding:3px;font-size:8pt;">TOC:<br />
    <ul id="s0">
    <li><?php echo $data['Scorm']['name']; ?></li>
   <?php
    foreach($data['ScormsSco'] as $sco):
        #debug($sco);
        switch ($sco['scormtype']):
             case"part":
                             #echo "i equals 0";
                             break;
                             
             case "item":
                             echo $sco['title'] .'<br />';
                             $tmp_identifierref = $sco['identifierref'];
                             break;
                             
             case "sco":
                              if ($tmp_identifierref == $sco['identifier']):
                                  if ( !isset($data['ResultScorm']['finished']) ):
                                      $img = 'icon_not_complete.gif';
                                      $st = __('Incomplete');
                                   else:
                                       $img = 'icon_complete.gif';
                                       $st = __('Completed');
                                 endif;
                                 echo '<li>' . $this->Html->image('static/'.$img,array('alt'=>$st,'title'=>$st)) . '&nbsp';
                                 echo $this->Html->link(__('Launch SCORM'), '#', array('onclick'=>"iFrame(".$sco['id'].", ".$ScormVC['id'].")"));
                                 echo '</li>';
                                 endif;
                                 break;  
        endswitch;
    endforeach;
      ?>
	</ul>
  </div> <!--  tocbox -->
  <div id="scormbox">
      <div id="scormobject" style="width:1100px;margin:auto;float:right;">
      <iframe id="scoframe1" name="scoframe1" width="100%" height="700" scrolling="auto" frameborder="1"></iframe>
      <iframe id="scoframe2" name="scoframe2" width="100%" height="4" scrolling="auto" frameborder="1"></iframe>
   </div> <!-- SCORM object -->
  </div> <!-- SCORM box  -->
</div> <!-- SCORM page -->

