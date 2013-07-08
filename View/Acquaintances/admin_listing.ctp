<?php
echo $this->Session->flash();

#Paginator options for ajax
$this->Paginator->options(array(
                                'url'=>array('controller'=>'acquaintances', 'action'=>'admin_listing'),
                                'update'      => '#list',
                                'evalScripts' => True,
                                'before'    =>  $this->Gags->ajaxBefore(),
                                'complete'  =>  $this->Gags->ajaxComplete()
                              ));

if ( $show ): # this is not an ajax call
    $helps = $this->Session->read('Auth.User.helps'); # helps enabled
    if (isset($this->Js)):
        echo $this->Html->script(array('jquery-validate/jquery.validate'));
    endif;
    $this->Html->addCrumb('Control Panel', '/admin/entries/start');
    echo $this->Html->getCrumbs(' > '); 
  
    echo $this->Html->div('title_section', 
         $this->Html->image('ylinks.png',array('style'=>'width:35px;margin-right:6px;','alt'=>__('Usefull links'),'title'=>__('Usefull links')))
         .' '.$this->Session->read('Auth.User.username') . '\'s '.__('Usefull links'));

    # Here beggins the cool stuff
    $alt = __('Add new usefull link');
    echo $this->Html->para(Null, $this->Js->link(
         $this->Html->image('actions/new.png', array('onmouseover'=>"Tip('$alt')", 'onmouseout'=>'UnTip()', 'alt'=>"$alt", 'title'=>"$alt")), 
         '/admin/acquaintances/edit', 
         array('update'      => '#edit',
               'evalScripts' => True,
               'before'      => $this->Gags->ajaxBefore('edit'),
               'complete'    => $this->Gags->ajaxComplete('edit'),
               'escape'      => False
           )));
    echo $this->Gags->imgLoad('loading');
    echo $this->Gags->ajaxDiv('edit', 'edit'). $this->Gags->divEnd('edit');#Ajax div for edit a link
endif;

echo $this->Gags->ajaxDiv('list');

echo '<table class="ajax_table">';

if ($data):
    $order =  $this->Paginator->sort('Acquaintance.name',__('Name'), array('onmouseover' => "Tip('".__('Sort your acquaintances by name')."')",'onmouseout'  => 'UnTip()'));
    # Table headers
    $th = array(__('Edit'),  $order,  'Url', __('Delete'));
    echo $this->Html->tableHeaders($th, array('style'=>'text-align:left;font-size:8pt;'));
    #end of table header
    $a = __('Edit');
endif;

foreach ($data as $val): 
    $edit = $this->Js->link($this->Html->image('static/edit_icon.gif',array('alt'=>"$a",'title'=>"$a", 'width'=>'16px')),
         '/admin/acquaintances/edit/'.$val['Acquaintance']['id'], 
         array('update'      => '#edit',
               'evalScripts' => True,
               'before'      =>  $this->Gags->ajaxBefore('edit'),
               'complete'    =>  $this->Gags->ajaxComplete('edit'),
               'escape'      => False
           ));
    $del = $this->Js->link($this->Html->image('static/delete_icon.png',array('alt'=>"$a",'title'=>"$a", 'width'=>'16px')),
         '/admin/acquaintances/delete/'.$val['Acquaintance']['id'], 
         array('update'      => '#list',
               'confirm'     => __('Are you sure to want to delete this?'),
               'evalScripts' => True,
               'before'      => $this->Gags->ajaxBefore(),
               'complete'    => $this->Gags->ajaxComplete(),
               'escape'      => False
           ));

    $tr = array(
                 $edit,
                 $val['Acquaintance']['name'],
                 $this->Html->link($val['Acquaintance']['url'], $val['Acquaintance']['url']),
                 $del
                 );
    echo $this->Html->tableCells($tr, GagsHelper::$aRow,  GagsHelper::$eRow);
endforeach;
echo '</table>';

#Pagination
if ($data):
    echo $this->Html->div('pagination');
    echo $this->Html->div(Null,$this->Paginator->prev('« '.__('Previous'),Null,Null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
    echo $this->Html->div(Null,$this->Paginator->next(__('Next').' »',Null,Null,array('class'=>'disabled')),array('style'=>'width:100px;float:right'));
    echo $this->Html->div(Null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
    echo $this->Gags->divEnd('pagination');  #End of pagination
endif;
echo $this->Gags->divEnd('list');        #End of Ajax display

if ( !$show ): # ajax loaded
    echo $this->Js->writeBuffer();
endif;


# ? > EOF
