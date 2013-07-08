<?php 
//die(print_r($sections)); 
?>

<table class="main_table">

<tr><td colspan="2">

</td></tr>
  <tr> <td colspan="2">
  <h1><?php echo $cover[0]['Cover']['title']; ?></h1>
      <?php echo $cover[0]['Cover']['body']; ?>
  </td></tr>


<tr><td id="tit_dyk">Last Blogs</td> <td id="tit_poll">Last Podcast</td></tr>

<tr><td style="padding:3px;width:300px;vertical-align:top;"> 
<?php 
 foreach($pages as $key => $val) {
     
     echo '<div>' . $val['Lesson']['title']   . '</div>';
     echo '<div><a href="/users/blog/'.$val['User']['id'].'">' . $val['User']['username']    . '</a></div>';
     echo '<div>' . $val['Lesson']['created'] . '</div>';
     echo '<div>' . $val['Lesson']['body']    . '</div>';
     
 }
?>
</td>
<td style="padding:3px;width:300px;vertical-align:top;">
<?php
print_r($podcasts);
?>
</tr>
</table>
