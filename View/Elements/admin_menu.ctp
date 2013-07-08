<?php 
/**
 * Nav menu in admin backend
 * 2009-2012 GPLv3 Chipotle-Software
 */
$list = array(
             $this->Html->link('Control Panel', '/admin/entries/start'),
             $this->Html->link('eduBlog', '/admin/entries/listing') => array(
			                                       $this->Html->link(__('Comments'), '/admin/comments/listing'),
                                                               $this->Html->link(__('Usefull links'), '/admin/acquaintances/listing'),
                                                               $this->Html->link(__('Quotes'), '/admin/quotes/listing'),
                                                               $this->Html->link(__('Images'), '/admin/images/listing'),
                                                               $this->Html->link(__('Shares'), '/admin/shares/listing')
		                                                       ),
	     $this->Html->link(__('eCourses'), '/admin/ecourses/listing') => array(
		                                                  $this->Html->link(__('Add eCourse'), '/admin/ecourses/edit'),
                                                                  $this->Html->link(__('vClassrooms'), '/admin/vclassrooms/listing'),
                                                                  $this->Html->link(__('Permanent lists'), '/admin/permanent_classes/listing'),
                                                                  $this->Html->link(__('Forums'), '/admin/catforums/listing'),
                                                                  $this->Html->link(__('Messages'), '/admin/messages/listing'),
                                                                  $this->Html->link(__('WikiPages'), '/admin/wikis/listing'),
                                                                  $this->Html->link(__('Add WikiPage'), '/admin/wikis/edit')
			                                                 ),
          $this->Html->link('FAQs', '/admin/catfaqs/listing'),
         $this->Html->link(__('Glossaries'), '/admin/catglossaries/listing') => array(
                                                                   $this->Html->link(__('New Glossary'), '/admin/catglossaries/edit')
                                                                               ),
	     $this->Html->link(__('Lessons'), '/admin/lessons/listing') => array(
                                                                           $this->Html->link(__('New Lesson'), '/admin/lessons/edit')
                                                                          ),
        $this->Html->link(__('Kandies'), '/admin/entries/start') =>array(
                           #         $this->Html->link('K-network', '/admin/knets/listing'),
                                    $this->Html->link('Webquests', '/admin/webquests/listing'),
                                    $this->Html->link(__('Scavenger Hunts'), '/admin/treasures/listing'),
                                    $this->Html->link(__('Gap fillings'), '/admin/gaps/listing') =>array( $this->Html->link(__('Add Gap Filling'), '/admin/gaps/edit')),
                                    $this->Html->link(__('Quizz Tests'), '/admin/tests/listing') => array(
                                                                         $this->Html->link(__('New Test'), '/admin/tests/edit')),
#                                    $this->Html->link(__('SCORMs'), '/admin/scorms/edit')
                                                                         ),
         $this->Html->link(__('Helps'), '/helps/index')  => array(
                                                             $this->Html->link(__('Starting in Karamelo'), '#header', array('onclick'=>"javascript:window.open('/admin/entries/general', '_blank', 'toolbar=no, scrollbars=yes,width=900,height=700')")),
	                                     $this->Html->link(__('Report bug'), '/admin/helps/newticket'),
                                       #  $this->Html->link(__('Join the community!'), 'http://community.chipotle-software.com/', array('target'=>'_blank')),
                                         $this->Html->link(__('Get support'), '#header', array('onclick'=>"javascript:window.open('http://www.chipotle-software.com/', '_blank', 'toolbar=no, scrollbars=yes,width=900,height=700')"))
                                                            )
             );

 echo $this->Html->nestedList($list, array('id'=>'navmenu'));

# ? > EOF

