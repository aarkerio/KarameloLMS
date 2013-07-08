<?php 
$helps = $this->Session->read('Auth.User.helps'); # helps enabled ?
echo $this->Html->script('ckeditor/ckeditor');

$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb(__('eCourses'), '/admin/ecourses/listing');
echo $this->Html->getCrumbs(' > ');

echo $this->Form->create('Ecourse', array('action' => 'edit'));

if ( isset($this->data['Ecourse']['id']) ): 
    echo $this->Form->hidden('Ecourse.id');
    $legend = __('Edit eCourse');
else:
    $legend = __('New eCourse');
endif;
?>
<fieldset>
<legend><?php echo $legend; ?></legend>

<table style="tbadmin"><tr><td colspan="3">
<?php  echo $this->Form->input('Ecourse.title', array('size'=>30,'maxlength'=>90,'title'=>' e.g. History of Literature')) ;?>
</td><td>
  <?php echo $this->Form->input('Ecourse.subject_id', array('options'=>$subjects, 'label'=>__('Subject'), 'type'=>'select')); ?>
</td><td>
  <?php echo $this->Form->input('Ecourse.lang_id', array('label'=>__('Language'), 'options'=>$langs, 'type'=>'select')); ?>
 </td>
</tr><!--End row -->
<tr><td colspan="3">
<?php 
 echo $this->Gags->helps('Tipo de curso: con clases presenciales (mixto) o completamente en línea', $helps);
 $kinds = array(0 => __('Mixed'), 1 => __('On line'));
 echo $this->Form->input('Ecourse.kind', array('label'=>__('Type'), 'options'=>$kinds));
?>
</td>
<td colspan="2">
<?php
 $percentages = array(60=>60, 70=>70, 75=>75, 80=>80, 85=>85, 90=>90, 95=>95, 100=>100);
 echo $this->Gags->helps('Minimum points percentage required to aprobe course', $helps);
 echo $this->Form->input('Ecourse.percentage', array('label'=>__('Percentage') .'%', 'options'=>$percentages));
?>
</td>
</tr>
<tr><td colspan="5">
<?php
  echo $this->Gags->helps('Describa el curso, las horas de duración, asi como los objetivos, la audiencia a la que va dirigida, y el temario', $helps);
  echo $this->Form->input('Ecourse.description', array('type'=>'textarea','cols'=>40, 'rows'=>4,'label'=>__('Description')));
  echo $this->Ck->load('EcourseDescription', 'Karamelo', $this->Session->read('Auth.User.lang'));
?>
 </td></tr>
<tr><td>
<?php
 echo $this->Gags->helps('Este campo es para control interno, es el código breve del curso', $helps);
 echo $this->Form->input('Ecourse.code', array('size' => 12, 'maxlenght' => 12, 'title'=>'max. 12 characters, ie.ROM2121', 'label'=>__('Code')));
 ?>
 </td>
 <td>
<?php
 echo $this->Gags->helps('Seleccione esta opción si el curso ya está listo y con todas sus actividades definidas', $helps);
 echo $this->Form->input('Ecourse.status', array('type'=>'checkbox', 'value'=>'1', 'label'=> __('Published'), 'title'=>__('Enabled course'))); 
 ?>
</td><td>
<?php
  echo $this->Gags->helps('Si es activada esta opción el curso aparece listado en portada y los usuarios no registrados pueden solicitar información sobre él', $helps);
echo $this->Form->input('Ecourse.public', array('type'=>'checkbox',  'value'=>'1', 'label' => __('Public'))); 
 ?>
</td>
  <td>
<?php
 echo $this->Gags->helps(__('Seleccione esta opción para permitir que otros profesores utilizen la información de este curso en sus propias clases'), $helps);
 echo $this->Form->input('Ecourse.knet', array('type'=>'checkbox',  'label' => __('Share in Knet'))); 
?>
</td>
<td>
<?php
  echo $this->Gags->helps(__('Seleccione esta opción para concluir la edición en esta pantalla'), $helps);
  echo $this->Form->input('Ecourse.end', array('type'=>'checkbox',  'label' => __('Finish edition'))); 
?>
</td>
</tr>
  <tr><td colspan="4">
   <?php echo $this->Form->end(__('Save')); ?>
 </td></tr>
</table>
</fieldset>
<script type="text/javascript">
/* <![CDATA[ */
function chkForm()
{ 
  var title   = document.getElementById("EcourseTitle");
  var access  = document.getElementById("EcourseAccess");
  var secret  = document.getElementById("EcourseSecret");

  if (title.value.length < 5)
  {
      alert('Title larger than 6 characters');
      title.focus();
      return false;
  }

  if (access.checked == true)
  {
       if (secret.value.length < 5)
       { 
       alert('You must type a secret code');
       secret.focus();
       return false;
      }
  }
  return true;
}
/* ]]> */
</script>
