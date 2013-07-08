<?php
#die(debug($vclassrooms));
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb('WikiPages', '/admin/wikis/listing');
echo $this->Html->getCrumbs(' > ');

if ( !$vclassrooms ):  # there is not vclassroom to add wiki
    echo $this->Html->div('advice');
    echo __('Woops! Looks like you do not have any Virtual classroom enabled, you need at least one vClassroom to assign the WikiPage to it').'.';
    echo '<br />';
    echo __('Please clic on eCourse in menu and add a vClassroom to your eCourse').'.';
    echo '</div>';  
else:
    echo $this->Html->css('wiki');
    echo $this->Form->create('Wiki', array('action'=>'edit', 'id'=>'form'));
    $title_input = array('size' => 60, 'maxlength'=>80, 'label'=>__('Title'));

    if ( isset($this->request->data['Wiki']['id']) ):
        echo $this->Form->hidden('Revision.0.revision');
        echo $this->Form->hidden('Wiki.id');
        $legend = __('Edit Wiki');
        $title_input['disabled'] = 'disabled';  # title can not be edited
    else:
        $legend = __('New Wiki');
        echo $this->Html->div('message', __('Please think about your title, you can not change after save'));
    endif;
   ?>
   <fieldset>
   <legend id="legend"><?php echo $legend; ?></legend>
   <?php
   echo $this->Form->input('Wiki.title', $title_input);
   echo $this->Form->input('Wiki.subject_id', array('label' => __('Subject'), 'options'=>$subjects));
   echo $this->Form->input('Wiki.vclassroom_id', array('label'=>__('vClassroom'), 'options'=>$vclassrooms));

   echo $this->Gags->setImages();

   echo $this->element('wikibar');

   echo $this->Form->input('Wiki.status', array('type'=>'checkbox', 'label'=> __('Published'), 'value'=>'1'));
   echo $this->Form->input('Wiki.public', array('type'=>'checkbox','label'=> __('Public'), 'value'=>'1'));
   echo $this->Form->input('Wiki.end',  array('type'=>'checkbox','label' => __('Finish edition')));

  
   echo $this->Js->submit('Preview', array(
                                'url'         => '/wikis/preview', 
                                'id'          => 'preview',
                                'update'      => '#prev',
                                'evalScripts' => True,
                                'before'      => $this->Gags->ajaxBefore('prev'),
                                'complete'    => $this->Gags->ajaxComplete('prev')));
   echo $this->Html->div(Null, __('Please use Preview button before save'), array('style'=>'font-size:7pt'));

   echo '</fieldset>';
   echo $this->Form->end(__('Save'), array('style'=>'width:40%;float:left;'));

   echo $this->Gags->imgLoad('loading');
   echo $this->Gags->ajaxDiv('prev') . $this->Gags->divEnd('prev');

   echo $this->Html->link($this->Html->image('static/top.png', array('alt'=>'Top', 'alt'=>'Top')), '#legend', array('escape'=>False));
endif;

# ? > EOF

