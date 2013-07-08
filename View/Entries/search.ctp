<?php
# debug($data);
$this->set('title_for_layout',  __('Search Results'). ' :: Karamelo E-learning Web 2.0');

if ( count($data) < 2 ):
    echo $this->Html->div(Null, __('Sorry, no search results'));
else:
    $num = (count($data['News']) + count($data['Entry']) + count($data['Lesson']));
    echo $this->Html->div(Null, $num.' '.__('results found'));
endif;


echo $this->Html->div('title_portal', __('Search Results'));

if ($data['datasource'] == 'Database/Mysql'):
    if (count($data['Entry']) > 0 ):
        echo $this->Html->div(Null, 'Edublogs', array('style'=>'margin-top:10px;padding:4px;background-color:#ecebeb;font-size:13pt;'));
        foreach($data['Entry'] as $e):
            $tmp  = $this->Html->link($e['N']['title'], '/entries/view/'.$e['U']['username'].'/'.$e['N']['id'], array('target'=>'_blank')).'<br />'; 
            #$tmp .= 'Rank:'.$e[0]['rank'] .'<br /> '. Sanitize::clean($e['']['headline']);
            echo $this->Html->div(Null, $tmp, array('style'=>'padding:4px;font-size:10pt;'));
        endforeach;
    endif;
    if (count($data['Lesson']) > 0 ):
        echo $this->Html->div(null, __('Lessons'), array('style'=>'margin-top:10px;padding:4px;background-color:#ecebeb;font-size:13pt;'));
        foreach($data['Lesson'] as $e):
            $tmp  = $this->Html->link($e['N']['title'], '/lessons/view/'.$e['U']['username'].'/'.$e['N']['id'], array('target'=>'_blank')).'<br />'; 
            #$tmp .= 'Rank:'.$e[0]['rank'] .'<br /> '. Sanitize::clean($e[0]['headline']);
            echo $this->Html->div(null, $tmp, array('style'=>'padding:4px;font-size:10pt;'));
        endforeach;
    endif;

    if (count($data['News']) > 0 ):
        echo $this->Html->div(Null, __('News'), array('style'=>'margin-top:10px;padding:4px;background-color:#ecebeb;font-size:13pt;'));
        foreach($data['News'] as $n):
            $tmp  = $this->Html->link($n['N']['title'], '/news/view/'.$n['N']['id']).'<br />'; 
            #$tmp .= 'Rank:'.$n[0]['rank'] .'<br /> '. $n[0]['ts_headline'];
            echo $this->Html->div(null, $tmp, array('style'=>'padding:4px;font-size:10pt;'));
        endforeach;
    endif;
else: # pgsql 
    if (count($data['Entry']) > 0 ):
        echo $this->Html->div(Null, 'Edublogs', array('style'=>'margin-top:10px;padding:4px;background-color:#ecebeb;font-size:13pt;'));
        foreach($data['Entry'] as $e):
            $tmp  = $this->Html->link($e[0]['title'], '/entries/view/'.$e[0]['username'].'/'.$e[0]['id'], array('target'=>'_blank')).'<br />'; 
            $tmp .= 'Rank:'.$e[0]['rank'] .'<br /> '. Sanitize::clean($e[0]['headline']);
            echo $this->Html->div(Null, $tmp, array('style'=>'padding:4px;font-size:10pt;'));
        endforeach;
    endif;
    
    if (count($data['Lesson']) > 0 ):
        echo $this->Html->div(null, __('Lessons'), array('style'=>'margin-top:10px;padding:4px;background-color:#ecebeb;font-size:13pt;'));
        foreach($data['Lesson'] as $e):
            $tmp  = $this->Html->link($e[0]['title'], '/lessons/view/'.$e[0]['username'].'/'.$e[0]['id'], array('target'=>'_blank')).'<br />'; 
            $tmp .= 'Rank:'.$e[0]['rank'] .'<br /> '. Sanitize::clean($e[0]['headline']);
            echo $this->Html->div(null, $tmp, array('style'=>'padding:4px;font-size:10pt;'));
        endforeach;
    endif;

    if (count($data['News']) > 0 ):
        echo $this->Html->div(Null, __('News'), array('style'=>'margin-top:10px;padding:4px;background-color:#ecebeb;font-size:13pt;'));
        foreach($data['News'] as $n):
            $tmp  = $this->Html->link($n[0]['title'], '/news/view/'.$n[0]['id']).'<br />'; 
            $tmp .= 'Rank:'.$n[0]['rank'] .'<br /> '. $n[0]['ts_headline'];
            echo $this->Html->div(null, $tmp, array('style'=>'padding:4px;font-size:10pt;'));
        endforeach;
    endif;
endif;

# ? > EOF