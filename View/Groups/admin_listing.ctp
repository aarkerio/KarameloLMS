<?php 
 $this->Html->addCrumb('Control Panel', '/admin/entries/listing');
 $this->Html->addCrumb(__('Users'), '/admin/users/listing');
 echo $this->Html->getCrumbs(' > '); 

 echo $this->Html->div('title_section', __('Groups'));
 echo '<table class="main_tabula">';

 $th = array(__('Edit'), __('Title'), __('Code'), __('Status'));

 echo $this->Html->tableHeaders($th, array('style'=>'text-align:center')); 

 foreach ($data as $val):
  $st = ($val['Group']['active'] == 1) ? __('Enabled') : __('Disabled');
  $tr = array (
	       $this->Gags->sendEdit($val['Group']['id'], 'groups'),
	       $val['Group']['name'],
               $val['Group']['code'],
	       $st
         );
         
  echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
 endforeach;

 echo '</table>';

 # ? >  EOF
