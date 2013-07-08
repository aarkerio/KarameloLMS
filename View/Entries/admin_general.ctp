<?php
# This is the Welcome message
$this->pageTitle = 'Welcome! '. $this->Session->read('Auth.User.username');
echo $this->Html->div('divblock');

echo $this->Html->div(null, $this->Html->image('static/installer_head.jpg', array('alt'=>'Welcome', 'title'=>'Welcome')), array('style'=>"margin:5px auto 25px auto;padding:0;width:560px;border:1px solid black;background-color:#fff;"));
echo $this->Html->div('titulo', __('Welcome new confectioner!'));

echo $this->Html->para(null, __('ftime_1').': <br /><br/> 1) '. __('ftime_2') .' <br />2) '.__('ftime_3'));

echo $this->Html->para(null, __('ftime_4').'.');

echo $this->Html->para(null, __('ftime_5').'.');

echo $this->Html->para(null, __('ftime_6').' '. $this->Html->link(__('adding quotes'), '/admin/quotes/listing').'. '.__('ftime_7').'.');

echo $this->Html->para(null, $this->Html->link(__('Edublog example'), 'http://beta.chipotle-software.com/blog/aarkerio', array('target'=>'_blank')));

echo $this->Html->para(null, __('ftime_8') .' '. $this->Html->link(__('Usefull links'), '/admin/acquaintances/listing').' '.__('ftime_9').'.');

echo $this->Html->para(null, __('ftime_10').'.');

echo $this->Html->para(null, __('ftime_11').'.');

echo $this->Html->div('titulo', 'eCourses');

echo $this->Html->para(null, __('ftime_12').':');
echo '1) '.__('Launch new course') .' '.$this->Html->link(__('Wizard'),'/admin/ecourses/wizard/admin_wzdone',array('target'=>'_blank')) .' '.__('ftime_12b').'.<br /><br />';
echo '2) '.__('ftime_13') .'.<br /><br />';
echo '3) '.__('ftime_14').'.<br /><br />';
echo '4) '.__('ftime_15') .'.<br /><br />';
echo '5) '.__('ftime_16').'.';

echo $this->Html->div('titulo', 'Kandies');
$icon = $this->Html->image('admin/icon_jigsaw.png', array('alt'=>'Kandies', 'title'=>'Kandies'));
echo $this->Html->para(null, __('ftime_17').'. '.$icon);
$icon = $this->Html->image('admin/help.gif', array('alt'=>'help'));
echo $this->Html->para(null, __('ftime_18').'.');

echo $this->Html->para(Null, __('ftime_19').' '.$icon. ' '.__('ftime_20'));

echo $this->Html->para(Null, __('Thanks for using Karamelo!'));

echo '</div>';

# ? > EOF
