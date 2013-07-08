<?php
# Show if college has School parent option active and display if so
$ps = $this->requestAction('/colleges/parentsSchool');
if ( strlen($ps) > 3 ):
    echo $this->Html->div('sideelement');
    echo $this->Html->div('sidemenu', __("Parent's Corner"));
    echo $this->Html->link($this->Html->image('static/banner_parents.jpg',array('title'=>__('Help your kids'),'alt'=>__('Help your kids'))),
                                  '/blog/'.$ps, array('escape'=>False));
    echo '</div>';
endif;

# ? > EOF