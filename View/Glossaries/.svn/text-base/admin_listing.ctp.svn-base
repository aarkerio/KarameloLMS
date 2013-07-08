<?php 
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb(__('Glossaries'), '/admin/catglossaries/listing'); 
echo $this->Html->getCrumbs(' / '); 

echo $this->Html->div('control-panel-title', __('Glossaries'));

if ( count($data) > 0):
    echo '<h1>' . $data[0]["Catglossary"]["title"] . '</h1>';
else:
    echo '<p><b>No items yet</b></p>';
endif;

 echo $this->Gags->imgLoad('loading');
echo  $this->Js->link($this->Html->image('actions/new.png', array('alt'=>__('Add new category'), 'title'=>__('Add new category'))), '/admin/glossaries/new/'.$catglossary_id, 
	 array('update'      => '#updater',
           'evalScripts' => True,
           'before'      => $this->Js->get('#loading3')->effect('fadeIn', array('buffer' => False)),
           'complete'    => $this->Js->get('#loading3')->effect('fadeOut', array('buffer' => False)).
                            $this->Js->get('#updater')->effect('fadeIn', array('buffer' => False)),
           'escape'      => False));

echo $this->Gags->ajaxDiv('updater') . $this->Gags->divEnd('updater');

foreach ($data as $val):

   echo '<div style="padding:6px;margin:5px;border:1px dotted gray;">';
	
   echo $this->Gags->sendEdit($val['Glossary']['id'], 'glossaries');
   
   echo '<p style="font-weight:bold;">' . $val['Glossary']['item'] . '</p>';
	echo $this->Html->para(null, $val['Glossary']['definition'], array('style'=>'margin-left:15px;'));

	echo $this->Html->formTag('/admin/glossaries/delete/'.$val['Glossary']['id'].'/'.$catglossary_id, 'post', array("onsubmit"=>"return confirm('Are you sure to delete this item?')")) . $this->Html->submit('Delete') . '</form>';
   
   echo '</div>';
endforeach;

# ? > EOF

