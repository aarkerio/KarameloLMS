<?php
echo $this->Html->script(array('jquery.form', 'jquery.CKEditor', 'ckeditor/adapters/jquery'));

$helps = $this->Session->read('Auth.User.helps'); # helps enabled?

echo $this->Gags->ajaxDiv('autosave_time').$this->Gags->divEnd('autosave_time');

echo $this->Form->create();
echo $this->Form->hidden('Entry.id');
if ( isset($autosave) ):
    $legend = __('New Entry');
else:
    $legend = __('Edit Entry');
endif;
?> 
<fieldset>
<legend><?php echo $legend; ?></legend>
<table style="margin:0 auto 0 auto;width:100%;">
<tr><td><?php echo $this->Form->input('Entry.title', array('size'=>40,'maxlength'=>50,'label'=>__('Title')));?></td>
    <td><?php echo $this->Form->input('Entry.subject_id', array('label'=>__('Subject'), 'type'=>'select')); ?></td>
    <td><?php echo $this->Gags->setImages(); ?></td>
</tr>
<tr>
 <td colspan="3">
  <?php 
  echo $this->Form->input('Entry.body', array('type'=>'textarea', 'cols'=>80, 'rows'=>22, 'label'=>False)); 
  echo $this->Html->scriptBlock("$('textarea#EntryBody').ckeditor({ toolbar:'Karamelo', width:800, height:500});");
  #echo $this->Html->scriptBlock("CKEDITOR.replace('EntryBody',{ toolbar : 'Karamelo' });");
 ?>
  </td></tr>
  <tr><td>
 <?php 
  echo $this->Gags->helps('Mark if you are ready to publish this information, or leave to work on draft mode', $helps);
  echo $this->Form->input('Entry.status', array('label'=>__('Published'), 'type'=>'checkbox'));
  ?>
  </td>
  <td>
 <?php
  echo $this->Gags->helps('Allow comments in this entry', $helps);
  echo $this->Form->input('Entry.discussion', array('label'=>__('Allow comments'), 'type'=>'checkbox'));
?>
  </td>
  <td>
 <?php 
  echo $this->Gags->helps('Save and return to list screen', $helps);
  echo $this->Form->input('Entry.end', array('label'=>__('Finish edition'), 'type'=>'checkbox')); 
  ?>
</fieldset> 
  </td>
 </tr>
 <tr>
<td colspan="3">
<?php
  echo $this->Js->submit(__('Save'), array('url'            => '/admin/entries/edit',
                                                    'update'      => '#adminEdit',
                                                    'evalScripts' => True,
                                                    'before'      => $this->Gags->ajaxBefore('adminEdit')."CKEDITOR.instances['EntryBody'].destroy();",
                                                    'complete'    => $this->Gags->ajaxComplete('adminEdit')
                         ));
   echo '</form>';
   #echo $this->Ck->phpCkAjax();
 ?>
  </td>
  </tr>
</table>
<?php 
echo $this->Html->scriptStart(); 
?>

//This is collapsing with bauer ajax admin so I am disabling
$(document).ready(function(){

//if ( $('#EntryTitle').val() ) // only if edit form is set
//{

	autosave();       
//}
}); 
    
    

      
function autosave()
{
$('EntryBody').ckeditor();
	//set autosave each 4 minutes    
	var t = setTimeout("autosave()", 40000);
	//get form values
	var id      = jQuery('#EntryId').val();	
	var subject = jQuery('#EntrySubjectId').val();
	var title   = jQuery('#EntryTitle').val();
	//get values from CKEDITOR
	var oEditor = CKEDITOR.instances.EntryBody;
if (oEditor) 
{
       var body    = oEditor.getData();   
       var body    = body.toString(); 
       var body    = cleanString(body); 
       // http://www.w3schools.com/jsref/jsref_encodeURIComponent.asp
       var body = encodeURIComponent(body);
       if (title.length > 0 || body.length > 0)
	{ 
	  jQuery.ajax(
		  {
			type: "POST",
			url: "/admin/entries/record",
			data: "data[Entry][body]=" + body + 
			      "&data[Entry][subject_id]=" + subject + 
			      "&data[Entry][title]=" + title + 
			      "&data[Entry][id]=" +id,
	   
              		       cache: false,
				success: function()
				{	
					jQuery("#timestamp").empty().append('');
                    			var date = new Date();
                    			jQuery('#autosave_time').html('<div class="hour"><?php echo __("Draft saved at")." "; ?>'+date.getHours()+':'+date.getMinutes()+':'+date.getSeconds()+'</div>');
				}
		});
	}
}
}

 
function cleanString(body)
{
do {
    body = body.replace('&nbsp;', '\r'); 
} while(body.indexOf('&nbsp;') >= 0);
return body; 
}

<?php 
echo $this->Html->scriptEnd(); 
echo $this->Js->writeBuffer();
?> 
