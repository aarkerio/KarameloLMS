<?php
if ( $ajaxTrue == False ):
    echo $this->Html->script(array('ckeditor/ckeditor', 'ckeditor/adapters/jquery', 'jquery-min', 'admin'));
endif;

#Paginator options for ajax
$this->Paginator->options(array(
                                'url'         => array('controller'=>'entries', 'action'=>'admin_listing', '1'),
                                'update'      => '#list',
                                'evalScripts' => True,
                                'before'      => $this->Gags->ajaxBefore(),
                                'complete'    => $this->Gags->ajaxComplete()
                              ));

echo $this->Gags->imgLoad('loading');

if ( $ajaxTrue == False ):
    $this->Html->addCrumb('Control Panel', '/admin/entries/start');
    echo $this->Html->getCrumbs(' > ');
    echo $this->Html->div('title_section', $this->Html->image('blog.png', 
                     array('style'=>'width:35px;margin-right:6px;', 'alt'=>__('Entries'), 'title'=>__('Entries'))).' '.__('Entries'));
    # Edit DIV
    echo $this->Gags->ajaxDiv('adminEdit');

    echo $this->Js->link($this->Html->image('actions/new.png', array('alt'=>__('Add new'), 'title'=>__('Add new'), 'onmouseover'=> "Tip('".__('Write new entry to your edublog')."')", 'onmouseout' => 'UnTip()')), '/admin/entries/edit',
             array('update' => '#adminEdit',
                   'before' => $this->Gags->ajaxBefore('adminEdit'). $this->Js->get('#list')->effect('fadeOut', array('buffer' => False)),
                           'complete'   => $this->Gags->ajaxComplete('adminEdit'),
                           'escape'     => False));
    #End of Ajax link to add new entry
    echo ' &nbsp;&nbsp;  ';

    #Ajax link to view all comments
    echo $this->Html->link($this->Html->image('static/forum.gif', array('alt'=>__('See comments'), 'title'=>__('See comments'), 'onmouseover'=> "Tip('".__('See comments')."')", 'onmouseout' => 'UnTip()')),
                           '/admin/comments/listing', array('escape'=>False));
    #End of Ajax link to view all comments
    echo $this->Gags->divEnd('adminEdit');
endif;

echo $this->Gags->ajaxDiv('session').$this->Session->flash().$this->Gags->divEnd('session'); #Update the session messages

echo $this->Gags->ajaxDiv('list');

$username = $this->Session->read('Auth.User.username');
if ( count($data) < 1 ):
    echo '<h1>'.__('No entries yet') .'</h1>';
else:

    #This is for correct pagination on change status sort
    $sDir = $this->Gags->sortDir(explode(" ", $this->Paginator->sortKey()),$this->Paginator->sortDir(), 'Entry.id');
    $sKey = $this->Gags->sortKey(explode(" ", $this->Paginator->sortKey()), $this->Paginator->sortKey());


    echo '<table class="ajax_table">';  #Table headers
    $th = array (__('Edit'), 
        $this->Paginator->sort('Entry.title',__('Title'), array('id'=>'entry_title',         
                      'update'    => '#list', 
                      'before'    => $this->Gags->ajaxBefore(), 
                      'complete'  => $this->Gags->ajaxComplete())),
                      __('Comments'),
         $this->Paginator->sort('Entry.status',__('Status'), array('id'=>'entry_status',         
                      'update'    => '#list', 
                      'before'    =>  $this->Gags->ajaxBefore(),
                      'complete'  =>  $this->Gags->ajaxComplete())),
         $this->Paginator->sort('Entry.created',__('Created'), array('id'=>'entry_date',
                      'update'    => '#list', 
                      'before'    =>  $this->Gags->ajaxBefore(),
                      'complete'  =>  $this->Gags->ajaxComplete())),
         __('Delete'),  __('Order'));

     #end of Table headers
    echo $this->Html->tableHeaders($th);


    #Get the "id" of the pagination columns and apply the Tip() and Untip() functions.
    $this->Gags->mouseOverOut('entry_title', 'Sort your entries by title');
    $this->Gags->mouseOverOut('entry_status', 'Sort your entries by status');
    $this->Gags->mouseOverOut('entry_date', 'Sort your entries by date');

    $a = __('Edit');
    $loop       = (int) 0;                        # just loop
    $order_show = (int) 0;                        # show activity number only++ if activity have status=1
    $num        = (int) count($data); # count activities
    foreach ($data as $val):
        $loop++;
        $entry_id = $val['Entry']['id'];
        $edit = $this->Js->link($this->Html->image('static/edit_icon.gif',array('alt'=>"$a",'title'=>"$a", 'width'=>'16px')),
         '/admin/entries/edit/'.$entry_id, 
         array('update'      => '#adminEdit',
               'evalScripts' => True,
               'before'      => $this->Gags->ajaxBefore('adminEdit'). $this->Js->get("#list")->effect('fadeOut',array('buffer'=>False)),
               'complete'    => $this->Gags->ajaxComplete('adminEdit'),
               'escape'      => False
           ));
        $del = $this->Js->link($this->Html->image('static/delete_icon.png',array('alt'=>__('Delete'),'title'=>__('Delete'), 'width'=>'16px')),
         '/admin/entries/delete/'.$entry_id, 
         array('update'      => '#list',
               'confirm'     => __('Are you sure to want to delete this?'),
               'evalScripts' => True,
               'before'      => $this->Gags->ajaxBefore(),
               'complete'    => $this->Gags->ajaxComplete(),
               'escape'      => False
           ));

        if ($val['Entry']['status'] == 1):
            $img   = 'static/status_1_icon.png';
            $st    = __('Published');
        else:
            $img   = 'static/status_0_icon.png';
            $st    = __('Draft');
            $order = $st;
        endif;
        if ( count($val['Comment']) > 0 ):
            $comment = $this->Html->link(count($val['Comment']), '/admin/comments/listing/'.$entry_id);
        else:
            $comment = count($val['Comment']);
        endif;

        #We want only the date, not hour
        $date = substr($val['Entry']['created'], 0, 10);
        $tr = array(
        $edit,
        $this->Html->link($val['Entry']['title'], '/entries/view/'.$username.'/'.$entry_id, array('target'=>'_blank')),
        $comment,
        $this->Js->link($this->Html->image($img, array('width'=>'14px', 'alt'=>$st, 'title'=>$st)),
         '/admin/entries/change/'.$entry_id.'/'.$val['Entry']['status'].'/'.$this->Paginator->current().'/'.$sKey.'/'.$sDir,
                   array('update'   => '#list',
                         'escape'   => False,
                         'before'   => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => False)),
                         'complete' => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => False)),
                         'id'       => $entry_id)),
        $date,
        $del
        );
   $tmp= (string) '';
   if ($loop != 1 && $num > 1): 
       $tmp .= $this->Html->link($this->Html->image('static/arrow_up_icon.png',array('width'=>'11px','alt'=>__('Up'),'title'=>__('Up'))),
                              '/admin/entries/order/up/'.$val['Entry']['id'].'/'. $val['Entry']['order'], array('escape'=>False)) .'&nbsp;&nbsp;';
   endif;
   # only if not is the last row
   if ($loop != $num && $num >1 ):
               $tmp .= $this->Html->link($this->Html->image('static/arrow_down_icon.png', array('width'=>'11px', 'alt'=>__('Down'), 
                       'title'=>__('Down'))), '/admin/entries/order/down/'.$val['Entry']['id'].'/'. $val['Entry']['order'], array('escape'=>False));
   endif;
   array_push($tr, $tmp);


        echo $this->Html->tableCells($tr, GagsHelper::$aRow, GagsHelper::$eRow);
    endforeach;

    echo '</table>';
endif;

$pages_num = $this->Paginator->counter(array('format'=>'%pages%'));
if ( $pages_num > 1 ):
    echo $this->Html->div(Null,$this->Paginator->prev('« '.__('Previous'),Null,Null,array('class'=>'disabled')),
                          array('style'=>'width:100px;float:left'));
    echo $this->Html->div(Null,$this->Paginator->next(__('Next').' »',Null,Null, array('class' => 'disabled')),
                          array('style'=>'width:100px;float:right'));
    echo $this->Html->div(Null,$this->Paginator->counter(), array('style'=>'width:200px;float:center'));
    echo $this->Html->div('pag_number','<br>'.__('Pages').': '.$this->Paginator->numbers(array('modulus' => 9)));
endif;


echo $this->Gags->divEnd('list');

if ( isset($ajaxTrue) ):
    echo $this->Js->writeBuffer();
endif;
# ? > EOF
