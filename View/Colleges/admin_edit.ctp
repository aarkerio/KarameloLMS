<?php 
#die(debug($this->data));
$helps = $this->Session->read('Auth.User.helps'); # helps enabled
if ( isset($this->Js) ):
    echo $this->Html->script(array('ckeditor/ckeditor'));
endif;
echo $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
echo $this->Html->getCrumbs(' > ');

echo $this->Html->div('title_section', __('Edit College'));

echo $this->Html->para(Null, $this->Html->image('static/'.$this->data['College']['logo'], array('alt'=>$this->data['College']['name'])));
echo $this->Form->create('College', array('action'=>'edit'));
echo '<fieldset>';
echo $this->Form->hidden('College.id');
echo $this->Form->input('College.name', array('size' => 60, 'class'=>'required'));
echo $this->Form->input('College.description', array('type'=>'textarea', 'cols' => 60, 'rows' => 3, 'class'=>'required'));
echo $this->Ck->load('CollegeDescription', 'Karamelo', $this->Session->read('Auth.User.lang'));
echo $this->Form->input('College.email', array('size' => 40, 'maxlength'=>60));
echo $this->Form->input('College.twitter', array('size' => 9, 'maxlength'=>60));
echo $this->Form->input('College.gcalendar_id', array('type'=>'text', 'size' => 60, 'maxlength'=>80));
echo $this->Form->input('College.keywords', array('size' => 60, 'maxlength'=>80));
echo $this->Gags->helps('A specific user can blog for parents advices and questions', $helps);
echo $this->Form->input('College.sp',  array('type'=>'select','options'=>$sp, 'label'=>__('Blog for parents')));

echo $this->Form->input('College.end', array('type'=>'checkbox', 'label'=> __('Finish edition')));
echo $this->Html->div('limpia', ' ');
echo '</fieldset>';
echo $this->Html->div('submit', $this->Form->end(__('Save'))); 
?>
<br />

<?php
  #logo Stuff
  echo $this->Html->div('spaced');
  echo $this->Form->create('College', array('enctype'=>'multipart/form-data', 'action'=>'logo'));
  echo '<fieldset>';
  echo '<legend>'. __('Upload new logo') . '</legend>';
  echo $this->Form->hidden('College.id'); 
  echo $this->Html->div(null, 'An image 100 x 100 pixels');
  echo $this->Form->input('College.file', array('type'=>'file'));
  echo $this->Form->input('College.overwrite', array('type'=>'checkbox', 'label'=> __('Overwrite file if exist').': ')); 
  echo '</fieldset>';
  echo $this->Form->end(__('Upload'));
?>
</div>