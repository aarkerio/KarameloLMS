<?php
# You should import Sanitize
App::uses('Sanitize', 'Utility');
$this->set('documentData', array(
                                 'xmlns:pod' => 'http://sw.deri.org/2005/07/podcast#',
                                 'xmlns:dc'  => 'http://purl.org/dc/elements/1.1/'));

$this->set('channelData', array( 
                                'title'       => $user['User']['username'].' '.__('Most recent entries'),
                                'link'        => $this->Html->url('/blog/'.$user['User']['username']),
                                'description' => $user['User']['username'].' '.__('Most recent entries'),
                                'language'    => 'en-us'));
foreach ($entries as $val):
    $postLink  = array('controller' => 'entries', 'action' => 'view', $user['User']['username'].'/'.$val['Entry']['id']);
    # This is the part where we clean the body text for output as the description
    # of the rss item, this needs to have only text to make sure the feed validates
    $bodyText  = str_replace('nbsp', ' ', $val['Entry']['body']);
    $bodyText  = preg_replace('=\(.*?\)=is', '', $bodyText);
    $bodyText = $this->Text->stripLinks($bodyText);
    $bodyText = Sanitize::stripAll($bodyText);
    $bodyText  = $this->Text->truncate($bodyText, 200, array('ending'=>'...', 'exact'=>True, 'html'=>True));
    echo $this->Rss->item(array(), array(
                                     'title'          => $val['Entry']['title'],
                                     'link'           => $postLink,
                                     'guid'           => array('url' => $postLink, 'isPermaLink' => True),
                                     'description'    => $bodyText,
                                     'creator'        => $user['User']['username'],
                                     'generator'      => 'Karamelo Platform',
                                     'pubDate'        => $val['Entry']['created']));
endforeach;

# ? > EOF