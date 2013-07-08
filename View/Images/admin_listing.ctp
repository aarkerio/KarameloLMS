<?php
# check first if php5-gd libs exists
if ( !extension_loaded('gd') ):
  echo $this->Html->div('message');
      echo __('It looks like PHP5 GD library is not installed, so this section is not gone to work') . '<br />';
      echo 'If you are in Debian/Ubuntu try: <br /><b>$sudo apt-get install php5-gd</b>';
  echo '</div>';
endif;

# popup or full window ?
if ( !isset($set) ):
    $this->Html->addCrumb('Control Panel', '/admin/entries/start');
    echo $this->Html->getCrumbs(' > ');
    echo $this->Html->div('title_section', $this->Html->image('myimages.png', array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Images'), 'title'=>__('Images'))).' '.__('Images'));
    $return = '';
else:
    $return = 'set';
endif;
?>
<table style="width:100%;border-collapse:collapse;margin:0 auto;">
<tr><td style="text-align:left;" colspan="5">
<?php
echo $this->Form->create('Image', array('enctype' => 'multipart/form-data','action'=>'add'));
echo $this->Form->input('Image.return', array('type'=>'hidden','value'=>'/admin/images/listing/'.$return));
if ( isset($ck) ): #ckeditor
    echo $this->Form->hidden('Image.ckeditor', array('value' => $ck));
endif; 
echo '<fieldset><legend>'. __('Upload Image').'</legend>';
echo $this->Form->input('Image.file', array('type'=>'file', 'label'=>__('File')));
echo '</fieldset>';
echo $this->Form->end(__('Upload'), array('class'=>'btn-unplugged-2'));
?>
</td>
</tr>
<?php

if ( count($data) < 1 ): # no images
   echo '</table><h1>'.__('No images yet') .'</h1>';
else:

$counter = (int) 0; # five images in one row
$msg     = __('Are you sure? This is an irreversible operation');
foreach ($data as $val):
    $counter++;
    $image_stats = getimagesize('img/imgusers/'.$val['Image']['file']);
    if ( $counter == 1 ):   # open new row
        echo '<tr>';
    endif;
    ?>
    <td style="text-align:center;padding:3px;vertical-align:top;">
    <div class="listImage">
    <span style="font-size:8px;">
    <?php     
    #If the request is from ckeditor
    if ( isset($ck) ):
        echo $this->Html->link('/img/imgusers/'.$val['Image']['file'], '#', array('onclick'=>'selectedImage('.$val['Image']['id'].')', 'id'=>$val['Image']['id'])); 
         echo '</span><br /><br />'; 
    else: 
        echo $this->Html->link('/img/imgusers/'.$val['Image']['file'], '/img/imgusers/'.$val['Image']['file']); 
        echo '</span><br /><br />';
    endif; 
    $tooltip = $val['Image']['file'] . '   W:'.$image_stats[0].' H:'.$image_stats[1];

    #If the request is from ckeditor
    if (isset($ck)):
        echo $this->Html->link($this->Html->image('imgusers/thumbs/'.$val['Image']['file'], array('alt'=>$tooltip, 'title'=>$tooltip)), '#', array('onclick' => 'selectedImage('.$val['Image']['id'].')', 'id'=>$val['Image']['id'], 'escape'=>False)); 
    else:
        echo $this->Html->link($this->Html->image('imgusers/thumbs/'.$val['Image']['file'], array('alt'=>$tooltip, 'title'=>$tooltip)), '/img/imgusers/'.$val['Image']['file'],array('escape'=>False));
    endif;
 echo '<br />';
 if ( $this->Session->read('Auth.User.id') == $val['Image']['user_id'] ): # user is owner image
        echo  $this->Form->create('Image', array('action'=>'delete', 'onsubmit'=>"return confirm('$msg')"));
        echo  $this->Form->hidden('Image.return', array('value'=>'/admin/images/listing/'.$return)); 
        echo  $this->Form->hidden('Image.id', array('value' => $val['Image']['id']));

	    if (isset($ck)):
            echo $this->Form->hidden('Image.ckeditor', array('value' => $ck));
	    endif;
echo  $this->Form->end(__('Delete'), array('class'=>'btn-unplugged-2'));
 endif;
?>
</div></td>
<?php 
    if ( $counter == 5 ):
        echo'</tr>';
        $counter = (int) 0; #reset counter
    endif;
 endforeach;
    
 if ( $counter < 5 ):
	   $colspan = (5 - $counter);
	   echo '<td colspan="'.$colspan.'">&nbsp;</td></tr>';  # fill the row with column(s)	  
  endif;
?> 
</table>
<?php

$pages_num = $this->Paginator->counter(array('format'=>'%pages%'));
if ( $pages_num > 1 ):

$t  = $this->Html->div(Null,$this->Paginator->prev('«'. __('Previous').' ',Null,Null,array('class'=>'disabled')),array('style'=>'width:100px;float:left'));
$t .= $this->Html->div(Null,$this->Paginator->next(' '.__('Next').' »', Null, Null, array('class' => 'disabled')),array('style'=>'width:100px;float:right'));
$t .= $this->Html->div(Null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
echo  $this->Html->div(Null,$t, array('style'=>'font-size:9pt;width:400px;margin:15px auto;'));

endif;

endif; #End if the count of $data > 1
?>
<script type="text/javascript">


 function selectedImage(image)
 {
    var image = document.getElementById(image).innerHTML
    var funcNum = getUrlParam('CKEditorFuncNum');
    var fileUrl = image;
    window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);    
    //self.close();
  }

/*http://docs.cksource.com/CKEditor_3.x/Developers_Guide/File_Browser_(Uploader)/Custom_File_Browser*/
 function getUrlParam(paramName)
 {
  var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
  var match = window.location.search.match(reParam) ;
 
  return (match && match.length > 1) ? match[1] : '' ;
 }


</script>
