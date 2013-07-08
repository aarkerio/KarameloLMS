<?php
if ( isset($error_message) ):
        echo '<span style="color:red;padding:7px;">' . $error_message . '</span>';
endif;

if ( isset($message) ):
    echo '<span style="color:blue;padding:7px;">' . $message . '</span>';
    echo $this->Html->para(Null, __('This email might have been sent to the junk/spam folder. Do not forget to check.'));
endif;

# ? > EOF