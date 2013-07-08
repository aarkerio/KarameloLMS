<?php 
#die(debug($data));
$this->set('title_for_layout', __('Glossaries'));

$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb(__('Glossaries'), '/admin/catglossaries/listing'); 
echo $this->Html->getCrumbs(' > ');
echo $this->Html->div('title_section', $data['Catglossary']['title']);

if ( count($data['Glossary']) < 1):
    echo $this->Html->para(null, '<b>'.__('No items yet').'</b>');
endif;
echo $this->Gags->imgLoad('loading');
echo  $this->Js->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))), 
          '/admin/glossaries/new/'.$data['Catglossary']['id'], 
 	                   array('update'      => '#updater',
                             'evalScripts' => True,
                             'before'      => $this->Gags->ajaxBefore('updater'),
                             'complete'    => $this->Gags->ajaxComplete('updater'),
                             'escape'      => False ));
echo $this->Gags->ajaxDiv('updater') . $this->Gags->divEnd('updater');

$order_show = (int) 0;
$num        = (int) count($data['Glossary']);
$msg        = __('Are you sure to want to delete this?');

foreach ($data['Glossary'] as $val):
    $order_show++;

    if ($val['status'] == 1):
        $img   = 'static/status_1_icon.png';
        $st    = __('Published');
        $order = $order_show;
    else:
        $img   = 'static/status_0_icon.png';
        $st    = __('Draft');
        $order = $order_show .' ('.$st.')';
    endif;

    echo $this->Html->div('grayblock', null, array('id'=>'dv'.$val['id']));
    echo $this->Html->para(null,  $order.'.- '.$val['item'], array('style'=>'font-weight:bold;'));
    echo $this->Html->div('dvtop');      
    echo $this->Html->link($this->Html->image('static/edit_icon.gif', array('width'=>'14px', 'alt'=>__('Edit'), 'title'=>__('Edit'))), 
                           '/admin/glossaries/edit/'.$val['id'], array('escape'=>False)) . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
                 '/admin/glossaries/change/'.$val['id'].'/'.$val['catglossary_id'].'/'.$val['status'], array('escape'=>False)) . 
                 ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    echo $this->Html->link($this->Html->image('static/delete_icon.png', array('width'=>'16px', 'alt'=>__('Delete'), 'title'=>__('Delete'))), 
                       '/admin/glossaries/delete/'.$val['id'].'/'.$val['catglossary_id'], 
                  array('onclick'=>"return confirm('".$msg."')", 'escape'=>False)). '   &nbsp;&nbsp;&nbsp;';
    if ($order_show != 1 && $num > 1):
        echo $this->Html->link(
                   $this->Html->image('static/arrow_up_icon.png', array('width'=>'11px', 'alt'=>__('Up'), 'title'=>__('Up'))), 
                   '/admin/glossaries/order/up/'.$val['id'].'/'. $val['display'].'/'.$val['catglossary_id'], array('escape'=>False)) . ' ';
   endif;
   # only if not is the last row
   if ($order_show != $num && $num >1 ):
       echo $this->Html->link(
                   $this->Html->image('static/arrow_down_icon.png', 
                    array('width'=>'11px', 'alt'=>__('Down'), 'title'=>__('Down'))), 
                   '/admin/glossaries/order/down/'.$val['id'].'/'. $val['display'].'/'.$val['catglossary_id'], array('escape'=>False));
   endif; 
   echo '</div>';  
   echo $this->Html->para(null,  nl2br($val['definition'])); 
   echo '</div>';
endforeach;

# ? > EOF
