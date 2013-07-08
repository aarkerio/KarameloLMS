<?php
if ( count($pcs) < 1 ):
    echo $this->Html->para(Null, __('You do not have any permanent students list, you can create a new one').' '.$this->Html->link(__('here'), '/admin/permanent_classes/edit', array('target'=>'_blank')) .'.'); 
else:
    echo $this->Form->create('PermanentClass', array('action'=>'get'));
    echo $this->Form->input('PermanentClass.vclassroom_id', array('type'=>'hidden', 'value'=>$vclassroom_id));
    ?>
    <fieldset>
    <legend><?php echo __('Import lists of students in this virtual classroom'); ?></legend>
    <?php
    echo $this->Form->input('PermanentClass.pc_id', array('type'=>'select', 'label'=> __('Lists of students'), 'options'=>$pcs));
    echo $this->Html->para(Null, $this->Form->end(__('Import')));
    echo '</fieldset></div>';

    $img = $this->Html->div(Null, $this->Html->link($this->Html->image('static/icon_hide.gif', array('alt'=>__('Hide'), 'title'=>__('Hide'))), 
         '#head', array('onclick'=>'hideDiv()', 'escape'=>False)));

    echo $this->Html->div(Null, $img, array('style'=>'margin-top:15px;padding:4px;'));
endif;

# ? > EOF

