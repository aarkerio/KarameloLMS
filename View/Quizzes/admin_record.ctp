<?php 
#die(debug($data));
echo $this->Html->script(array('jquery-min', 'jquery-plugins/jquery.jeditable'));
$tests = __('Quizz Tests');
$this->set('title_for_layout','Reports');

$this->Html->addCrumb('Control Panel', '/admin/entries/start'); 
$this->Html->addCrumb(__('vClassrooms'), '/admin/vclassrooms/listing');
$this->Html->addCrumb(__('Back to Vclassroom'), '/admin/vclassrooms/members/'.$vclassroom_id);
echo $this->Html->getCrumbs(' > ');

echo $this->Html->div('title_section', $this->Html->image('admin/tests.png', array('style'=>'margin-right:6px;','alt'=>$tests, 'title'=>$tests)).' '.$tests);

if ( !$data ):
    echo $this->Html->div('notice-message', __('Oops, no exams has been answered yet'));
endif;

echo '<table class="ajax_table">';
# Table headers
echo '<tr style="text-align:left;font-size:8pt;font-weight:bold;"><td>'.__('Title').'</td><td>'.__('Send results').'</td>';
echo '<td>'.__('Points').'</td><td>'.__('Answered').'</td><td>'.__('Student').'</td><td>'. __('Delete').'</td></tr>';
 
#end of table header
$msg     = __("Are you sure you want to remove the students\' answers to this test?");
$msg2    = __("Are you sure you want to send the exam graded to the student?");
$counter = (int) 1;
foreach ($data as $v):
    $counter++;
    if ( $v['checked'] == 1 ):
        $img   = 'static/img_correct.gif';
        $st    = __('Sent');
    else:
        $img   = 'static/img_correct_gray.gif';
        $st    = __('Not sent');
    endif;
    

    if ( $counter%2 ):
        $class = 'class="altRow" onmouseover="this.className=&#039;highlight&#039;" onmouseout="this.className=&#039;altRow&#039;"';
    else:
        $class = 'class="evenRow" onmouseover="this.className=&#039;highlight&#039;" onmouseout="this.className=&#039;evenRow&#039;"';
    endif;

    echo '<tr '.$class.'">'; 
    $link = $this->Html->link($v['title'], '#td'.$counter, array('title'=>'View test', 'onclick'=>
	    "window.open('/admin/tests/see/".$v['user_id'].'/'.$v['test_id'].'/'.$vclassroom_id."','mywin','left=20,top=10,width=700,height=700,scrollbars=1,toolbar=0,resizable=1')"));
    echo '<td id="td'.$counter.'">'.$link.'</td>';

    $link2 = $this->Html->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)), 
                      '/admin/tests/compose/'.$v['test_id'].'/'.$v['user_id'].'/'.$vclassroom_id, array('onclick'=>"return confirm('".$msg2."')", 'escape'=>False));

    echo '<td id="tdd'.$counter.'">'.$link2.'</td>';
    echo '<td>'.$v['points'].' '.__('Points').'</td>';
    echo '<td><span style="font-size:7pt;">'. $v['created']. '</span></td>';
    echo '<td>'.$this->Html->link($v['username'], '/users/about/'.$v['username']).'</td>';

    echo '<td>'.$this->Html->link($this->Html->image('static/delete_icon.png', array('width'=>'14px', 'alt'=>__('Delete'), 'title'=>__('Delete'))),
                             '/admin/tests/delactivity/'.$v['test_id'].'/'.$v['user_id'].'/'.$vclassroom_id, array('onclick'=>"return confirm('".$msg."')",'escape'=>False));
    echo '</td></tr>'; 
endforeach;

echo '</table>';

# ? > EOF