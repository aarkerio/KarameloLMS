<?php
#die(debug($data));
$pc_id = $data['Pc']['PermanentClass']['id'];
$this->set('title_for_layout',  __('Permanent Class'));
$this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
$this->Html->addCrumb(__('Permanent Class'), '/admin/permanent_classes/listing');
echo $this->Html->getCrumbs(' > '); 

echo $this->Html->div('title_section', $this->Html->image('static/newsletter-icon.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Permanent Class'), 'title'=>__('permanent_class'))).' '.__('Permanent Class'). ': '.$data['Pc']['PermanentClass']['title']);

echo $this->Gags->imgLoad();

echo '<div style="padding:4px;">';
echo $this->Js->link($this->Html->image('static/icon_student.png', array('width'=>17,'alt'=>__('Enroll student to this group'), 'title'=>__('Enroll student to this groups'))),
                      '/admin/permanent_classes/items/'.$pc_id,
                                             array('update'      => '#qn',
                                                   'evalScripts' => True,
                                                   'escape'      => False,
                                                   'before'      => $this->Gags->ajaxBefore('qn'),
                                                   'complete'    => $this->Gags->ajaxComplete('qn'))) .'</div>';

echo $this->Gags->ajaxDiv('qn', array('style'=>'padding:0')) . $this->Gags->divEnd('qn');

echo '<table class="tbadmin">';
if ($data):
    $th = array(__('Name'),  ' ', __('Added'), __('Remove'));
    echo $this->Html->tableHeaders($th, array('style'=>'text-align:left;'));
endif;

foreach ($data['S'] as $val):
       $tr = array (
         '<b>'.$val['User']['name'].'</b>',
         $this->Html->image('avatars/'.$val['User']['avatar'], array('width'=>17,'alt'=>$val['User']['username'], 'title'=>$val['User']['username'])),
         $val['created'],
         $this->Html->link($this->Html->image('static/delete_icon.png',array('alt'=>__('Delete'),'title'=>__('Delete'), 'width'=>'16px')),
                           '/admin/permanent_classes/unlink/'.$val['ps_id'].'/'.$pc_id,array('escape' => False,'confirm' => 'Are you sure?'))
        );
        
        echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow); 
endforeach;

echo '</table>';
 

echo $this->Html->scriptStart(); 

?>
 function hideDiv()
 {
    var div  = document.getElementById("qn");
    div.style.display = 'none';
    return true;
 }
<?php
echo $this->Html->scriptEnd(); 
# ? > EOF
