<?php
 $new_resolution = 'resolution_'.$qdiv;
 echo $this->Gags->ajaxDiv($new_resolution);           
      
 $lbl = __('View answers').'   ('.$resolutions.')';
 echo $this->Form->create($new_resolution);
 echo $this->Form->input('Inquiry.inquiry_id', array('type'=>'hidden', 'value'=>$inquiry_id));
 echo $this->Js->submit($lbl, array(
                'url'      => '/admin/inquiries/answers/',
 	            'update'   => "#$new_resolution",
	            'before'   => $this->Gags->ajaxBefore($new_resolution),
 	            'complete' => $this->Gags->ajaxComplete($new_resolution)
 	        ));
 echo '</form>';

 echo $this->Gags->divEnd($new_resolution); 
  
# ? > EOF

