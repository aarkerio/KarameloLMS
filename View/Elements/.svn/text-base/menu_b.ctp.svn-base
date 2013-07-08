<?php
echo $this->Html->div('topmenu');

$list = array($this->Html->link(__('Calendar'), '/colleges/calendar/', array('title'=>__('Activities Calendar'))),
              $this->Html->link(__('Courses'), '/ecourses/display/', array('title'=>__('Current Courses'))),
              $this->Html->link('Edublogs', '/users/bloggers/', array('title'=>'eduBlogs')),
              $this->Html->link(__('vClassrooms'), '/vclassrooms/', array('title'=>__('vClassrooms'))),
              # $this->Html->link('Podcasts', '/podcasts/recent', array('title'=>__('Download and hear'))),
              $this->Html->link(__('College Library'), '/collections/', array('title'=>__('Library'))),
              $this->Html->link(__('Directory'), '/users/directory/', array('title'=>'Staff')),
              $this->Html->link(__('Newsletter'), '/newsletters/display/', array('title'=>__('Keep in touch')))
              );
echo $this->Html->nestedList($list, array('class'=>'arrowunderline'));

echo '</div>';

# ? > EOF
