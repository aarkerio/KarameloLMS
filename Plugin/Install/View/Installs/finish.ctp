<h2><?php echo $title_for_layout; ?></h2>
<?php
echo $this->Html->para(Null, 'Delete the installation directory <strong>/APP/Plugin/Install</strong>');

echo $this->Html->div('verde',  __('Congratulations, Karamelo is installed').' '.$this->Html->link(__('Go to Home page and login'),'/'));

# ? > EOF
