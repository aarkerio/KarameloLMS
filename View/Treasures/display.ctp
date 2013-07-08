<h2><?php echo $blogger['username']; ?>'s Treasures</h2>

<?php
foreach( $data as $v ):
echo $this->Html->div('export');; 
   echo '<div>'.$this->Html->link($v['Treasure']['title'], '/treasures/view/'.$blogger['username'].'/'.$v['Treasure']['id']);
   echo ' Created: ' . $v['Treasure']['created'] . '</div>';
echo '</div>';
endforeach;
?>
