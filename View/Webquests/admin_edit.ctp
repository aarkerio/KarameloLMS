<?php 
echo $this->Html->script(array('ckeditor/ckeditor', 'jquery.form',  'ckeditor/adapters/jquery'));  
$this->Html->addCrumb('Control Panel', '/admin/entries/start');  
$this->Html->addCrumb('Webquests', '/admin/webquests/listing'); 
echo $this->Html->getCrumbs(' > ');
 
echo $this->Html->div('title_section', $wq_title);
?>
<p style="text-align:right;">
<?php 
echo $this->Html->link($this->Html->image('admin/myimages.jpg', array('alt'=>__('My Images'), 'title'=>__('My Images'))), '#', array('onclick'=>"javascript:window.open('/admin/images/listing/set', 'blank', 'toolbar=no, scrollbars=yes,width=700,height=500')", 'escape'=>False)) . '&nbsp;&nbsp;';

echo $this->Html->link($this->Html->image('static/eye_icon.gif', array('alt'=>__('See webquest'), 'title'=>__('See webquest'))), '#', array('onclick'=>"javascript:window.open('/admin/webquests/view/".$id."', 'blank', 'toolbar=no, scrollbars=yes,width=700,height=500')", 'escape'=>False));
 ?>
</p>
<?php echo $this->Gags->imgLoad('loading'); ?>

<div style="width:900px;text-align:center;height:20px;font-size:14pt;margin:0 auto;" id="menu">
<?php
   echo $this->Html->div('tab', $this->Js->link(__('Introduction'), '/admin/webquests/get/introduction/'.$id, 
                   array('update'      => '#setform',
                         'evalScripts' => True,
                         'before'      => $this->Gags->ajaxBefore('setform'),
                         'complete'    => $this->Gags->ajaxComplete('setform'))));

   echo $this->Html->div('tab', $this->Js->link(__('Tasks'), '/admin/webquests/get/tasks/'.$id, 
                   array('update'      => '#setform',
                         'evalScripts' => True,
                         'before'      => $this->Gags->ajaxBefore('setform'),
                         'complete'    => $this->Gags->ajaxComplete('setform'))));

   echo $this->Html->div('tab', $this->Js->link(__('Process'),  '/admin/webquests/get/process/'.$id, 
                   array('update'      => '#setform',
                         'evalScripts' => True,
                         'before'      => $this->Gags->ajaxBefore('setform'),
                         'complete'    => $this->Gags->ajaxComplete('setform'))));

   echo $this->Html->div('tab', $this->Js->link('Roles', '/admin/webquests/get/roles/'.$id, 
                   array('update'      => '#setform', 
                         'evalScripts' => True,
                         'before'      => $this->Gags->ajaxBefore('setform'),
                         'complete'    => $this->Gags->ajaxComplete('setform'))));

   echo $this->Html->div('tab', $this->Js->link(__('Evaluation'), '/admin/webquests/get/evaluation/'.$id, 
                   array('update'      => '#setform', 
                         'evalScripts' => True,
                         'before'      => $this->Gags->ajaxBefore('setform'),
                         'complete'    => $this->Gags->ajaxComplete('setform'))));

   echo $this->Html->div('tab', $this->Js->link(__('Conclusion'), '/admin/webquests/get/conclusion/'.$id, 
                   array('update'      => '#setform', 
                         'evalScripts' => True,
                         'before'      => $this->Gags->ajaxBefore('setform'),
                         'complete'    => $this->Gags->ajaxComplete('setform'))));
   
   echo $this->Html->div('tab', $this->Js->link(__('Title & points'), '/admin/webquests/get/title/'.$id, 
                   array('update'      => '#setform', 
                         'evalScripts' => True,
                         'before'      => $this->Gags->ajaxBefore('setform'),
                         'complete'    => $this->Gags->ajaxComplete('setform'))));

echo '</div>';

echo $this->Gags->ajaxDiv('setform') . $this->Gags->divEnd('setform');

# JS code
echo $this->Html->scriptStart();
?>

 function checkExistence(name)
 { 
  var fullname = 'textarea#'+name;
  // var editor = $(fullname).ckeditorGet();
  //alert( editor );
  //alert(fullname);
  if ( CKEDITOR.instances[name]  ) 
  {
      // alert('Already created!!');
      //CKEDITOR.instances[name].destroy();  // not work
      delete CKEDITOR.instances[name];
      $(fullname).ckeditor({ toolbar:'Karamelo', width:800, height:500 });
  } else {
       $(fullname).ckeditor({ toolbar:'Karamelo', width:800, height:500 });
       // CKEDITOR.replace(name);
  }
 }

 function hU() 
 {
   var Div = document.getElementById('tit');
 
    if (Div.style.display == 'none')
        Div.style.display = 'block';
    else 
        Div.style.display = 'none';
 }

<?php 
echo $this->Html->scriptEnd(); 
echo $this->Js->writeBuffer();
# ? > EOF