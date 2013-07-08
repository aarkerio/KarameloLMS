<?php
echo $this->set('title_for_layout', __('Activities'));

echo $this->Html->script('ckeditor/ckeditor'); 
#debug($data);
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb('eCourses', '/admin/ecourses/listing'); 
echo $this->Html->getCrumbs(' > '); 

$str = __('Activities on') .': '. $data['Ecourse']['title'];

echo $this->Html->div(null, $this->Html->link($this->Html->image('static/icon-gcalendar.png', array('alt'=>'gCalendar', 'title'=>'gCalendar', 'onmouseover'=>"Tip('Publish activities in Google calendar')", 'onmouseout'=>"UnTip()")), '#', array('onclick'=>"window.open('http://www.google.com/calendar/render', '_blank','toolbar=no, scrollbars=yes,width=800,height=800'); return false;", 'escape'=>False)), array('style'=>'width:50px;float:right;margin:15px;'));

#echo  $this->Html->link('gCalendar', $gcalendar->getAuthSubUrl());
$hours = number_format($data['Ecourse']['hours'], 2, '.', ' ');
echo $this->Html->div('title_section', $str.' <span class="main-item-caption">('.$data['Ecourse']['points'].' '.__('Points').')('.$hours.' '.__('Hours').')</span>');

echo $this->Js->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))),
	         '/admin/ecourses/newactivity/'.$data['Ecourse']['id'],
                       array('update'      => '#addform',
	                         'evalScripts' => True,
                             'before'      => $this->Gags->ajaxBefore('addform'),
                             'complete'    => $this->Gags->ajaxComplete('addform'),
                             'escape'      => False));

echo $this->Gags->imgLoad('loading');

echo $this->Gags->ajaxDiv('addform', array('style'=>'padding:0')) . $this->Gags->divEnd('addform');

if ( count($data['Activity']) < 1 ):
    echo $this->Html->div('notice', __('No activities yet'));
endif;

$loop       = (int) 0;                        # just loop
$order_show = (int) 0;                        # show activity number only++ if activity have status=1
$num        = (int) count($data['Activity']); # count activities
$msg   = __('Are you sure to want to delete this?');
echo '<table id="mtable" class="tbadmin">';
$th = array(  __('Title'), __('Edit'), __('Points'),  __('Minutes'), __('Status'), __('Delete'),  __('Order'),);
echo $this->Html->tableHeaders($th);

foreach($data['Activity'] as $v):
   $loop++;
  
   if ($v['status'] == 1):
       $order_show++;
       $img   = 'static/status_1_icon.png';
       $st    = __('Published');
       $order = $order_show;
   else:
       $img   = 'static/status_0_icon.png';
       $st    = __('Draft');
       $order = $st;
   endif;

   $tr = array('<h2>'.$order .'.- '.__('Activity').':  <i>'. $v['title'] . '</i></h2>',
             $this->Html->link($this->Html->image('static/edit_icon.gif', array('width'=>'14px', 
                        'alt'=>__('Edit'), 'title'=>__('Edit'))), '/admin/ecourses/edactivity/'.$v['id'], array('escape'=>False)),
             $v['points'],
             $v['minutes'],
             $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
                         '/admin/ecourses/changeactivity/'.$v['id'].'/'.$v['ecourse_id'].'/'.$v['status'], array('escape'=>False)),
            $this->Html->link($this->Html->image('static/delete_icon.png', array('width'=>'16px', 'alt'=>__('Delete'), 
                          'title'=>__('Delete'))), '/admin/ecourses/delactivity/'.$v['id'].'/'.$v['ecourse_id'],
                              array('onclick'=>"return confirm('".$msg."')", 'escape'=>False))
             );

   $tmp= (string) '';
           if ($loop != 1 && $num > 1): 
               $tmp .= $this->Html->link($this->Html->image('static/arrow_up_icon.png',array('width'=>'11px','alt'=>__('Up'),'title'=>__('Up'))),
                                   '/admin/ecourses/order/up/'.$v['id'].'/'. $v['order'].'/'.$v['ecourse_id'], array('escape'=>False)) .'&nbsp;&nbsp;';
           endif;
           # only if not is the last row
           if ($loop != $num && $num >1 ):
               $tmp .= $this->Html->link($this->Html->image('static/arrow_down_icon.png', array('width'=>'11px', 'alt'=>__('Down'), 
               'title'=>__('Down'))), '/admin/ecourses/order/down/'.$v['id'].'/'. $v['order'].'/'.$v['ecourse_id'], array('escape'=>False));
           endif; 
      array_push($tr, $tmp);
      echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;
echo '</table>';
# ? > EOF