<?php
/**
 *   
 */

$this->layout = 'exceptions';
?>
<h2><?php echo $name; ?></h2>
<p class="error">
	<strong>Oooops! <?php echo __d('cake', 'Error'); ?>: </strong>
     <?php echo __d('cake', __('Something is not OK')); ?>
</p>
<?php
if (Configure::read('debug') > 0 ):
	echo $this->element('exception_stack_trace');
endif;
# ? > EOF

