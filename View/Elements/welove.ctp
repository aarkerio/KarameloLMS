<br /><br /><br />
<?php
echo $this->Html->div('sideelement');
echo $this->Html->para(Null,$this->Html->link($this->Html->image('static/firefox_80x15.gif', array('alt'=>'Get Firefox', 'title'=>'Get Firefox!')), 
                 'http://www.mozilla.com/firefox/', array('escape'=>False))).'<br />';
echo $this->Html->para(Null,$this->Html->link($this->Html->image('static/valid_xhtml10_80x15_22.png', array('alt'=>'XHTML', 'title'=>'XHTML')), 
                 'http://www.w3.org/TR/xhtml1/',array('escape'=>False))).'<br />';
echo $this->Html->para(Null,$this->Html->link($this->Html->image('static/ooorg-80.png', array('alt'=>'OpenOffice', 'title'=>'OpenOffice')), 
                 'http://www.openoffice.org',array('escape'=>False))).'<br />';
echo $this->Html->para(Null,$this->Html->link($this->Html->image('static/jedit.png', array('alt'=>'Pro Text Editor', 'title'=>'Pro Text Editor')), 
                 'http://www.jedit.org',array('escape'=>False))).'<br />';
echo $this->Html->para(Null,$this->Html->link($this->Html->image('cake.power.png', array('alt'=>'CakePHP 1.3', 'title'=>'CakePHP 1.3')), 
                 'http://www.cakephp.org',array('escape'=>False)));
?>
</div>