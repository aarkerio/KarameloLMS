<?php
#die(debug($data));

$this->pageTitle = __('Virtual Classrooms');
$this->layout = 'portal';
echo $this->Html->div('title_portal', __('Virtual Classrooms'));

echo $this->Html->para(null, __('This is the virtual classrooms current list'));

if ( count($data) < 1 ):
    echo $this->Html->div(null, __('Sorry, no vClassrooms  yet'));
endif;
foreach($data as $v):
      $tmp  =  '» '.$this->Html->link($v['Vclassroom']['name'], '/vclassrooms/show/'.$v['Ecourse']['User']['username'].'/'.$v['Vclassroom']['id']);
      $tmp .= '<br /><span style="font-size:7pt;color:#000;">'.$v['Vclassroom']['sdate'] .'&nbsp;&nbsp;&nbsp;' .$v['Vclassroom']['fdate'].'</span><br /> '; 
      $tmp .= '<span style="font-size:8pt">'.__('Teacher') .': '.$v['Ecourse']['User']['name'] .'</span><br /> ';
      echo $this->Html->div(null, $tmp, array('style'=>'padding:9px;margin:11px;border:1px dotted gray;'));
endforeach;
?>
