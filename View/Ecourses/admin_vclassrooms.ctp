<?php
#die(debug($data));
$this->Html->addCrumb('Control Panel', '/admin/entries/start');
$this->Html->addCrumb('eCourses', '/admin/ecourses/listing'); 
echo $this->Html->getCrumbs(' > '); 

$str = (string) __('vClassrooms on') .': '. $data['Ecourse']['title'];

if ( isset( $historic ) ):
   $str .= ' (filed)';
endif;

echo $this->Html->div('title_section', $str);

if ( count($data['Vclassroom']) < 1 ):
    echo $this->Html->div('notice', __('No vClassrooms yet'));
    $img = 'admin/vgroups-gray.gif'; 
else:
    $img = 'static/vgroups.gif';   
endif;

echo  $this->Html->para(Null, $this->Html->link($this->Html->image($img, array('alt'=>__('Add new'), 'title'=>__('Add new'))),  '/admin/vclassrooms/edit/'.$data['Ecourse']['id'], array('escape'=>False)));

$msg   = __('Are you sure to want to delete this?'); 

foreach ($data['Vclassroom'] as $val):
   if ($val['status'] == 1):
         $img   = 'static/status_1_icon.png';
         $st    = __('Published');
   else:
         $img   = 'static/status_0_icon.png';
         $st    = __('Draft');
         $order = $st;
   endif;

   echo $this->Html->div('grayblock');
      echo $this->Html->link($val['name'], '/admin/vclassrooms/members/'.$val['id']);
      echo $this->Html->div(null,$this->Html->image('static/icon_password.gif', (array('alt'=>'Secret:'. $val['secret'],'title'=>'Secret:'.$val['secret']))));

      echo $this->Html->div('buton');
      echo $this->Html->link($this->Html->image($img,array('alt'=>$st, 'title'=>$st)),
                     '/admin/vclassrooms/change/'.$val['id'].'/'.$val['status'].'/'.$val['ecourse_id'],  array('escape'=>False));
      echo '&nbsp;&nbsp;';
      echo $this->Html->link($this->Html->image('static/delete_icon.png', array('title'=>__('Delete'), 'alt'=>__('Delete'))),
                        '/admin/vclassrooms/delete/'.$val['id'].'/'.$val['ecourse_id'], array('onclick'=>"return confirm('".$msg."')", 'escape'=>False)) .'&nbsp;&nbsp;&nbsp;';
      echo  $this->Html->link($this->Html->image('static/edit_icon.gif', array('alt'=>__('Edit'), 'title'=>__('Edit'))), 
            '/admin/vclassrooms/edit/'.$val['ecourse_id'].'/'.$val['id'], array('escape'=>False));
      echo '</div>';
  echo '</div>';
endforeach;

/* if ( !isset( $historic ) ):
echo $this->Html->link(
                $this->Html->image('admin/historic.png', array('alt'=>__('Filed classrooms'), 'title'=>__('Filed classrooms'))), 
                '/admin/ecourses/vclassrooms/'.$data['Ecourse']['id'].'/historic', null, null, false);
endif; */

#  ? > EOF
