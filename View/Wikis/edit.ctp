<?php
#die(debug($this->data));
$this->set('title_for_layout',  $this->data['Wiki']['title']);

 echo $this->element('vccrumb', array('blogger'=> $blogger['User']['username'], 'vclassroom_id'=>$this->data['Wiki']['vclassroom_id']));
 echo $this->Html->script('myfunctions');
 echo $this->Form->create();
 $title_input = array('size' => 50, 'maxlength'=>80, 'style'=>'color:black;font-size:16pt', 'between'=>'<br />');
 echo $this->Form->hidden('Revision.0.revision');
 echo $this->Form->hidden('Inner.blogger', array('value'=>$blogger['User']['username']));
 echo $this->Form->hidden('Inner.vclassroom_id', array('value'=>$this->data['Wiki']['vclassroom_id']));
 echo $this->Form->hidden('Wiki.id');
 echo $this->Form->hidden('Wiki.slug');
 $title_input['disabled'] = 'disabled';  # title can not be edited , is unique as in WikiPedia
?>
<fieldset>
<legend id="legend"><?php __('Edit WikiPage'); ?></legend>
<?php
echo $this->Form->input('Wiki.title',  array('value'=>$this->data['Wiki']['title'], 'readonly'=>'readonly')).'<br />';

echo $this->element('wikibar');

echo '<div style="width:100%;clear:both;">';
if ($blogger['User']['username'] == $this->Session->read('Auth.User.username')): # blogger = owner
    echo $this->Html->div('flotter',$this->Form->input('Wiki.status', array('type'=>'checkbox','value'=>'1','label'=> __('Published'))));
    echo $this->Html->div('flotter',$this->Form->input('Wiki.public', array('type'=>'checkbox', 'label'=> __('Public'), 'value'=>'1')));
endif;
echo $this->Html->div('flotter',$this->Form->input('Wiki.end', array('type'=>'checkbox', 'label'=> __('Finish edition'))));
echo '</div>';
echo '<div style="vertical-align:top;width:100%;padding:0;margin:0;overflow: auto;">';
echo $this->Js->submit(__('Save'), array(
                                         'url'      => '/wikis/edit',
                                         'update'   =>'saved',
                                         'evalScripts' => True,
                                         'before'      => $this->Gags->ajaxBefore('saved'),
                                         'complete'    => $this->Gags->ajaxComplete('saved')));

echo $this->Gags->ajaxDiv('saved') . $this->Gags->divEnd('saved');

echo $this->Html->div(null, __('Please use Preview button before save'), array('style'=>'font-size:7pt'));

echo $this->Js->submit('Preview', array('url'         =>'/wikis/preview', 
                                        'update'      => '#prev',
                                        'data'        => $this->Js->value('#Revision0content'),
                                        'evalScripts' => True,
                                        'before'      => $this->Gags->ajaxBefore('prev'),
                                        'complete'    => $this->Gags->ajaxComplete('prev')));

echo '</div>';
echo '</fieldset>';

echo $this->Gags->imgLoad('loading');
echo $this->Gags->ajaxDiv('prev') . $this->Gags->divEnd('prev');

echo $this->Html->link($this->Html->image('static/top.png', array('alt'=>'Top', 'title'=>'Top')), '#legend', array('escape'=>False));

# ? > EOF

