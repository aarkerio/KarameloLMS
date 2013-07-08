<?php
$this->set('title_for_layout',  __('Current eCourses'));

$this->Html->addCrumb('Control Panel', '/admin/entries/start');
echo $this->Html->getCrumbs(' > '); 

echo $this->Html->div('title_section', $this->Html->image('ecourses.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('eCourses'), 'title'=>__('eCourses'))). ' eCourses');

echo $this->Html->div(null);
echo $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))),  
                     '/admin/ecourses/edit', array('escape'=>False)).'   &nbsp;&nbsp;';

echo $this->Html->link($this->Html->image('admin/icon_wizard.png', array('alt'=>__('Wizard'), 'title'=>__('Wizard'))),  
                                  '/admin/ecourses/wizard', array('escape'=>False));
echo '</div>';

echo $this->Gags->imgLoad();

foreach ($data as $val):
    $tmp  = $this->Html->div(Null,$this->Gags->sendEdit($val['Ecourse']['id'], 'ecourses'), array('style'=>'width:100px;float:right;'));
    $tmp .= $this->Html->div(Null, $this->Gags->confirmDel($val['Ecourse']['id'], 'ecourses'), array('style'=>'width:100px;float:right;'));
    $tmp .= $this->Html->link($val['Ecourse']['title'], '/admin/ecourses/vclassrooms/'.$val['Ecourse']['id'], array('style'=>'font-size:14pt;text-decoration:none;font-weight:bold;', 'title'=>__('vClassrooms'))).' ';

    $tmp .= $this->Html->link($this->Html->image('static/icon_group.png', array('width'=>'20px')),'/admin/ecourses/vclassrooms/'.$val['Ecourse']['id'], array('style'=>'font-size:14pt;text-decoration:none;font-weight:bold;', 'title'=>__('vClassrooms'), 'escape'=>False)). '  ';

    $tmp .= $this->Html->link($this->Html->image('static/activities_icon.png', array('width'=>'20px', 'alt'=>__('Activities'), 'title'=>__('Activities'))), '/admin/ecourses/activities/'.$val['Ecourse']['id'], array('style'=>'font-size:14pt;text-decoration:none;font-weight:bold;', 'title'=>__('Activities'), 'escape'=>False)). '  ';

    $tmp .= $this->Js->link($this->Html->image('static/arrow_down.png', array('alt'=>__('View eCourse details'), 'title'=>__('View eCourse details'))), '/admin/ecourses/details/'.$val['Ecourse']['id'], 
                array('update'      => '#qn'.$val['Ecourse']['id'],
                      'evalScripts' => True,
                      'before'      => $this->Gags->ajaxBefore('qn'.$val['Ecourse']['id']),
                      'complete'    => $this->Gags->ajaxComplete('qn'.$val['Ecourse']['id']),
                      'escape'      => False));
    $tmp .= $this->Gags->ajaxDiv('qn'.$val['Ecourse']['id'], array('style'=>'margin-top:15px')).$this->Gags->divEnd('qn'.$val['Ecourse']['id']);
    echo $this->Html->div('grayblock', $tmp, array('style'=>'vertical-align:top;'));
endforeach;

# ? > EOF
