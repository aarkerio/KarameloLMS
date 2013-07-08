<?php 
echo $this->Html->div('titulo', 'Karamelo&#8482; Help');
echo '<h1>'. __('Summary') . '</h1>';
echo $this->Html->div(null, null, array('style'=>'margin:10px'));
foreach ($data as $v):
echo $this->Html->link('&rArr; '.$v['Help']['title'], '/helps/view/'.$v['Help']['id'], array('escape'=>False)).'<br />';
endforeach;
$img = $this->Html->image('static/gnome-pdf.gif', array('alt'=>__('Download Manuals'), 'title'=>__('Download Manuals')));
echo $this->Html->para(null,$this->Html->link($img,'http://www.chipotle-software.com/blog/view/manuals/', array('escape'=>False)));
?>
</div>