<?php
$helps = $this->Session->read('Auth.User.helps'); # helps enabled ?
$this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
$this->Html->addCrumb('Podcasts', '/admin/podcasts/listing');
echo $this->Html->getCrumbs(' > '); 

if (isset($this->request->data['Podcast']['id'])): 
    echo $this->Form->hidden('Podcast.id');
    $action = 'edit';
    $legend = __('Edit');
else:
    $legend = __('New');
    echo $this->Gags->maxUploadSize();
    $action = 'add';
endif;
echo $this->Form->create('Podcast', array('enctype'=>'multipart/form-data', 'action'=>$action));
?>
<fieldset>
  <legend><?php echo $legend ?> Podcast</legend>  
<?php 
  if ( $action == 'add' ):
      echo $this->Form->input('Podcast.file',    array('label' => __('MP3 File'), 'type'=>'file'));
  endif;
  echo $this->Form->input('Podcast.status',      array('label' => __('Published'),'type'=>'checkbox')); 
 # echo $this->Gags->helps(__('If active, only logged users can see this FAQ'), $helps);
  echo $this->Form->input('Podcast.public',      array('type'=>'checkbox', 'label' => __('Podcast is public')));
  echo $this->Form->input('Podcast.adult',       array('label' =>__('Adult language'), 'type'=>'checkbox')); 
  echo $this->Form->input('Podcast.knet',        array('label' =>__('Share in Knet'), 'type'=>'checkbox'));
  echo $this->Form->input('Podcast.created',     array('type'=>'date','label'=>__('Created'), 'dateFormat'=>'DMY'));
  echo $this->Form->input('Podcast.subject_id',  array('type'=>'select', 'options'=>$subjects,  'label' => __('Subject')));
  echo $this->Form->input('Podcast.title',       array('size' => 25, 'maxlength' => 50, 'label'=>__('Title')));
  echo $this->Form->input('Podcast.description', array('type'=>'textarea', 'rows'=>8, 'cols'=>40, 'label'=> __('Description')));
  echo $this->Form->end(__('Upload')); 

  echo '</fieldset>';

# ? > EOF
