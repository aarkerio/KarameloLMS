<div class="title_section">Last podcasts</div>
<?

//die(print_r($data));

foreach ($data as $key => $val) {
  echo "<div class=\"wrapnew\">";
      echo '<p><b>Title</b>:'.$data[$key]['Podcast']['title'].'<br />';
      echo '<b>Blogger</b>:<a href="/podcasts/blogger/'.$data[0]['User']['username'].'/'.$data[$key]['Podcast']['id'].'">'.$data[0]['User']['username'].'</a><br />';
      echo '<b>Created</b>:'.$data[$key]['Podcast']['created'].'<br />';
      echo '<b>Description</b>:'.$data[$key]['Podcast']['description'] . '<br /><br />';
     
      
      echo $this->Html->link($this->Html->image('static/podcast-mini.gif', array("title"=>"Podcast Feeder", "title"=>"Podcast Feeder")),
                       '/files/podcasts/'.$data[$key]['Podcast']['filename'],
                       null,
                       false,
                       false
                       );
  echo "</div>";  
}

?> 
