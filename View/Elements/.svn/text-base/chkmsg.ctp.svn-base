<?php
$new_message = $this->requestAction('messages/chkMsg');
$img = ($new_message != False) ?  'static/mail.png' : 'static/mailgray.png';
$url = ( $this->Session->read('Auth.User.group_id') > 2 ) ?  '/messages/listing':  '/admin/messages/listing';
echo $this->Html->link($this->Html->image($img, array('alt'=>__('Messages'), 'title'=>__('Messages'))), $url,array('escape'=>False)) . ' | ';
# ? > EOF