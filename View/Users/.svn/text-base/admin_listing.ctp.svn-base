<?php 
#die(debug($_SERVER));
$this->Html->addCrumb('Control Panel', '/admin/entries/listing');  
echo $this->Html->getCrumbs(' > '); 
  
echo $this->Html->div('title_section', $this->Html->image('karamelo_users.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Users'), 'title'=>__('Users'))).' '.__('Users'));
echo $this->Html->para(Null, 
       $this->Html->link(
            $this->Html->image('static/icon_groups.jpg', array('alt'=>__('Groups'), 'title'=>__('Groups'))), 
            '/admin/groups/listing',  array('onmouseover'=>"Tip('".__('Admin groups')."')", 'onmouseout'=>"UnTip()",'escape'=>False)) .' '.
       $this->Html->link(
              $this->Html->image('static/search_blog.gif', array('alt'=>__('Search'), 'title'=>__('Search'))), 
             '/admin/users/search',  array('onmouseover'=>"Tip('".__('Search for user')."')", 'onmouseout'=>"UnTip()", 'escape'=>False)).' '.
       $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'))), 
             '/admin/users/add', array('onmouseover'=>"Tip('".__('Add new user')."')",'onmouseout'=>"UnTip()",'escape'=>False)). ' '.
       $this->Html->link($this->Html->image('admin/icon_allusers.png', array('alt'=>__('Also show disabled users'), 'title'=>__('Also show disabled users'))), 
             '/admin/users/listing/all', array('onmouseover'=>"Tip('".__('Also show disabled users')."')",'onmouseout'=>"UnTip()",'escape'=>False)). ' '.
       $this->Html->link(
            $this->Html->image('admin/icon_multiple_reg.gif', array('alt'=>__('Multiregister'), 'title'=>__('Multiregister'))), 
             '/admin/users/record',  array('onmouseover'=>"Tip('".__('Register many users in one simple step')."')", 
                                          'onmouseout'=>"UnTip()", 'escape'=>False)) 
        );

$msg   = __('Are you sure to want to delete this?');
echo '<table class="main_tabula">';
$th = array(__('Edit'), 
            $this->Paginator->sort('username', 'Username'),
            $this->Paginator->sort('name', __('Name')), 
            $this->Paginator->sort('Profile.created', __('Created')),
            $this->Paginator->sort('email', 'Email'), 
            __('Status'), 
            __('Compose'), 
            $this->Paginator->sort('group_id', __('Group')), 
            __('Delete'));

echo $this->Html->tableHeaders($th, array('style'=>'background-color:#e0e0e0;font-size:9pt;')); 
 
foreach ($data as $val):
     if ($val['User']['active'] == 1):
         $img   = 'static/status_1_icon.png';
         $st    = __('Enabled');
     else:
         $img   = 'static/status_0_icon.png';
         $st    = __('Disabled');
    endif;
    $del = $this->Session->read('Auth.User.group_id')  == 1 ? $this->Html->link($this->Html->image('static/delete_icon.png', 
                              array('alt'=>__('Delete'),'width'=>'16px', 'title'=>__('Delete'))), '/admin/users/delete/'.$val['User']['id'],array('escape'=>False), $msg) : ''; # only admins can delete
    if ( $val['User']['id'] == 1 || $val['User']['id'] == 2):
         $del = ''; # user 1 and 2 can not be deleted
    endif;
$edit= $this->Session->read('Auth.User.group_id') == 1 ? $this->Html->link($this->Html->image('static/edit_icon.gif', array('alt'=>__('Edit'), 'title'=>__('Edit'))), '/admin/users/add/'.$val['User']['id'], array('escape'=>False)) : '';
    $status = ($val['User']['active'] == 1) ? __('Actived') : __('Desactived');
     
    $tr = array (
		  $edit,
		  $val['User']['username'],
          $val['User']['name'],
          $val['Profile']['created'],
          $this->Html->link($val['User']['email'],  'mailto:'.$val['User']['email']),
          $this->Html->link($this->Html->image($img, array('alt'=>$st, 'title'=>$st)), '/admin/users/change/'.$val['User']['id'].'/'.$val['User']['active'], array('escape'=>False)),
          $this->Html->link($this->Html->image('admin/compose_on.gif', array('alt'=>__('Compose'), 'title'=>__('Compose'))), 
                              '/admin/messages/add/'. $val['User']['username'], array('escape'=>False)),
          $val['Group']['name'],
		  $del
		 );       
    echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
endforeach;
echo '</table>';

$t  = $this->Html->div(null,$this->Paginator->prev('«'. __('Previous').' ',null,null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
$t .= $this->Html->div(null, $this->Paginator->next(' '.__('Next').' »', null, null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
$t .= $this->Html->div(null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
echo  $this->Html->div(null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));

# ? > EOF 