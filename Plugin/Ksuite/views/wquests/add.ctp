<fb:dashboard>
     <fb:action href="index">Home</fb:action>
     <fb:action href="listing">Display your Webquests</fb:action>
     <fb:action href="help">Help</fb:action>
</fb:dashboard>

<?php
print ('
<style type="text/css">
 h1{ margin: 10px; font-size: 24pt; }
 h2{ margin: 15px; font-size: 20pt; }
 normal{ margin-top: 10px; font-size: 12pt; }
</style>
');

echo $html->div('normal', $html->image('http://mononeurona.org/img/imgusers/aarkerio_1790.jpg', array('title'=>'New webquest','alt'=>'New webquest')));

?>
<fb:fbml>

<fb:editor action="save" labelwidth="100">

<fb:editor action="save" labelwidth="100">
  <fb:editor-text name="data[Wquest][title]"            label="Title" />

  <fb:editor-textarea name="data[Wquest][introduction]" label="Introduction" rows="11">
     The purpose of this section is to both prepare and hook the reader. The student is the intended audience.
  </fb:editor-textarea>

  <fb:editor-textarea name="data[Wquest][tasks]" label="Tasks"  rows="11">
     The task focuses learners on what they are going to do - specifically, the culminating performance or product that drives all of the learning activities.  
  </fb:editor-textarea>

  <fb:editor-textarea name="data[Wquest][process]"  label="Process"  rows="11">
       This section outlines how the learners will accomplish the task. Scaffolding includes clear steps, resources, and tools for organizing information.
  </fb:editor-textarea>

  <fb:editor-textarea name="data[Wquest][evaluation]" label="Evaluation" rows="11">
       This section describes the evaluation criteria needed to meet performance and content standards.
  </fb:editor-textarea>

  <fb:editor-textarea name="data[Wquest][conclusion]" label="Conclusion" rows="11">
    The conclusion brings closure and encourages reflection.
  </fb:editor-textarea>

  <fb:editor-custom label="Points">
     <select name="data[Wquest][points]"> 
         <option value="1">1</option>
         <option value="2">2</option>
         <option value="3">3</option>
 		 <option value="4">4</option>
		 <option value="5">5</option>
     </select>
  </fb:editor-custom>
  <fb:editor-buttonset>
      <fb:editor-button value="Save"/>
  </fb:editor-buttonset>
</fb:editor>
<fb:fbml>
