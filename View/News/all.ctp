<div class="title_section">News</div>

<?php
//die(var_dump($data));

foreach ($data as $key=>$val)
  {
  echo "<div class=\"wrapnew\">";
  echo "<div class=\"news_title\">". $val['News']['title']   . "</div>";
  echo "<div class=\"news_date\">" . $val['News']['created'] . "</div>";
  echo "<div class=\"news_body\">";
  
  echo "Subject: ". $this->Html->link($val['Subject']['title'], '/news/all/'.$val['Subject']['id'], array('escape'=>False)) . "<br /><br />";
  
  echo  $val['News']['body']    . "</div>";
  
  if (strlen($val['News']['reference'])  > 5 )  // the reference
  {
      echo "<div>". $this->Html->link('Reference', $val['News']['reference']) ."</div>";
  }
  
  echo "</div>";
 }
?>
