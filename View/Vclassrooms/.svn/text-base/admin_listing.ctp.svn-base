<?php
/**
 *  Chipotle Software (c) 2006-2012
 *  @license GPLv3
 */
#die(debug($data));
$this->set('title_for_layout',  __('vClassrooms'));

$this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
echo $this->Html->getCrumbs(' > '); 

echo $this->Html->div('title_section', $this->Html->image('static/icon_group.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('vClassrooms'), 'title'=>__('vClassrooms'))).' '.__('vClassrooms'));

echo $this->Html->link($this->Html->image('actions/new.png',array('alt'=>__('Add new'),'title'=>__('Add new'))),'/admin/ecourses/listing',array('escape'=>False)) .'&nbsp;&nbsp;'; 

echo '<table class="tbadmin">';

if ( $data ):
    $th = array(__('Edit'), 'vClassroom', 'Status', __('Share'), __('Secret'), __('Students'), __('See vClassroom'));
    echo $this->Html->tableHeaders($th, array('style'=>'text-align:left;'));
endif;

foreach ($data as $val):
  if ( $val['Vclassroom']['status'] == 1 ):
      $img   = 'static/status_1_icon.png';
      $st    = __('Published');
  else:
      $img   = 'static/status_0_icon.png';
      $st    = __('Draft');
  endif;
  if ( $val['UserVclassroom']['kind'] == 1 ):  #owner of this classroom
      $t = $this->Gags->sendEdit($val['Vclassroom']['ecourse_id'].'/'.$val['Vclassroom']['id'], 'vclassrooms');
      $s =  $this->Html->link($this->Html->image('static/icon_share.gif', array('alt'=>__('Share'), 'title'=>__('Share'))), 
                                     '/admin/vclassrooms/share/'.$val['Vclassroom']['id'], array('escape'=>False));
  else:
      $alt = $val['User']['username'] . ' '.__('Classroom')  .': '. __('You are tutor');
      $t  = $this->Html->image('static/birrete.gif', array('title'=> $alt, 'alt'=>$alt));
      $s  = ' ';  
  endif;
  $tr = array (
        $t,
        $this->Html->link($val['Vclassroom']['name'], '/admin/vclassrooms/members/'.$val['Vclassroom']['id']) . ' <span class="petit">'.$val['Ecourse']['title'].'</span>',
        $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
                    '/admin/vclassrooms/change/'.$val['Vclassroom']['id'].'/'.$val['Vclassroom']['status'].'/'.$val['Vclassroom']['ecourse_id'].'/1', array('escape'=>False)),
        $s,
        $this->Html->image('static/icon_password.gif', array('alt'=>$val['Vclassroom']['secret'], 'title'=>$val['Vclassroom']['secret'])),
        $val['Vclassroom']['students'],
        $this->Html->link($this->Html->image('static/icon_group.png',array('width'=>22, 'alt'=>__('See vClassroom'),'title'=>__('See vClassroom'))), 
                          '/vclassrooms/show/'.$val['User']['username'].'/'.$val['Vclassroom']['id'], array('target'=>'_blank', 'escape'=>False))); 
   echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;

echo '</table> ';

/* if (!$historic):
        echo $this->Html->para(null,$this->Html->link($this->Html->image('admin/historic.png', array('alt'=>__('Archived vClassrooms'),
       'title'=>__('Archived vClassrooms'))), '/admin/vclassrooms/listing/historic', array('escape'=>False))); 
   endif; */
# ? > EOF
