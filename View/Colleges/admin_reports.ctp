<?php 
#var_dump($data); 
echo $this->Html->div('title_section', __('College information')); 
echo $this->Html->div('title_section', '(Esto está en desarrollo)'); 
echo $this->Html->link($this->Html->image('static/edit_icon.gif', array('alt'=>'edit', 'title'=>'edit', 'url'=>'/admin/colleges/edit/'.$data['College']['id'] ))); 
?>
<dl>
	<dt><b>Urlbase</b></b></dt>
	<dd>&nbsp;<?php echo $data['College']['urlbase']?></dd>
	<dt><b>Name</b></b></dt>
	<dd>&nbsp;<?php echo $data['College']['name']?></dd>
	<dt><b>Description</b></dt>
	<dd>&nbsp;<?php echo $data['College']['description']?></dd>
	<dt><b>Email</b></dt>
	<dd>&nbsp;<?php echo $data['College']['email']?></dd>
	<dt><b>Keywords</b></dt>
	<dd>&nbsp;<?php echo $data['College']['keywords']?></dd>
</dl>
