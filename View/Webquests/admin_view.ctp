<?php

echo $this->Html->div('title_section', $data['Webquest']['title']);
echo $this->Html->div('text', __('Points') . ' '.$data['Webquest']['points']);

echo $this->Html->div('title_section', __('Introduction'));
echo $this->Html->div('text', $data['Webquest']['introduction']);

echo $this->Html->div('title_section', __('Tasks'));
echo $this->Html->div('title', $data['Webquest']['tasks']);

echo $this->Html->div('title_section', __('Process'));
echo $this->Html->div('title', $data['Webquest']['process']);

if ( strlen($data['Webquest']['roles']) > 10 ):
    echo $this->Html->div('title_section', __('Roles'));
    echo $this->Html->div('title', $data['Webquest']['roles']);
endif;

echo $this->Html->div('title_section', __('Evaluation'));
echo $this->Html->div('title', $data['Webquest']['evaluation']);

echo $this->Html->div('title_section', __('Conclusion'));
echo $this->Html->div('title', $data['Webquest']['conclusion']);


# ? > EOF
