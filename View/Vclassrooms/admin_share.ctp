<?php
 #debug($data); 
 $this->set('title_for_layout',  __('Share'));
 $helps = $this->Session->read('Auth.User.helps'); # helps enabled ?
 $this->Html->addCrumb('Control Panel', '/admin/entries/start');  
 $this->Html->addCrumb('vClassrooms', '/admin/vclassrooms/listing'); 
 echo $this->Html->getCrumbs(' > '); 
 echo $this->Html->div('title_section', __('Share').' vClassroom '. $vc['Vclassroom']['name']);
 
 if ( count($data) < 1 ):
     echo $this->Html->div(null, __('You have not shared this vClassroom with any other teacher.'));  
 endif;

 echo $this->Gags->imgLoad('loading');
 echo $this->Html->div(null, 
          $this->Js->link($this->Html->image('static/icon_share.gif', array('alt'=>__('Share'), 'title'=>__('Share'))),
          '/admin/vclassrooms/teachers/'.$vc['Vclassroom']['id'],
                       array('update'      => '#setform',
                             'evalScripts' => True,
                             'before'      => $this->Gags->ajaxBefore('setform'),
                             'complete'    => $this->Gags->ajaxComplete('setform'),
                             'escape'      => False)));
 # empty ajax div
 echo $this->Gags->ajaxDiv('setform') . $this->Gags->divEnd('setform'); 
 echo $this->Gags->helps('You can share a virtual classroom with other teachers and therefore work together to give the class', $helps);
 echo '<table style="width:400px;margin:0 auto;">';
 $th = array (__('Teacher'), __('Unlink'));
 echo $this->Html->tableHeaders($th);
 foreach ($data as $v):
     $tr = array(
                $v['User']['username'].' ('.$v['User']['name'].') '.$this->Html->image('avatars/'.$v['User']['avatar'], 
                                         array('alt'=>$v['User']['name'],'title'=>$v['User']['name'])),
                $this->Html->link(__('Undo sharing'), '/admin/vclassrooms/unshare/'.$v['UserVclassroom']['id'].'/'. $vc['Vclassroom']['id'])
     ); 
     echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
 endforeach;

 echo '</table>';
 
# ? > EOF
