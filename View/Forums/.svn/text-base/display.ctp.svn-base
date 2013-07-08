<?php
$this->set('title_for_layout', $data['Forum']['description']);

echo $this->Html->script(array('jquery-validate/jquery.validate'), False);

#die(debug($blogger));

if ( $belongs === True ):
    echo $this->element('vccrumb', array('blogger'=> $blogger['User']['username'], 'vclassroom_id'=>$data['Forum']['vclassroom_id']));
    echo $this->Html->div(Null, __('Category').': ' . $data['Catforum']['title'], array('style'=>'font-weight:bold;'));

    echo  $this->Html->div('titentry', $data['Forum']['title']);
    echo  $this->Html->para(Null, $data['Forum']['description']);

    $tmp = $this->Js->link($this->Html->image('static/new_post.gif', array('alt'=>__('New topic'), 'title'=>__('New topic'))), 
             '/topics/add/'.$data['Forum']['vclassroom_id'].'/'.$data['Forum']['id'].'/'.$blogger['User']['id'],
			                    array('update'      => '#qn',
                                      'evalScripts' => True,
                                      'before'      => $this->Gags->ajaxBefore('qn'),
                                      'complete'    => $this->Gags->ajaxComplete('qn'),
                                      'escape'      => False));
  
 $tmp .= $this->Gags->imgLoad('loading');
 $tmp .= $this->Gags->ajaxDiv('qn', array('style'=>'padding:3px')) . $this->Gags->divEnd('qn');
 echo $this->Html->div(null, $tmp);
  
 #Topics
 echo '<table style="border-collapse:collapse;width:100%">';
 if ( count($data['Topic']) == 0):
     echo '<tr><td colspan="6"><br /><h4>'.__('There is not topic on this forum yet').'</h4></td></tr>';
 else:
     $th = array(__('Read'), __('Topics'), __('Replies'), __('Author'), __('Views'), __('Last Post'));
     if ( $blogger['User']['id'] == $this->Session->read('Auth.User.id')):
         array_push($th,  __('Delete'));
    endif;
    echo $this->Html->tableHeaders($th, array('style'=>'text-align:left'));
 endif;
 #die(print_r($data['Topic']));
            
 foreach ($data['Topic'] as $val):       
     $tr = array (
         $this->Html->image('static/folder.gif'),
         $this->Html->link($val['subject'], '/topics/display/'.$blogger['User']['username'].'/'.$val['forum_id'].'/'.$val['id']),
                   count($val['Reply']),
                   $val['User']['username'],
                   count($val['Visitor']),
                   '<span style="font-size:6pt">'.$this->Time->timeAgoInWords($val['created']) .'</span>'
                );
     if ( $blogger['User']['id'] == $this->Session->read('Auth.User.id')): # delete button
         $msg   = __('Are you sure to want to delete this?'); 
         $img = $this->Html->link($this->Html->image('static/delete_icon.png', array('width'=>'16px', 'alt'=>__('Delete'), 
                          'title'=>__('Delete'))), 
                          '/admin/topics/delete/'.$val['id'].'/'.$data['Forum']['vclassroom_id'].'/'.$val['forum_id'].'/'.$blogger['User']['username'],
                           array('onclick'=>"return confirm('".$msg."')", 'escape'=>False));
            array_push($tr,  $img);
        endif;
        echo $this->Html->tableCells($tr, array('style'=>'border:1px solid gray;padding:6px;background-color:#e8f6fe'), 
                                array('style'=>'border:1px solid gray;padding:6px;background-color:#c0c0c0'));
    endforeach;
    echo '</table><br /><br /><br /><br />'; 
  
    #echo $this->Html->para(Null, __('Legend').':');

    #$tmp  = $this->Html->image('static/board.gif', array('alt'=>'Tema normal', 'title'=>'Tema normal')) . ' Tema normal <br />';
    #$tmp .= $this->Html->image('static/locked.gif', array('alt'=>'Tema bloqueado', 'title'=>'Tema bloqueado')) . ' Tema bloqueado<br />';
    #$tmp .= $this->Html->image('static/new.gif', array('alt'=>'Comentario nuevo', 'title'=>'Comentario nuevo')). ' Comentario nuevo<br />';

    #echo $this->Html->para(Null, $tmp);
else:
    echo $this->Html->para(Null, __('You must be logged in and belongs to this class to see this section'));
endif;
echo $this->Html->scriptStart();
?>

function chkForm()
{ 
 var subject  = document.getElementById('TopicSubject');
 var mess     = document.getElementById('TopicMessage');


 if (subject.value.length < 3)
 {
      alert('<?php __('Minimum 3 characters long');?>');
      subject.focus();
      return false;

 }
 if (mess.value.length < 5)
 {
      alert('<?php __('Minimum 5 characters long');?>');
      mess.focus();
      return false;
 }
 return true;
}
<?php
echo $this->Html->scriptEnd();
# ? > EOF 
