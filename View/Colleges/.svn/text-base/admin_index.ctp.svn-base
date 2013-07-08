<div class="colleges">
<h2>List Colleges</h2>

<table cellpadding="0" cellspacing="0">
<tr>
	<th>Id</th>
	<th>Urlbase</th>
	<th>Name</th>
	<th>Description</th>
	<th>Email</th>
	<th>Keywords</th>
	<th>Actions</th>
</tr>
<?php foreach ($colleges as $college): ?>
<tr>
	<td><?php echo $college['College']['id']; ?></td>
	<td><?php echo $college['College']['urlbase']; ?></td>
	<td><?php echo $college['College']['name']; ?></td>
	<td><?php echo $college['College']['description']; ?></td>
	<td><?php echo $college['College']['email']; ?></td>
	<td><?php echo $college['College']['keywords']; ?></td>
	<td class="actions">
		<?php echo $this->Html->link('View','/admin/colleges/view/' . $college['College']['id'])?>
		<?php echo $this->Html->link('Edit','/admin/colleges/edit/' . $college['College']['id'])?>
		<?php echo $this->Html->link('Delete','/admin/colleges/delete/' . $college['College']['id'], null, 'Are you sure you want to delete id ' . $college['College']['id'])?>
	</td>
</tr>
<?php endforeach; ?>
</table>

<ul class="actions">
	<li><?php echo $this->Html->link('New College', '/admin/colleges/add'); ?></li>
</ul>
</div>