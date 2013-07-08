<div class="title_section">Topics on Forum <?php echo $data['Forum']['title']; ?></div>

<script type="text/javascript"> 
<!-- 
function hU() {

var tr = document.getElementById('trh');

  if (tr.style.display == 'none')
  {
            tr.style.display = 'table-row';
  } 
  else  //hide
  {
            tr.style.display = 'none';
  }
}
-->
</script>
<?php
foreach ($data['Topic'] as $val)
 {
   $message = substr($val['message'], 0, 40) . '...';
   
   $st =  ($val['status'] == 1 ) ? 'Published' : 'Hidden';
   $t  =  $this->Html->link($val['subject'], '/admin/topics/listing/'.$val['id'], array('title'=>'View discussions'))  . '<br />';
   $t .=  $message               . '<br />';
   $t .=  'Status: ' .   $this->Html->link($st, '/admin/topics/change/'.$val['id'].'/'.$val['status'].'/'.$val['forum_id'], array('title'=>'Change status'))      . '<br />';
   $t .=  $val['created']         . '<br />';
   
   echo $this->Html->div('adminblock', $t);
 }
?>
