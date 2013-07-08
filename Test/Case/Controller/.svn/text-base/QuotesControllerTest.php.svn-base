<?php
/**
 * Chipotle Software(c) 2012 GPLv3
 * File: APP/Test/Case/Controller/QuoteControllerTest.php
 */
App::uses('AclComponent', 'Controller/Component');
App::uses('PhpAcl', 'Controller/Component/Acl');
App::uses('Quotes', 'Controller');
App::uses('AppController', 'Controller');
App::uses('Quote', 'Model');
App::uses('Controller', 'Controller');
App::uses('Model', 'Model');
App::uses('View', 'View');

class QuotesControllerTest extends ControllerTestCase {

/*  
 * Load fixed data
 * @var array
 */
 public $fixtures = ['app.user','app.group',  'app.aro', 'app.aco', 'app.aros_aco', 'app.quote'];

 public $quotesMock = Null;

 /* Autoload fixtures */
 public $autoFixtures = True;
/**
 * setUp method
 *
 * @return void
 */
 public function setUp() 
 {
  parent::setUp();

  #$this->autoMock = False;  # Automatically mock controllers that are not mocked
 
 }

/**
  * testIndex method
  *
  * @return void
  */
 public function testShouldReturnOneQuote() 
 {                        
  $data   = array('user_id' => 1);
  $result = $this->testAction('/quotes/getOne/1', array('data' => $data, 'method' => 'get'));
  #die(debug($result));
  $this->assertTrue(is_array($result));
 }

 /**
  * testIndex method
  *
  * @return void
  */
 public function testSuccessfullSignIn() 
 {
   #$this->markTestIncomplete('This test testAdminListing has not been implemented yet.');
   $QuotesStub = $this->generate('Quotes', array(
                                                                           'components' => array('Auth', 
                                                                                                                   'Session')
                                                                     ));   
   $QuotesStub->Auth
                 ->expects($this->any())
                 ->method('login')
                 ->will($this->returnValue(True));  

   $result = $this->testAction('/admin/quotes/listing',array('return' => 'contents'));
   #die(debug($result));
   $this->assertRegexp('#<title>Karamelo::cPanel</title>#', $result);
 }

 /**
  * testIndex method
  * @access public
  * @return void
  */
 public function testAdminListing() 
 {
   #$this->markTestIncomplete('This test testAdminListing has not been implemented yet.');
   $QuotesStub = $this->generate('Quotes', array(
                                                                           'components' => array('Auth', 
                                                                                                                   'Session')
                                                                     ));   
   $QuotesStub->Auth
                 ->expects($this->any())
                 ->method('login')
                 ->will($this->returnValue(True));  

   $result = $this->testAction('/admin/quotes/listing', array('return' => 'contents'));
   $vars = $this->testAction('/admin/quotes/listing', array('return' => 'vars'));
   #die(debug($result));
   $this->assertInternalType('array', $vars);
   $this->assertArrayHasKey('Quote', $vars['data'][0]);
   $this->assertEquals(3, count($vars['data']));
   $this->assertNotEmpty($vars['data'][0]['Quote']);
   $this->assertFalse(strpos($result, '<pre class="cake-debug">'));
   $this->assertRegexp('#<title>Karamelo::cPanel</title>#', $result);
 }

/**
 *  Description
 *  @access public
 *  @return void
 *  @param integer $user_id
 * it "should return null (unauthorized) without a valid session"
 */
 public function testAddQuote() 
 {
   #$this->markTestIncomplete('This test testAdminListing has not been implemented yet.');

   $QuotesStub = $this->generate('Quotes', array(
                                                 'components' => array('Auth',
                                                                       'Session')
                                                                     ));   
   $QuotesStub->Auth
                 ->expects($this->any())
                 ->method('login')
                 ->will($this->returnValue(True));  

 $this->assertClassHasAttribute('helpers', 'QuotesController');

  $data = array(
                'Quote' => array(
                                'quote'   => 'New Quote',
                                'author'  => 'My great author',
                                'user_id' => 1,
                                'id'      =>1000
                                )
                   );
  $results = $this->testAction('/admin/quotes/add', array('data' => $data, 'method' => 'post'));
  # some assertioons
  #debug( $this->headers);
  $this->assertContains('/admin/quotes/listing', $this->headers['Location']);
  $this->assertEquals($results, True);
  #$this->assertRegexp('#<title>Karamelo::cPanel</title>#', $results);
 }


 /**
  * testIndex method
  * @access public
  * @return void
  */
 public function testAdminDelete() 
 {
   #$this->markTestIncomplete('This test testAdminListing has not been implemented yet.');
   $QuotesStub = $this->generate('Quotes', array(
                                                                           'components' => array('Auth', 
                                                                                                 'Session')
                                                                     ));   
   $QuotesStub->Auth
                 ->expects($this->any())
                 ->method('login')
                 ->will($this->returnValue(True));

   $vars = $this->testAction('/admin/quotes/delete/3', array('return' => 'result'));
   #die(debug($vars));
   $this->assertTrue($vars);
   
 }

 # Just clean the mess
  public function tearDown() 
  {
   #parent::tearDown();
   # Clean up after we're done
   unset($this->Controller);
 }

 }

# ? > EOF
