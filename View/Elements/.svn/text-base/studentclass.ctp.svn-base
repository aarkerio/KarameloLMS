<?php 
$vclassrooms = $this->requestAction('vclassrooms/myVclassrooms');
# die(debug($vclassrooms)); 
if ( $vclassrooms ):
    echo $this->Html->div('sideelement');
    ?>
    <form style="font-size:6pt;">
    <select style="font-size:6pt;" onchange="window.location=this.options[this.selectedIndex].value;">
    <option value="#"><?php __('Your current groups'); ?></option>
    <?php
    foreach ($vclassrooms as $v):
        echo '<option value="/vclassrooms/show/'.$v['Vclassroom']['username'].'/'.$v['Vclassroom']['id'].'">'.$v['Vclassroom']['name'].'</option>';
    endforeach;
    ?>
    </select>
    </form>
    </div>
<?php
endif;
# ? > EOF
