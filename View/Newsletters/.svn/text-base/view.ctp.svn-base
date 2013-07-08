<?php
echo $this->Html->div(null, __('Newsletter'), array('style'=>'margin:0 0 10px 0;font-size:10pt;font-weight:bold;border-bottom:1px solid black;'));
echo $this->Html->div(null, $data['Newsletter']['title'], array('style'=>'margin:10px 0;font-size:14pt;font-weight:bold;'));

#Create PDF
#$img_pdf =  $this->Html->image('static/gnome-pdf.gif', array('alt'=>__('Export as PDF'), 'title'=>__('Export as PDF')));
#echo $img_pdf.' '.$this->Html->link(__('Export as PDF'),'/newsletters/renderpdf/'.$data['Newsletter']['id'], array('style'=>'font-size:7pt')); 

echo $this->Html->div(null, $data['Newsletter']['created'], array('style'=>'margin-bottom:10px;font-size:7pt;font-weight:bold;'));
echo $this->Html->div(null, $data['Newsletter']['body']);
?>