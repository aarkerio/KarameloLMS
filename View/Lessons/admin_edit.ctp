<?php 
 $helps = $this->Session->read('Auth.User.helps');  # helps enabled ? 
 $chk   = $this->Session->read('Auth.User.editor'); # editor enabled ? 

 if (isset($js)): 
     echo $this->Html->script(array('ckeditor/ckeditor'));
 endif; 

 $this->Html->addCrumb('Control Panel', '/admin/entries/start');
 $this->Html->addCrumb(__('Lessons'), '/admin/lessons/listing');
 echo $this->Html->getCrumbs(' > ');
 
 echo $this->Form->create('Lesson', array('action' => 'edit'));
 if ( isset($this->data['Lesson']['id']) ):
     echo $this->Form->hidden('Lesson.id');
     $legend = __('Edit lesson');
 else:
     $legend = __('Add lesson');
 endif;
?>
<fieldset>
<legend><?php echo $legend; ?></legend>
<table>
<tr><td colspan="2"><?php echo $this->Form->input('Lesson.title', array('size' => 40, 'class'=>'required', 'maxlength' => 120, 'label'=>__('Title')));  ?></td>
<td>
 <?php echo $this->Form->input('Lesson.subject_id', array('label'=>__('Subject'), 'type'=>'select')); ?>
 </td>
 <td><?php echo $this->Gags->setImages(); ?>
</tr>
<tr>
<td colspan="4">
 <?php 
    echo $this->Form->input('Lesson.body', array('type'=>'textarea','cols'=>120, 'rows'=>40, 'class'=>'required', 'label'=>False));
    if ( $chk != 0 ):
        echo $this->Ck->load('LessonBody', 'Karamelo',$this->Session->read('Auth.User.lang'), 800, 600);
    endif;
  ?>
  </td></tr>
  <tr><td>
  <?php 
   echo $this->Gags->helps('If not selected, lesson remains as draft', $helps);
   echo $this->Form->input('Lesson.status', array('label'=>__('Published'), 'type'=>'checkbox', 'value'=>'1', 'div'=>False));
  ?>
  </td><td>
  <?php
   echo $this->Gags->helps('Allow comments in this lesson', $helps); 
   echo $this->Form->input('Lesson.disc', array('label'=>__('Allow comments'), 'type'=>'checkbox', 'value'=>'1', 'div'=>False));
  ?>
  </td><td>
  <?php
   echo $this->Gags->helps('If active, only logged users can see this lesson', $helps);
   echo $this->Form->input('Lesson.public', array('label'=>__('Lesson is public'), 'type'=>'checkbox', 'value'=>'1', 'div'=>False));
  ?>
  </td><td>
  <?php
   echo $this->Gags->helps('Save and return to list screen', $helps);
   echo $this->Form->input('Lesson.end', array('label'=>__('End edition'), 'type'=>'checkbox', 'value'=>'1', 'div'=>False));
  ?>
  </td></tr>
  <tr><td colspan="4" style="margin-top:17px;"> <br />
       <?php echo $this->Form->end(array('label'=>__('Save'), 'div'=>False)); ?>
</td></tr>
</table>
</fieldset>

<script type="text/javascript">
    // El autosalvado tiene problemas en Chrome, por ahora lo comento 
    // $(document).ready(function(){		
    // var t = setTimeout("autosave()", 20000); 
    // });
	function autosave()
	{
		//set autosave each 20 seconds
		var t = setTimeout("autosave()", 20000);	
		//get form values
		var id=$("#LessonId").val();	
		var subject=$("#LessonSubjectId").val();			
		var title =$("#LessonTitle").val();
		//get values from CKEDITOR
		var oEditor = CKEDITOR.instances.LessonBody; 
		var body=oEditor.getData();   
		var body=body.toString(); 
		var body= cleanString(body); 
		// http://www.w3schools.com/jsref/jsref_encodeURIComponent.asp
		var body = encodeURIComponent(body);
		if (title.length > 0 || body.length > 0)
		{
			$.ajax(
			{
				type: "POST",
				url: "/lessons/autosave",
				data: "data[Lesson][body]=" + body + 
				      "&data[Lesson][subject_id]=" + subject + 
				      "&data[Lesson][title]=" + title + 
				      "&data[Lesson][id]=" +id,
				cache: false,
				success: function()
				{	
					$("#timestamp").empty().append('');
				}
			});
		}
	} 
	function cleanString(body)
	{
		do {

		    body = body.replace('&nbsp;', '\r'); 

		} while(body.indexOf('&nbsp;') >= 0);
		return body; 

	}
</script>
