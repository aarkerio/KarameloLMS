
<div class="title_section">Helps</div>

<div>
<table>
<?php
//var_dump($data);
foreach ($data as $key=>$val) {
          echo "<tr><td>";
             echo $this->Html->formTag('/polls/edit/'.$data[$key]['Poll']['id'], 'get');
             echo $this->Html->submit('Edit');
             echo "</form>";
          
          echo "</td><td>";
            
            echo  $val['Poll']['question']     . " ";
            echo  $val['Poll']['created']    . " ";
         echo "</td><td>";
         
            echo $this->Html->formTag('/polls/delete/'.$data[$key]['Poll']['id'], 'get', array("onsubmit"=>"return confirm('Are you sure?')"));
            echo $this->Html->submit('Delete');
            echo "</form>";
         echo "</td></tr>";
    }
?> 
</table>
