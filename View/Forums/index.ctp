<?php
die(debug($data));

foreach($data as $v)
{
  echo $v['Forum']['title'];
}
?>