<?php
$this->set('title_for_layout', __('Step 2: Build database'));

echo $this->Html->div('title', 'Creating Admin User.  Step 3/3');

if ( $noConnect):
    echo $this->Html->div('rojo', __('I can not make connection with database, please push back button and verify your data'));
else:
    echo $this->Html->div('verde',  __('I can make connection with the database'));
endif;

echo 'Tables in DB: ' . $tables.'<br />';

if ( $tables > 0 ):
    echo $this->Html->div('rojo', __('looks like there are already tables in database. If installer process go ahead you could lost information, so I am stoping'));
    die();
endif;

#$this->Html->div('loadTables', $lines);

echo $this->Html->div('verde', __('Cool! Connection with database').' '.$db.' '. __('has been established and file APP/Config/database.php has been created and tables loaded').'.');

echo $this->Html->para(Null, __('Please fill next form to create the admin Karamelo user'));

echo $this->Html->para('field_req', __('Fields with * are required'));

?>
<div id="database_form">
      <form id="installform_user" method="post" action="finish" onsubmit="return validateUser();" >
 	  <div class="input text">
      
	  <label for="email"><?php echo __('Email for admin user, will be used to login');?> </label><br />
      <div class="required"><input name="email" type="text" value="@" id="email" size="20" maxlength="30"  class="required" /></div>
	  <div class="validateError" name="required" ></div>
	  <br /><br />
      </div>
	  
<div class="input">
    <label for="admin">Username</label><br />
    <div class="required"><input name="admin" type="text" value="" id="admin" size="10" maxlength="10" class="required" /></div>
    <div class="validateError" name="required" ></div>
	<br /><br />
</div>

<div class="input">
    <label for="name"><?php echo __('Name');?></label><br />
    <div class="required"><input name="name" type="text" value="" id="name" size="20" maxlength="20" class="required" /></div>
	<div class="validateError" name="required" ></div>
	<br /><br />
</div>

<div class="input">
    <label for="name"><?php echo __('Last name');?></label><br />
    <div class="required"><input name="lastname" type="text" value="" id="name" size="20" maxlength="20" class="required" /></div>
	<div class="validateError" name="required" ></div>
	<br /><br />
</div>

<div class="input">
    <label for="Password">Password</label><br />
    <div class="required"><input type="password" name="pwd" value="" id="pwd" size="10" maxlength="10" class="required" /></div>
	<div class="validateError" name="required" ></div>
	<br /><br />
</div>

<div class="input text">
    <label for="lang"><?php echo __('Language');?>:</label><br />
    <select name="lang">
        <option value="en" selected="selected">English </option>
        <option value="es">Español</option>
    </select>
</div>
<br />
 <input type="submit" value="<?php echo __('Next');?> >>" /> 
</form>
</div>
