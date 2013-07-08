<div style="width:80%;margin:0 auto 0 auto;border:1px dotted orange;padding:8px">
<?php

if ( isset($error) ):
    echo '<span style="color:red;padding:7px;">Error: no such key.</span>';
endif;

if ( isset($pwd) ):
    echo '<span style="color:blue;padding:7px;">'.__('Your new password is'). ' <b>' . $pwd . '</b>,'. __('do not forget').'! ;-)</span> <br />';
    echo $this->Html->para(null, $this->Html->link('Login', '/users/login'));
endif;

echo '</div>';

# ? > EOF
