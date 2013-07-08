<div class="title_section">Subject</div>

<?php
//die(var_dump($data));

foreach ($data as $key=>$val)
  {
    echo "<div class=\"news_title\">". $val['Subject']['title']   . "</div>";
    echo "<div class=\"news_date\">" . $val['Subject']['code'] . "</div>";
  }
?>




