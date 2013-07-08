<?php
# Google data  Checker 
#$this->Gcalendar->installationChecker(); exit;
$vcname = str_replace('%20', ' ', $vcname);
$this->set('title_for_layout',  'Google Calendars');
echo '<h1>'.__('Calendar for'). ': '.$vcname.'</h1>';
#debug($_SESSION['sessionToken']);
if ( !isset($_SESSION['sessionToken']) ):
    echo $this->Html->para(Null, $this->Html->link(__('Please login into Google Calendar'), $this->Gcalendar->getAuthSubUrl()));
endif;

if ( isset($_GET['token']) and !isset($_SESSION['sessionToken']) ):
    $this->Gcalendar->setSession($_GET['token']);
endif;

if ( isset($_SESSION['sessionToken']) ):
    $client = $this->Gcalendar->getClient( $_SESSION['sessionToken'] );
    if ( $create == 1 ):
        $new = $this->Gcalendar->createCalendar($vcname);
    endif;
    #debug( $client );
    $data = $this->Gcalendar->outputCalendarList();
    echo $data;
    if ( $create == 0):
        echo $this->Html->link(__('Create calendar for').': '.$vcname, '/admin/ecourses/export/'.$vcname.'/1');
    endif;
endif;

echo $this->Html->scriptStart(); 
?>

function setGc(val)
{
  //window.opener.document.getElementById('VclassroomGcalendarId').value=val;
  $('#VclassroomGcalendarId', window.opener.document).val(val)
  window.self.close();
}
<?php 
echo $this->Html->scriptEnd(); 
# ? > EOF