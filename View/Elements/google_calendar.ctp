<?php
  echo $this->Html->div(null, null, array('style'=>'margin:10px auto;text-align:center;'));
?>
<iframe src="http://www.google.com/calendar/embed?src=<?php echo trim($gcalendar_id); ?>&ctz=America/Mexico_City" style="border: 0" width="400" height="400" frameborder="0" scrolling="no">
</iframe>
</div>