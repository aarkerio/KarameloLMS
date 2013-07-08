<?php
/**
 * Installs Controller version 0.3
 *
 * PHP version 5
 *
 * @category Controller
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */

class InstallsController extends InstallAppController {

/**
 * Controller name
 *
 * @var string
 * @access public
 */
  public $name = 'Installs';

/**
 * No models required
 *
 * @var array
 * @access public
 */
    public $uses = Null;

/**
 * @access protected
 */
  protected $_tables_expected =  80;

/**
 * @access protected
 */
  protected $_cwd = Null;

/**
 * beforeFilter
 *
 * @return void
 * @access public
 */
  public function beforeFilter() 
  {
    parent::beforeFilter();
    $this->layout = 'install';
    App::import('Component', 'Session');
    $this->Session = new SessionComponent($this->Components);
    #die('I am in beforeFilter controller plugin class');
    $this->Auth->allow(array('index', 'database', 'data', 'finish')); 
  }  

/**
 *  If settings.yml exists, app is already installed
 *  @access protected
 *  @return void
 */
  protected function _check() 
  {
   if (file_exists(APP . 'Config' . DS . 'installed.txt')):
       $this->Session->setFlash('Already Installed');
       $this->redirect('/');
   endif;
  }

/**
 * Step 0: welcome
 *
 * A simple welcome message for the installer.
 *
 * @return void
 * @access public
 */
  public function index() 
  {
   $this->_check();
    # Karamelo Installer
    if ( file_exists('../Config/installed.txt') ):
        die('Karamelo already is installed');
    endif;
    $this->set('title_for_layout', __('Installation: Welcome'));
  }

/**
 * Step 1: database
 *
 * Try to connect to the database and give a message if that's not possible so the user can check their
 * credentials or create the missing database
 * Create the database file and insert the submitted details
 *
 * @return void
 * @access public
 */
  public function database() 
  {
    # die(debug($this->request));
    $this->_check();
    $this->set('title_for_layout', __('Step 1: Database'));
    $this->Session->write('lang_inst', $this->request->data['Install']['lang_inst']);
    
    if (empty($this->request->data)):
        return False;
    endif;
 }

/**
 * Step 2: Run the initial sql scripts to create the db and seed it with data
 *
 * @return void
 * @access public
 */
  public function data() 
  {
   #die(debug($this->request));
   $this->_check();

   $type =  strlen($this->request->data['pgormy'])   > 3  ?  $this->request->data['pgormy']    : 'Mysql';
   $port =  strlen($this->request->data['port'])     > 3  ?  $this->request->data['port']       : '5432';
   $pwd  =  strlen($this->request->data['pwd'])      > 3  ?  trim($this->request->data['pwd'])       : '';
   $host =  strlen($this->request->data['host'])     > 5  ?  trim($this->request->data['host'])      : '';
   $db   =  strlen($this->request->data['database']) > 2  ?  trim($this->request->data['database'])  : 'DBKARAMELO';
   $user =  strlen($this->request->data['user'])     > 3  ?  trim($this->request->data['user'])      : '';

   $this->set('db', $db);
   
   if (  $type == 'Mysql' ):
      $dbconn = mysql_connect("$host","$user","$pwd");
     
	  $select_db = mysql_select_db($db, $dbconn);
      $driver = 'Mysql';
	  
	  if ( !$dbconn || !$select_db ):
          $this->set('noConnect', True);
          return False;
	  else:
          $this->set('noConnect', False);
	  endif;
  else:
      $conn_string = 'host='.$host.' port='.$port.' dbname='.$db .' user='.$user.' password='.$pwd;
      #die($conn_string);
      $dbconn = pg_connect($conn_string);
      $driver = 'Postgres';
	  
  	  if ( !$dbconn ):
		  $this->set('noConnect', True);
          return False;
	  else:
          $this->set('noConnect', False);
	  endif;
  endif;

 #Check database.php file
$cont = <<<XYZ
<?php

class DATABASE_CONFIG {
  public \$default = array(
                         'datasource' => "Database/$driver",
                         'persistent' => False,
                         'host'       => '$host', 
                         'port'       => '$port',
                         'login'      => '$user',
                         'password'   => '$pwd',
                         'database'   => '$db',
                         'schema'     => 'public',
                         'prefix'     => '',
                         'encoding'   => 'UTF-8'); 
  }
# ? > EOF
XYZ;

 $file = '../Config/database.php';
 if ( file_exists($file) ):
     unlink($file);
 endif;
 $fh   = fopen($file, 'w') or die("can't open database file"); 
 fwrite($fh, $cont);
 fclose($fh);

 # Check database is empty
 if (  $type == 'Mysql' ):
     $result = mysql_query("SELECT table_name from information_schema.tables where table_schema='$db'", $dbconn );
     $tables = mysql_num_rows( $result );
 else:
     $result = pg_query($dbconn, "SELECT count(*) FROM pg_tables WHERE schemaname='public'");
     $row    = pg_fetch_row($result);
     $tables =  $row[0];
 endif;

 $this->set('tables', $tables);

 if (  $type == 'Mysql' ):
     $q="mysql ".$db." -u ".$user." -h ".$host." -P ".$port."  --password=".$pwd." < ./users.sql";
     # die($q);
     $lines = system('bash && cd ../Config/sql/mysql/ && '.$q, $return); # load tables
 else:
     #create User and group Model 
     $q="psql --quiet -U ".$user." -h ".$host." -p ".$port." -d ".$db." < ./users.sql";
     $s = 'bash && cd ../Config/sql/postgresql/ && export PGPASSWORD='.$pwd.' && '.$q;
     #die($s);
     $lines = system($s, $return); # load tables
 endif;

 $this->set('lines', $return);

 }

/**
 * Step 3: finish
 *
 * Remind the user to delete 'install' plugin
 * Copy settings.yml file into place
 *
 * @return void
 * @access public
 */
  public function finish() 
  {
   $this->set('title_for_layout', __('Installation completed successfully'));
   $this->_check();

  #change salt
  $filename = '../Config/core.php';
  $content  = file_get_contents($filename);
  $find     = '1122ca6186410235cba3ce66422589dd73f4fbe1';
  $salt     = $this->_genPassword(40);
  # Replace hash string
  $replaced = str_replace($find, $salt, $content);
  # Open the file
  $fh = fopen($filename, 'w+');
  fwrite($fh, $replaced);
  fclose($fh);

  require_once '../Config/database.php';
  $dbc   = new DATABASE_CONFIG;
  # die(var_dump($dbc->default));
  if ( $dbc->default['datasource'] == 'Database/Mysql' ):
      $dbconn = mysql_connect($dbc->default['host'], $dbc->default['login'], $dbc->default['password']);
      mysql_select_db($dbc->default['database']);
  else:
      $conn = (string) 'dbname='.$dbc->default['database'] .' ';
      if ( strlen($dbc->default['host']) > 3 ):
          $conn .= 'host='.$dbc->default['host'] .' ';    
      endif;
      if ( strlen($dbc->default['password']) > 3 ):
          $conn .= 'password='.$dbc->default['password'] .' ';    
      endif;
      if ( strlen($dbc->default['login']) > 3 ):
          $conn .= 'user='.$dbc->default['login'] .' ';    
      endif;
      if ( strlen($dbc->default['port']) > 2 ):
          $conn .= 'port='.$dbc->default['port'];    
      endif;
      #die($conn);
      $dbconn = pg_connect($conn);
  endif;
 
  #die(var_dump( $dbconn));

  $username = trim($this->request->data['admin']);
  $email    = trim($this->request->data['email']);
  $name     = trim($this->request->data['name']); 
  $lastname = trim($this->request->data['lastname']);
  $lang     = trim($this->request->data['lang']);
  $hashed   = $this->Auth->password(trim($this->request->data['pwd']));

  $q1 = "INSERT INTO users (id,active,name,lastname,username,email,group_id,pwd,lang) VALUES (1,1,'$name','$lastname', '$username', '$email', 1, '$hashed','$lang')";
  $q2 = "INSERT INTO aros (id, parent_id, model, foreign_key, alias, lft, rght) VALUES (5, 1, 'User', 1, '$username', 2, 3)"; #Acl CakePHP
  $q3 = "INSERT INTO profiles (user_id) VALUES (1)"; # hasOne relationship
  
  if ( $dbc->default['datasource'] == 'Database/Mysql' ):
      $result = mysql_query($q1)  || die('Invalid query: ' . mysql_error()); 
      if (!$result):  
          echo $this->Html->div('rojo', __('User can not be created'));
          die();
      else:       
          $res = mysql_query($q2) || die('Invalid query: ' . mysql_error());
          $res = mysql_query($q3) || die('Invalid query: ' . mysql_error());
      endif;
      # Load tables
      $q  = "mysql ".$dbc->default['database']." -u ".$dbc->default['login']." -h ".$dbc->default['host']." --password=".$dbc->default['password']."  ";
      $q .= "-P ".$dbc->default['port']." < ./mysqlkaramelo.sql";
      #die($q);
      $line = system('bash && cd ../config/sql/mysql/ && '.$q, $return); # load tables
   else:  # pgsl DB
      #die(var_dump($user_record));
  
      $result = pg_query($dbconn, $q1); 
      if ( !$result ):
          echo $this->flash(__('User can not be created'));
          die();
      else:
          $res = pg_query($dbconn, $q2);
          $res = pg_query($dbconn, $q3);
      endif;
      # Load tables
      $q = "psql --quiet -U ".$dbc->default['login']." -h ".$dbc->default['host'];
      if ( strlen($dbc->default['port']) > 2 ):
          $q .= ' -p '.$dbc->default['port'];    
      endif;
      $q .= ' -d '.$dbc->default['database'].' < ./karamelo.sql';
      #die($q);
      $line = system('bash && cd ../Config/sql/postgresql/ && export PGPASSWORD='.$dbc->default['password'].' && '.$q, $return); # load tables
  endif;
  #create file

  $file = '../Config/installed.txt';
  $cont = 'Karamelo installed at '.date("F j, Y, g:i a") ."\n"; 
  $fh   = fopen($file, 'w') or die("can't open installed file");
  fwrite($fh, $cont);
  fclose($fh);


   /* if (isset($this->params['named']['delete'])) 
   {
            App::uses('Folder', 'Utility');
            $this->folder = new Folder;
            if ($this->folder->delete(APP.'plugins'.DS.'install')) 
            {
                $this->Session->setFlash(__('Installation files deleted successfully.'), 'default', array('class' => 'success'));
                $this->redirect('/');
            } else {
                return $this->Session->setFlash(__('Could not delete installation files.'), 'default', array('class' => 'error'));
            }
   }
       

        # set new salt and seed value
        copy(APP . 'Config' . DS.'settings.yml.install', APP . 'Config' . DS.'settings.yml');
        App::uses('File', 'Utility');
        $File =& new File(APP . 'Config' . DS . 'core.php');
        if (!class_exists('Security')) {
            require CAKE . 'Utility' .DS. 'Security.php';
        }
        $salt = Security::generateAuthKey();
        $seed = mt_rand() . mt_rand();
        $contents = $File->read();
        $contents = preg_replace('/(?<=Configure::write\(\'Security.salt\', \')([^\' ]+)(?=\'\))/', $salt, $contents);
        $contents = preg_replace('/(?<=Configure::write\(\'Security.cipherSeed\', \')(\d+)(?=\'\))/', $seed, $contents);
        if  ( !$File->write($contents)) 
        {
           return false;
        }
        Configure::write('Security.salt', $salt);
        Configure::write('Security.cipherSeed', $seed);

        # set default password for admin
        $User = ClassRegistry::init('User');
        $User->id = $User->field('id', array('username' => 'admin'));
        $User->saveField('password', 'password');
      */
  }

  protected function _genPassword($length) 
  {
   $password = (string) '';
      
   srand((double)microtime()*1000000);
      
   $vowels  = array("a", "e", "i", "o", "u");
   $numbers = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);
   $cons    = array("b", "c", "d", "g", "h", "j", "k", "l", "m", "n", "p", "r", "s", "t", "u", "v", "w", "tr", 
                       "cr", "br", "fr", "th", "dr", "ch", "ph", "wr", "st", "sp", "sw", "pr", "sl", "cl"); 
        
   $num_vowels = count($vowels); 
   $num_cons   = count($cons); 
           
   for($i = 0; $i < $length; $i++)
   {
     $password .= $cons[rand(0, $num_cons - 1)] . $numbers[rand(0, count($numbers) - 1)] . $vowels[rand(0, $num_vowels - 1)];
   }
      
    return substr($password, 0, $length); 
 }
}

# ? > EOF
