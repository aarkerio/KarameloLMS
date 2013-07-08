<?php 
 $helps = $this->Session->read('Auth.User.helps'); # helps enabled ?
 if ($this->Session->check('Message.flash')): 
     echo $this->Session->flash(); 
 endif;
 if ( !isset($ajax) ):
     $this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
     $this->Html->addCrumb(__('Quizs'), '/admin/quizs/listing'); 
     echo $this->Html->getCrumbs(' > '); 
     echo $this->Html->div('title_section', __('Quiz')); 

     echo $this->Gags->imgLoad('loading');

     echo '<b>'.__('Title').'</b> ' . $data['Quiz']['title'] . '<br />';
     echo '<b>'.__('Description').'</b> ' . $data['Quiz']['description'];

     echo '  '. count($data['Inquiry']) .' '. __('inquiries');

     echo $this->Html->para(Null,
                   $this->Html->link($this->Html->image('actions/new.png', array('alt'=>__('Add new inquiry'),'title'=>__('Add new inquiry'))), 
                     '#addinquiry',   array('onclick'=>"$('#addinquiry').toggleDiv();", 'escape'=>False))
                           ); 

 if ( count($data['Inquiry']) > 0):
     echo $this->Html->div('title_section',  __('Inquiries'));
 endif;

 echo '<!-- Ajax add inquiry beggin --><div id="addinquiry" style="display:none">';
 echo $this->Form->create();
 echo $this->Form->hidden('Inquiry.quiz_id', array('value'=>$data['Quiz']['id'])); 

 echo '<fieldset><legend>'. __('New inquiry').'</legend>';
 echo $this->Gags->helps('Write the inquiry to student', $helps);
 echo $this->Form->input('Inquiry.inquiry', array('type'=>'textarea', 'cols' => 50, 'rows' => 5, 'class'=>'required', 'label'=>__('Inquiry'))); 
 
 echo $this->Gags->helps('Briefly explain the right resolution to the inquiry in order to give feedback to student, student can see this explanation only after hi/she finished the quiz', $helps);
 echo $this->Form->input('Inquiry.explanation', array('cols' => 50, 'rows' => 3,  'class'=>'required','label'=> __('Explanation'))); 

 echo $this->Gags->helps('Assign a value to inquiry', $helps);
 echo $this->Form->input('Inquiry.worth', array('options'=>range(0,10), 'label' => __('Points'))); 
  
 echo '<div style="clear:both;margin-top:15px;"></div>';
 echo $this->Js->submit(__('Save'), array(
                'url'      => '/admin/inquiries/add',
 	            'update'   => '#inquiries',
	            'before'   => $this->Gags->ajaxBefore('inquiries').$this->Js->get('#addinquiry')->effect('fadeOut',array('buffer' => False)),
 	            'complete' => $this->Gags->ajaxComplete('inquiries').'clear();'
 	        ));
    echo '</fieldset></form>';

    echo $this->Gags->divEnd('addinquiry');  # Ajax addinquiry div ends 
else:
    echo $this->Html->scriptBlock('timedMsg()');
endif;

echo $this->Html->div(Null, Null, array('id'=>'inquiries')); # beggins column in Sortable Ajax

$i = 0;
echo $this->Html->div(Null, '<!--just break -->',array('style'=>'clear:both;'));
$msg       = __('Are you sure to want to delete this?');
$sortable  = __('Drag and drop to reorder this inquiry');
foreach ($data['Inquiry'] as $val):
    $qdiv    = 'inquiries_'.$val['id'];
    $resolutions = count($val['Resolution']);
    $i++;
    echo '<div class="portlet" id="'.$qdiv.'" title="'.$sortable.'">';

    $tmp  = $this->Form->create('InquiryEdit'.$val['id']);
    $tmp .= $this->Form->input('Inquiry.id', array('type'=>'hidden', 'value'=>$val['id']));
    $tmp .= $this->Form->input('Inquiry.quiz_id', array('type'=>'hidden', 'value'=>$val['quiz_id']));
    $tmp .= $this->Js->submit(__('Edit'), array(
                'url'      => '/admin/inquiries/edit/',
 	            'update'   => "#$qdiv",
	            'before'   => $this->Gags->ajaxBefore($qdiv),
 	            'complete' => $this->Gags->ajaxComplete($qdiv)
 	        ));
    $tmp .= '</form>';
    echo $this->Html->div('butonright', $tmp);

    $tmp  = $this->Form->create('Inquiry'.$val['id']);
    $tmp .= $this->Form->input('Inquiry.quiz_id', array('type'=>'hidden', 'value'=>$val['quiz_id'])); 
    $tmp .= $this->Form->input('Inquiry.id',      array('type'=>'hidden', 'value'=>$val['id']));
    $tmp .= $this->Js->submit(__('Delete'), array(
                'url'      => '/admin/inquiries/delete/',
                'confirm'  => $msg,
 	            'update'   => "#inquiries",
	            'before'   => $this->Gags->ajaxBefore($qdiv),
 	            'complete' => $this->Gags->ajaxComplete($qdiv)
 	        ));
    $tmp .= '</form>';
    echo $this->Html->div('butonright', $tmp);

    echo '<b>' . $i          . '.-'   . __('Inquiry') .':</b> '. $val['inquiry']. '<br />';
    echo '<b>'. __('Explanation')       .':</b> '. $val['explanation']    . '<br /><br />';
    echo '<b>'. __('Points')            .':</b> '. $val['worth']          . '<br /><br />';
    echo $this->element('resolutionbutton', array('quiz_id' =>$data['Quiz']['id'],'inquiry_id'=>$val['id'], 'qdiv'=>$qdiv, 'resolutions'=> $resolutions));

    echo  $this->Gags->ajaxDiv($qdiv).$this->Gags->divEnd($qdiv); 
    echo '</div>';
endforeach;

echo $this->Gags->divEnd('inquiries');  # Ajax inquiries div ends 

if ( !isset($ajax) ):
    $this->Js->get('#inquiries');
    $this->Js->sortable(array(
                              'distance'    => 5,
                              'containment' => '#inquiries',
                              'complete'    => '$.post("/admin/inquiries/order", $("#inquiries").sortable("serialize"));'.
"updateInquiries('".$data['Quiz']['id']."');",
                          ));
  echo $this->Html->scriptStart();
?>
  function updateInquiries(quiz_id)
  {
    $.ajax({
        type: "GET",
                url: '/admin/inquiries/listing/'+quiz_id,
                data: "quiz_id=" + quiz_id, // appears as $_GET['id'] @ ur backend side
                success: function(data) {
                $("#inquiries").fadeOut("slow");
                // data is ur summary
                $('#inquiries').html(data);
                $("#inquiries").fadeIn("slow");
            }
        });

}


  function clear() { // clear form
  var  inquiry  = document.getElementById('InquiryInquiry')
  var  explana  = document.getElementById('InquiryExplanation')
  var  selec    = document.getElementById('InquiryWorth')
  selec.value = 0
  // $("#InquiryWorth").val('0');
  inquiry.value = '' 
  explana.value  = ''
  
  return true; 
}
<?php 
    echo $this->Html->scriptEnd();
else:
    echo $this->Js->writeBuffer();
endif;
?>

<style>
#inquiries { width: 100%; float: left; padding-bottom: 10px; }
.portlet { padding:5px;border:1px dotted gray;margin:5px auto;width:80%;float: left;}

</style>
