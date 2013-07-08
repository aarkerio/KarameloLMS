<?php
$this->set('title_for_layout',  __('Quotes'));
$helps = $this->Session->read('Auth.User.helps'); # helps enabled
#Paginator options for ajax
$this->Paginator->options(array(
                                'url'=>array('controller'=>'quotes', 'action'=>'admin_listing'),
                                'update'      => '#list',
                                'evalScripts' => True,
                                'before'      => $this->Js->get('#loading')->effect('fadeIn',  array('buffer' => False)),
                                'complete'    => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => False))
                              )); 
if (isset($this->Js)):
    echo $this->Html->script('jquery-validate/jquery.validate');
endif;

if ( !isset($ajaxTrue) ):
    $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
    echo $this->Html->getCrumbs(' > '); 
    echo $this->Html->div('title_section', $this->Html->image('quotes.png', array('style'=>'width:35px;margin-right:6px;','alt'=>__('Quotes'), 'title'=>__('Quotes'))).' '.__('Quotes'));
endif;
echo $this->Gags->imgLoad('loading');
echo $this->Gags->ajaxDiv('list'); #Ajax list div 
echo $this->Session->flash();

echo $this->Html->para(Null, $this->Html->link($this->Html->image('actions/new.png',array('alt'=>__('Add new'),'title'=>__('Add new'), 'onmouseover'=>'Tip("'.__('Add new quote').'")', 'onmouseout' => 'UnTip()')), '#', array('onclick'=>'hU()', 'escape'=>False)));
 
if (isset($show)): 
    echo "<div id=\"trh\" style=\"margin:0;padding:0;padding-left:40px;width:80%;display:block;\">";  
else: 
    echo "<div id=\"trh\" style=\"margin:0;padding:0;padding-left:40px;width:80%;display:none;\">";  
endif; 

echo $this->Form->create('Quote', array('action'=>'add')); 
?>
<fieldset>
<legend><?php __('New quote'); ?></legend>
<?php 
  echo $this->Form->input('Quote.quote', array('size'=> 60, 'maxlength'=>130));
  echo $this->Form->input('Quote.author', array('size' => 60, 'maxlength'=>130)); 
  echo $this->Js->submit(__('Save'), 
                array(
                      # 'url'      => array('controller'=>'quotes', 'action'=>'admin_add'), 
                      'update'   => '#list', 
                      'before'   => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => False)).
                                    $this->Js->get('#list')->effect('fadeOut', array('buffer' => False)), 
                      'complete' => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => False)).
                                    $this->Js->get('#list')->effect('fadeIn', array('buffer' => False))));
  echo '</fieldset>';
  echo $this->Form->end(); 
?>
</div>
<table style="width:100%">
<?php
#Table headers
if ($data):
     $th = array (__('Edit'), 
          $this->Paginator->sort('Quote.quote', __('Quote'),
                array('onmouseover' => "Tip('".__('Sort your quotes by alphabetical order')."')",         
                      'onmouseout'  => 'UnTip()', 
                      'update'      => '#list', 
                      'before'      => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => False)).
                                       $this->Js->get('#list')->effect('fadeOut', array('buffer' => False)), 
                      'complete'    => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => False)).
                                       $this->Js->get('#list')->effect('fadeIn', array('buffer' => False)))),
 
          $this->Paginator->sort('Quote.author', __('Author'),
                array('onmouseover'=> "Tip('".__('Sort your quotes by author')."')",         
                      'onmouseout' =>'UnTip()', 
                      'update'     => '#list', 
                      'before'     => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => False)).
                                       $this->Js->get('#list')->effect('fadeOut', array('buffer' => False)), 
                      'complete'   => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => False)).
                                       $this->Js->get('#list')->effect('fadeIn', array('buffer' => False)))), 
            __('Delete'));
    #End of table headers
    echo $this->Html->tableHeaders($th, array('style'=>'text-align:left'));
endif;
foreach ($data as $val):
    $tr = array (
        $this->Gags->sendEdit($val['Quote']['id'], 'quotes'),
        $val['Quote']['quote'],
        $val['Quote']['author'],
        $this->Gags->confirmDel($val['Quote']['id'], 'quotes')
        );
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;
?> 
</table>
<?php

echo $this->Html->div('pagination');

$pages_num = $this->Paginator->counter(array('format'=>'%pages%'));
if ( $pages_num > 1 ):
    #Paginator options for ajax



$t  = $this->Html->div(null,$this->Paginator->prev('«'. __('Previous').' ',null,null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
$t .= $this->Html->div(null, $this->Paginator->next(' '.__('Next').' »', null, null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
$t .= $this->Html->div(null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));

echo  $this->Html->div(null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));
   endif;
echo '</div>'; #End of pagination div

echo $this->Gags->divEnd('list'); #End Ajax list div

echo $this->Html->scriptStart(); 
?>
   jQuery(document).ready(function() {
               jQuery("#QuoteAddForm").validate();
   });

function hU() 
{

var tr = document.getElementById('trh');

  if (tr.style.display == 'none')
  {
            tr.style.display = 'block';
  } else {
            tr.style.display = 'none';
  }
}
<?php echo $this->Html->scriptEnd(); ?>
