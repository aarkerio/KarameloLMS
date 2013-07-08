<?php
$this->set('title_for_layout', __('Calendario de Actividades'));

echo $this->Html->div('title_portal', __('Activities Schedule'));

# check if organization has set a Google Calendar
if ( strlen($data['College']['gcalendar_id']) > 8):
    echo $this->Html->div(Null, Null, array('style'=>'margin:10px auto;text-align:center;'));
    $title = 'Calendario '.$data['College']['name'];
    $lang  = $this->Session->check('Auth') ? $this->Session->read('Auth.User.lang') : 'es';
?>
    <iframe src="http://www.google.com/calendar/embed?title=<?php echo $title;?>%20&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;hl=<?php echo $lang; ?>&amp;src=<?php echo $data['College']['gcalendar_id'];?>&amp;color=%232952A3&amp;ctz=America%2FMexico_City" style=" border-width:0 " width="600" height="600" frameborder="0" scrolling="no"></iframe>
    </div>
<?php
else:
    echo $this->Html->para(Null, __('Organization still not set a calendar'));
endif;
# ? > EOF
