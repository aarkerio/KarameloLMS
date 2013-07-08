<?php 
#die(debug($this->data));
$this->set('title_for_layout',  'Virtual Classrooms');
$helps = $this->Session->read('Auth.User.helps'); # helps enabled ?

if (isset($this->Js)):
    echo $this->Html->script('jquery-validate/jquery.validate');
endif;

$this->Html->addCrumb('Control Panel', '/admin/entries/start');  

# Crumb hack
if ( isset($ecourse) ):
    $ecourse_id = (int) $ecourse['Ecourse']['id'];
else:
    $ecourse_id = (int) $this->data['Ecourse']['id'];
endif;

if ( isset($this->data['Vclassroom']['name']) ):
    $VcName = $this->data['Vclassroom']['name']; 
else:
    $VcName = __('New Virtual Classroom');
endif;

$this->Html->addCrumb('vClassrooms', '/admin/ecourses/vclassrooms/'.$ecourse_id);
echo $this->Html->getCrumbs(' > '); 

echo $this->Form->create('Vclassroom', array('action'=>'edit', 'onsubmit'=>'return chkForm()'));
if (isset($this->request->data['Vclassroom']['id'])): 
    echo $this->Form->input('Vclassroom.id', array('type'=>'hidden'));
    echo $this->Form->input('Vclassroom.ecourse_id', array('type'=>'hidden'));
    $legend = __('Edit vClassroom');
else:
    echo $this->Form->hidden('Vclassroom.ecourse_id', array('value'=>$ecourse['Ecourse']['id']));
    $legend = __('New vClassroom');
endif;
?>
<fieldset>
<legend><?php 
echo $legend .' .- '. $ecourse['Ecourse']['title']; 
?></legend> 
<?php
echo $this->Form->input('Vclassroom.name', array('size' => 40, 'maxlength' => 60, 'label'=>__('vClassroom Name'))); 
echo $this->Form->input('Vclassroom.sdate',array('type'=>'date','label'=>__('Starting date'), 'dateFormat'=>'DMY'));
echo $this->Form->input('Vclassroom.fdate',array('type'=>'date','label'=>__('Finishing date'), 'dateFormat'=>'DMY'));

echo $this->Gags->helps('Introduzca aqui en ID del Google Calendar para este grupo', $helps);
echo $this->Form->input('Vclassroom.gcalendar_id', array('type'=>'text', 'size' => 70, 'maxlength' => 70));
 
echo  $this->Html->div(Null);
echo $this->Html->link($this->Html->image('static/icon-gcalendar.png', array('alt'=>'gCalendar', 'title'=>'gCalendar', 
                         'onmouseover'=>"Tip('Publish activities in Google calendar')", 'onmouseout'=>"UnTip()")), 
                           '/admin/ecourses/export/'.$VcName.'/',array('onclick'=>'return false;','escape'=>False,'id'=>'popup'));
echo '</div><!-- gcalendar -->';

echo $this->Form->input('Vclassroom.status', array('type'=>'checkbox', 'label'=> __('Published'), 'value'=>'1')); 

echo $this->Gags->helps('Código de acceso al salón virtual, sólo los estudiantes que conozcan este código pueden darse de alta en el grupo', $helps);
echo $this->Form->input('Vclassroom.secret', array('size' => 9, 'maxlength' => 9, 'label'=>__('Access code')));

echo $this->Gags->helps('Show diploma when student completed course successfully', $helps);
echo $this->Form->input('Vclassroom.diploma', array('type'=>'checkbox', 'label'=> __('Show diploma'), 'value'=>'1')); 

echo $this->Gags->helps('Mover al histórico: selecciona esta opción cuando un grupo virtual ha terminado y deseas pasarlo al archivo muerto', $helps);
echo $this->Form->input('Vclassroom.historical', array('type'=>'checkbox', 'label'=> __('Move to historial'), 'value'=>'1')); 
 
echo $this->Form->input('Vclassroom.end', array('type'=>'checkbox', 'label'=> __('Finish edition'), 'value'=>'1')); 
echo '</fieldset>';
echo $this->Form->end(array('value'=>__('Save')));  
 
echo $this->Html->scriptStart();
?>
$(document).ready(function() {
    $('#popup').popupWindow({
            height:500, 
            width:800, 
            top:50, 
            left:480 
            });
    return false;
    });

 function mostrar(a)
 {
      var Div = document.getElementById(a);
      
       if (Div.style.display == "none")
       {
	            Div.style.display = "block";
       }
       else
       {
	           Div.style.display = "none";
       }
 }
 
 function chkForm()
 {
     var title   = document.getElementById("VclassroomName");
     var access  = document.getElementById("VclassroomAccess");
     var secret  = document.getElementById("VclassroomSecret");
   
   if (title.value.length < 5)
   {
       alert('<?php __('Title minimun 6 characters'); ?>');
       title.focus();
       return false;
   }
 
   if (secret.value.length < 5)
   {
      alert('<?php __('Access Code minimun 6 characters'); ?>');
      secret.focus();
      return false;
   }
 
   return true;
 }
<?php 
echo $this->Html->scriptEnd();
# ? > EOF