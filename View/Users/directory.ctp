<?php echo $this->Html->div('title_portal', __('Directory')); ?>

<table style="margin: 0 auto;border:1px dotted gray;width:100%;">
<tr style="padding:7px;color:green;font-size:9pt;border:1px dotted gray;text-align:left;"> 
   <td><?php __('Name');?></td> 
   <td>Message</td> 
   <td>eduBlog</td> 
   <td>Last Visit</td>
</tr>

<?php 
foreach ($users as $val):
    echo '<tr><td>'. $val['User']['username'] .'</td> <td>';
    if ( $this->Session->check('Auth')):
        echo $this->Html->link($this->Html->image('phorum.png', array('width'=>'20px', 'title'=>__('Write message'), 'alt'=>__('Write message'))), 
                               '/messages/message/'. $val['User']['username'], array('escape'=>False));
    else:
        echo 'Login to send message';
    endif;
    echo '</td><td>'.$this->Html->link($val['User']['name'], '/blog/'.$val['User']['username']) .'</td>';
    echo '<td>'. $val['User']['last_visit'] .'</td></tr>';
endforeach;

echo '</table>';

# ? > EOF
