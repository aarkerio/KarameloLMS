<div style="margin:10px 0;padding:4px">
<?php
echo $this->Html->image('static/lchat.png', array('alt'=>'Livechat', 'title'=>'Livechat', 'style'=>'margin-right:5px 0 10px 0'));

echo $this->Gags->imgLoad('cargando');

echo $this->Form->create();
echo $this->Form->hidden('Livechat.user_id', array('value'=>$blogger['User']['id']));  # user_id id est blogger

if ( $this->Session->check('Auth.User') ):
    echo $this->Form->hidden('Livechat.sender_name', array('value'=>$this->Session->read('Auth.User.username')));  # user_id
 else:
    echo $this->Form->input('Livechat.sender_name', array('size'=>10,'maxlength'=>50))."<span style='font-size:8pt'>&lt;-Nombre</span><br />";  // user_id
endif;
echo $this->Form->input('Livechat.message', array('size'=>15, 'maxlength'=>130, 'between'=>'<br />'));  # user_id

echo $this->Js->submit('Enviar', array(
                                 'url'         => '/livechats/add', 
                                 'update'      => '#livechat',
                                 'evalScripts' => True,
                                 'before'      => $this->Gags->ajaxBefore('livechat','cargando'),
                                 'complete'    => $this->Gags->ajaxComplete('livechat','cargando')
        ));
echo '</form>';

echo $this->Gags->ajaxDiv('livechat');

foreach ($blogger['Livechat'] as $val):
    echo '<span style="font-size:7pt;font-weight:bold">'.$val['sender_name'] .' wrote:</span> <br />';
    echo '<span style="font-size:8pt;">'.Sanitize::html($val['message']) .'</span> <br />';
    echo '<span style="font-size:7pt;color:green">'.$time->timeAgoInWords($val['created']) .'</span><br /><br />';
endforeach;
echo $this->Gags->divEnd('livechat');
?>
</div>
