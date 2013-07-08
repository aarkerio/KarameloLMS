<?php
$data = $this->requestAction('quotes/getOne/'.$blogger['User']['id']);
if ( $data ):
    echo $data['Quote']['quote'] . ' <i>'. $data['Quote']['author'] . '</i>';
endif;

# ? > EOF
