<div style="font-size:18pt;padding:5px;boder:1px solid #c0c0c0"> <?php echo $blog["User"]["username"]; ?>'s Exams</div>

<?php
//die(print_r($data));
foreach ($data as $val)
{
   echo '<div style="border:1px dotted gray;padding:4px;margin-bottom:15px">';
        echo $this->Html->link($val['Test']['title'], '/tests/view/'.$val['Test']['id'].'/'.$blog["User"]["id"]) . '<br />';
        echo '<b>Description</b>: <i>' .  $val['Test']['description']  . '</i><br />';
    echo '</div>';
}
?>

