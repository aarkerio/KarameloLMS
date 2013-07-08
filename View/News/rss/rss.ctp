<?php
# You should import Sanitize
App::import('Sanitize');

#################NEW version
$this->set('documentData', array(
                                 'xmlns:dc' => 'http://purl.org/dc/elements/1.1/'));

$this->set('channelData', array(
                                'title' => __('Karamelo Recent Newss'),
                                'link' => $this->Html->url('/'),
                                'description' => __("Most recent posts."),
                                'language' => 'en-us'));


foreach ($newss as $n):
    $nTime = strtotime($n['News']['created']);
 
    $nLink = array(
                      'controller' => 'posts',
                      'action' => 'view',
                      'year' => date('Y', $nTime),
                      'month' => date('m', $nTime),
                      'day' => date('d', $nTime)
          );
  
    # This is the part where we clean the body text for output as the description 
    # of the rss item, this needs to have only text to make sure the feed validates
    $bodyText = preg_replace('=\(.*?\)=is', '', $n['News']['body']);
    $bodyText = $this->Text->stripLinks($bodyText);
    $bodyText = Sanitize::stripAll($bodyText);
    $bodyText = $this->Text->truncate($bodyText, 400, array(
                                                            'ending' => '...',
                                                            'exact'  => True,
                                                            'html'   => True,
                                                            ));
 
    echo  $this->Rss->item(array(), array(
                                          'title' => $n['News']['title'],
                                          'link' => $nLink,
                                          'guid' => array('url' => $nLink, 'isPermaLink' => 'true'),
                                          'description' =>  $bodyText,
                                          'dc:creator' => $n['News']['user_id'],
                                          'pubDate' => $n['News']['created']));
endforeach;

# ? > EOF
