<?php
$this->set('title_for_layout', $title_for_layout);

echo $this->Html->div('title', 'Checking environment and database.  Step 2/3');

$all_ok = True;
$cwd = exec('cd ../ && pwd');

echo $this->Html->div('instruct', 'If you are not the webserver user, you must give permissions manually to some directories. <a href="http://trac.chipotle-software.com/karamelo/wiki/DevelopersKarameloInstall" target="_blank">See here</a> for installation details</a>.');

echo  $this->Html->para(Null, '<b>1)</b> '.__('Checking mandatory environment'.':'));

$version = (float) PHP_VERSION;

if ( $version < 5.1 ):
    $all_ok = False;
    echo $this->Html->div('rojo', __('PHP is minor than 5.1, you must upgrade PHP version').'<br />');
else:
    echo $this->Html->div('verde',__('PHP version is correct').': ' . $version);
endif;


# Graphic library   
if ( !extension_loaded('gd') ):
    $all_ok = False;
    echo $this->Html->div('rojo', __('It looks like PHP5 GD library is not installed, so this section is not gone to work').'<br />'. 
                     __('If you are in Debian/Ubuntu try').': <br /><b>$sudo apt-get install php5-gd</b>');
else:
    echo $this->Html->div('verde',__('PHP5 GD library is installed'));
endif;

#How many databases are installed?
$no_db = 0;
if ( !extension_loaded('pgsql') ):
    #$all_ok = False;
    $no_db += 1;
    $tmp = __('It looks like PHP5 PostgreSQL library is not installed, so this section is not gone to work').' <br />';
    $tmp .= __('If you are in Debian/Ubuntu try').': <br /><b>$sudo apt-get install php5-pgsql</b>';
    echo $this->Html->div('rojo',$tmp);
else:
    echo $this->Html->div('verde',__('PHP5 PostgreSQL library is installed'));
endif;

#Mysql extensions
if ( !extension_loaded('mysql') ):
    #$all_ok = False;
    $no_db += 1;
    $tmp  = __('It looks like PHP5 MySQL library is not installed, so this section is not gone to work').' <br />';
    $tmp .= __('If you are in Debian/Ubuntu try').': <br /><b>$sudo apt-get install php5-mysql</b>';
    echo $this->Html->div('rojo',$tmp);
else:
    echo $this->Html->div('verde', __('PHP5 MySQL library is installed'));
endif;

#Check that must be at least 1 type of PHP DB extension
if( $no_db >= 2 ):
    $all_ok = False;
endif;

# Check if dirs are writable
if ( !is_writable('../Config/core.php') ):
    $all_ok = False;
    echo $this->Html->div('rojo','APP/Config/core.php '.__('file is not writable').'<br />'. __('try').': <br /><i>$chmod 666 '.$cwd.'/Config/core.php</i>');
else:
    echo $this->Html->div('verde', 'APP/Config/core.php '. __('is writable').' <br />');
endif;

# Check if dirs are writable
if ( !is_writable('../Config/.') ):
    $all_ok = False;
    echo $this->Html->div('rojo', 'APP/Config ' .__('directory is not writable').' <br /> '. __('try').':  <br /><i>$chmod 777  '.$cwd.'/Config/</i>');
else:
    echo $this->Html->div('verde', 'APP/Config '. __('directory is writable').' <br />');
endif;

if ( !is_writable('../tmp/cache/') ):
    $all_ok = False;
    $tmp  = 'APP/tmp/cache/ '. __('directory is not writable').' <br />';
    $tmp .= __('try').':  <br /><i>$chmod 777  '.$cwd.'/tmp/cache/ </i>';
    echo $this->Html->div('rojo', $tmp);
else:
    echo $this->Html->div('verde', 'APP/tmp/cache/ '. __('directory is writable').'<br />');
endif;


if ( !is_writable('../tmp/cache/models/') ):
    $all_ok = False;
    $tmp  = 'APP/tmp/cache/models/ '.__('directory is not writable').' <br />'. __('try');
    $tmp .=':  <br /><i>$chmod 777  '.$cwd.'/tmp/cache/models/ </i>';
    echo $this->Html->div('rojo', $tmp);
else:
    echo $this->Html->div('verde', 'APP/tmp/cache/models/ '. __('directory is writable').'<br />');
endif;

if ( !is_writable('../tmp/cache/persistent/') ):
    $all_ok = False;
    echo $this->Html->div('rojo',
             'APP/tmp/cache/persistent/ '.__('directory is not writable').'<br />'. __('try').':  <br /><i>$chmod 777  '.$cwd.'/tmp/cache/persistent/ </i>');
else:
    echo $this->Html->div('verde', 'APP/tmp/cache/persistent/ '. __('directory is writable').'<br />');
endif;

if ( !is_writable('img/imgusers/') ):
    $all_ok = False;
    echo  $this->Html->div('rojo',
        'APP/webroot/img/imgusers/ '. __('directory is not writable').' <br />'. __('try').': <br /><i>$chmod 777  '.$cwd.'/webroot/img/imgusers/</i>');
else:
    echo  $this->Html->div('verde', 'APP/webroot/img/imgusers/ '. __('directory is writable').' <br />');
endif;
 
if ( !is_writable('img/avatars/') ):
    $all_ok = False;
    $this->Html->div('rojo',
               'APP/webroot/img/avatars/ '. __('directory is not writable').' <br />'. __('try').': <br /><i>$chmod 777  '.$cwd.'/webroot/img/avatars/</i>');
else:
    echo $this->Html->div('verde','APP/webroot/img/avatars/ '. __('directory is writable').' <br />');
endif;

if ( !is_writable('files/podcasts/') ):
    $all_ok = False;
    echo $this->Html->div('rojo',
            'APP/webroot/img/imgusers/ '.__('directory is not writable').' <br />'. __('try').': <br /><i>$chmod 777 '.$cwd.'/webroot/files/podcasts/</i>');
else:
    $this->Html->div('verde', $cwd.'/webroot/files/podcasts/ '. __('directory is writable').' <br />');
endif;
?>
<p><b>2)</b> <?php echo __('Create a "karamelo" database user and a new database "DBKARAMELO"'); ?>:</p>
  <div id="indic" >
   Postgresql users:<br /><br />
   <b>$createuser -S -d -R -P -E karamelo </b><br /><br />
   <b>$createdb -U karamelo -E UNICODE DBKARAMELO</b><p>

   <p>MySQL users:</p>
   <p><b>$mysql -u root -p</b></p>
   <p><b>mysql&gt;CREATE DATABASE DBKARAMELO CHARACTER SET utf8 COLLATE utf8_general_ci;</b></p>
   <p><b>mysql&gt;CREATE USER 'karamelo'@'localhost' IDENTIFIED BY 'YuORpaSSwoRD';</b></p>
   <p><b>mysql&gt;GRANT ALTER,DROP,CREATE,SELECT,LOCK TABLES,INSERT,UPDATE,DELETE ON DBKARAMELO.* TO 'karamelo'@'localhost';</b></p>
 </div>

<?php
 echo $this->Html->para(Null, '<b>3)</b>'. __('After create database please fill next form with database details'));
 echo $this->Html->para('field_req',  __('Fields with * are required'));
 
 echo $this->Form->create('Install', array('id'=>'installform_db', 'action'=>'data', 'onsubmit'=>'return validateDatabaseconfig();'));
?>
<label for="database">Database type</label><br />
<select name="pgormy"  id="pgormy" onchange="setPort()">
  <option>Select</option>
<?php 
  if ($no_db == 1 && extension_loaded('pgsql')){ ?>
  <option value="Postgres">PostgreSQL</option>
  <?php 
  }else if($no_db == 1 && extension_loaded('mysql')) { ?>
  <option value="Mysql">MySQL</option>
  <?php
  }else{
  ?>
  <option selected="selected" value="mysql">MySQL</option>
  <option value="pgsql">PostgreSQL</option>
  <?php 
  } ?>
</select><br />
<div name="required" class="validateError" ></div>
<br />

<label for="database">Database name</label><br />
<div class="required"><input name="database" type="text" value="DBKARAMELO" id="database" size="15" maxlength="20" class="required" /></div>
<div class="validateError" ></div>
<br /><br />

<label for="user">Username</label><br />
<div class="required"><input name="user" type="text" value="karamelo" id="user" class="required" /></div>
<div class="validateError" ></div>
<br /><br />

<label for="pwd">Password</label><br />
<div class="required"><input type="password" name="pwd" value="" id="pwd" class="required" /></div>
<div class="validateError" ></div>
<br /><br />

<label for="host">Host</label><br />
<div class="required"><input name="host" type="text" value="localhost" id="host" class="required" title="<?php echo __('localhost is default configuration');?>" /></div>
<div class="validateError" ></div>
<br /><br />

<label for="port">Port</label><br />
<input name="port" id="port" type="text" value="3306" size="4" maxlength="4" title="<?php echo __('Left empty if you are using regular port'); ?>" />
<div class="validateError" ></div>
<br /><br />
<br />
<?php  if ( $all_ok): ?>
<input type="submit" value="<?php echo __('Next') ?> >>"   />
<?php else: ?>
<input type="submit" value="<?php echo __('You must resolve up issues in order to continue');?>" disabled="disabled" />
<?php endif; ?>
<br />
</form>

