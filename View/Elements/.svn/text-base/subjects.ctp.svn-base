<?php 
echo $this->Html->div('sideelement');
echo $this->Html->div('sidemenu', __('Subjects'). $this->Js->link($this->Html->image('static/arrow_down.png', array('alt'=>__('Display Subjects'), 'title'=>__('Display Subject'))), '/subjects/display',
         array('update'      => '#qn',
               'evalScripts' => True,
               'before'      => $this->Js->get('#loading3')->effect('fadeIn', array('buffer' => False)),
               'complete'    => $this->Js->get('#loading3')->effect('fadeOut', array('buffer' => False)),
               'escape'      => False
               )));
echo $this->Gags->imgLoad('loading3');
echo $this->Gags->ajaxDiv('qn').$this->Gags->divEnd('qn');
?>
</div>