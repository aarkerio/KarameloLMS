<?php
#die(debug($user));
# You should import Sanitize
App::uses('Sanitize', 'Utility');
$this->set('documentData', array(
                                 #'xmlns:xsl'   => 'http://www.w3.org/1999/XSL/Transform',
                                 'xmlns:itunes'=> 'http://www.itunes.com/dtds/podcast-1.0.dtd'
                                 ));

$this->set('channelData', array( 
                                'title'       => $user['User']['username'].' '.__('Most Recent Podcast'),
                                'link'        => $this->Html->url('/blog/'.$user['User']['username']),
                                'description' => $user['User']['username'].' '.__('Most recent Podcasts'),
                                'language'    => 'en-us'));
foreach ($podcasts as $pod):
    $postLink = array('controller' => 'podcasts', 'action' => 'view', $user['User']['username'].'/'.$pod['Podcast']['id']);
    # This is the part where we clean the body text for output as the description
    # of the rss item, this needs to have only text to make sure the feed validates
    $bodyText = preg_replace('=\(.*?\)=is', '', $pod['Podcast']['description']);
    $bodyText = $this->Text->stripLinks($bodyText);
    $bodyText = Sanitize::stripAll($bodyText);
    $bodyText = $this->Text->truncate($bodyText, 400, array(
                                                        'ending' => '...',
                                                        'exact'  => True,
                                                        'html'   => True,
                                                        ));

    echo $this->Rss->item(array(), array(
                                     'title'          => $pod['Podcast']['title'],
                                     'link'           => $postLink,
                                     'guid'           => array('url' => $postLink, 'isPermaLink' => True),
                                     'description'    => $bodyText,
                                     'enclosure'      => array('url'=>'/files/podcasts/'.$pod['Podcast']['filename']),
                                     'creator'        => $user['User']['username'],
                                     'category'       => 'Audio',
                                     'generator'      => 'Karamelo Platform',
                                     'managingEditor' => 'contact@chipotle-software.com',
			                         #'itunes:owner'   => array('itunes:name'=>$user['User']['username']),
			                         #'itunes:image'   => '/images/avatars/'.$user['User']['avatar'],
                                     #"itunes:author"  =>  $user['User']['name'],
                                     'pubDate'        => $pod['Podcast']['created']));
endforeach;

# ? > EOF