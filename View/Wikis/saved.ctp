<style>
.boldy{font-size:9pt;font-weight:bold;}
</style>
<?php
if ( $msg ):
    echo $this->Html->div('boldy', __('Cool!, you earned the points'));
else:
    echo $this->Html->div('boldy', __('Whoops you need edit some more lines to get the points'));
endif;
?>