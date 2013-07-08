<?php
#die(debug($data));
$this->set('title_for_layout', __('Quizz test') . ' ' .$data['Test']['title']);

$linked = $data['t']['TestVclassroom']; # linked vclassroom

echo $this->element('vccrumb', array('blogger'=> $blogger['User']['username'], 'vclassroom_id'=>$linked['vclassroom_id']));

# student belongs to vclassroom, kandie is in correct date and test has not been answered by student
if ( $permissions['belongs'] == True and $permissions['chkdate'] == True and $permissions['already'] == False): 
    echo $this->Html->para(Null, 'hi! '.$this->Session->read('Auth.User.username'), array('style'=>'font-weight:bold;font-size:12pt;'));
    echo $this->Html->para(Null, '<b>Tip</b>:'.__('Avoid data loss, first write and save your answers in a text editor and then copy and paste here').'.');
    echo $this->Html->div('title', $blogger['User']['username'] .'s '.__('Quizz Test'));
    echo $this->Html->div('mes',__('Start date').': '.$linked['sdate']);
    echo $this->Html->div('mes',__('Finish date').': '.$linked['fdate']);
    echo '<h1>'. $data['Test']['title'] . '</h1>';
    echo $this->Html->para(Null, $data['Test']['description']);
    echo $this->Gags->imgLoad('loading');
    if (count($data['Question']) == 0):
        echo $this->Html->div('titentry', __('Oops, looks there is no questions in this Quizz test'));
    else:
        $maxpoints     = (int) 0; 
        $num_questions = (int) 0;    
    endif;
  
    echo $this->Gags->ajaxDiv('answerDiv');
echo  $this->Html->div('holder', $this->element('test', array('data'=>$data, 'vclassroom_id'=>$linked['vclassroom_id'], 'next'=>$data['Question'][0]['id'], 'points'=>0)));
    echo $this->Gags->divEnd('answerDiv');
    echo $this->Html->para(Null, __('Maximum possible score in this test').' : ' . $data['maxpoints']);
else:
    echo $this->element('permissions', array('permissions'=>$permissions, 'dates'=>$linked, 'kandie_user_id'=>$blogger['User']['id']));
endif;
?> 
<style>

#answerDiv{
   border:1px dotted gray;
}

.numbers{
    text-align:center;
    font-weigth:bold;
    color:red;
    font-size:18pt;
    padding:4px;
}

.question{
    text-align:left;
    font-weigth:bold;
    color:#000;
    font-size:14pt;
    padding:5px;
}

.holder {
  width: 100%;
  }


.buttonlink {
   margin:2px;
   padding:2px;
   background-color:#e0e0e0;
}

.buttonlink a {
    size: 16pt;
    color:#000;
    display: block;
    padding: 3px;
    border: 1px solid gray;
    text-align: left;
    line-height: 49px;
    background : -webkit-gradient(linear, left top, left bottom, from(#5991cf), to(#fff));
    background : -moz-linear-gradient(top, #5991cf, #fff);
    -webkit-transition-property: background;
    -webkit-transition-duration: 900ms;
    -moz-transition-property: background;
    -moz-transition-duration: 900ms;
}

.buttonlink a:hover {
   background: -webkit-gradient(radial, 50% 100%, 10, 10% 90%, 90, from(#4778b0), to(#5991cf) );
   background: -moz-radial-gradient(right 80px 45deg, circle cover, #4778b0 0%, #5991cf 100%);
}
</style>
