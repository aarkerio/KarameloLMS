<table class="main_tabula">
<?php
//debug($data);
$th = array ('Edit', 'Report', 'Username', 'Name', 'Email', 'Delete');
echo $this->Html->tableHeaders($th); 

foreach ($data['User'] as $val):
  $tr = array (
	       $this->Gags->sendEdit($val['id'], 'users'),
               $this->Html->link('Reporte', '/admin/users/report/'.$val['id']),
	       $val['username'],
	       $val['name'],
	       $this->Html->link($val['email'],  'mailto:'.$val['email']),
	       $this->Gags->confirmDel($val['id'], 'users')
       );
        
  echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;
?> 
</table>