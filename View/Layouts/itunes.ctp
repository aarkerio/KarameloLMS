<?php

echo $rss->header();

$rss->document($rss->addNs('itunes'));

if (!isset($channel)) 
{
  $channel = array();
}

if (!isset($channel['title'])) 
{
  $channel['title'] = $title_for_layout;
}

echo $rss->document(

		    $rss->channel(
				  array(), $channel, $content_for_layout
				  )

		    );
?>