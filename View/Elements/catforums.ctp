<div style="padding:4px;text-align:center;margin:25px auto">
<?php
//foreach ($Element[0]["Catforum"] as $key => $val) {
  echo $this->Html->link(
	$this->Html->image('static/student_forums.jpg', array('alt'=> $blogger['username']."'s Forums", 'title'=> $blogger['username']."'s Forums")), 
       '/catforums/display/'. $blogger['username'].'/'.$blog['Catforum'][0]['user_id'], array('class'=>'chiki'), array('escape'=>False)).'<br />';
//}
?>
</div>
