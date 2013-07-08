<?php
#debug($data);
echo $this->Html->div(Null, $data['Ecourse']['description']);
echo $this->Html->div(Null, __('Created').': '.$data['Ecourse']['created']);
echo $this->Html->div(Null, __('Code').': '.$data['Ecourse']['code']);
# ? > EOF