<?php
/*
 * Chipotle Software(c) 2012
 * File: APP/Test/Case/Controller/VclassroomControllerTest.php
 */
App::uses('Vclassroom', 'Model');
App::uses('Controller', 'Controller');
App::uses('Model', 'Model');
App::uses('View', 'View');
App::uses('AclComponent', 'Controller/Component');

class VclassroomsControllerTest extends ControllerTestCase {
   
/*
 * Load fixed data
 * @var array
 */
 public $fixtures = array('app.quote', 'app.user', 'app.userVclassroom', 'app.vclassroom');

 # public  $this->autoMock = True;  # Automatically mock controllers that are not mocked

 public $vclassroomsMock = Null;
/**
 * setUp method
 *
 * @return void
 */
 public function setUp() 
 {
   parent::setUp();
 }

 /**
  * testIndex method
  *
  * @return void
  */
 public function testSuccessfullSignIn() 
 {
   $this->markTestIncomplete('This test has not been implemented yet.');
   $this->controller = $this->generate('Vclassrooms', array(
                                                       'components' => array('Auth' => array('user'), 'Mailer', 'Acl', 'Session', 'RequestHandler')
                                                       ));
   $this->controller->Auth
        ->staticExpects($this->any())
        ->method('login')
        ->will($this->returnValue(True));

     # tell PHPUnit that Session->check() metod should return true any time it is called
     $this->controller->Session
       ->expects($this->any())
       ->method('check')
       ->will($this->returnValue(True));

   $this->testAction('/admin/vclassrooms/listing',array('return' => 'contents'));
 
   $this->assertRegexp('#<title>Karamelo::cPanel</title>#', $this->contents);
 }

 /**
  * testIndex method
  *
  * @return void
  */

 public function testAdminListing() 
 {
   # $this->markTestIncomplete('This test testAdminListing has not been implemented yet.');
   $this->controller = $this->generate('Vclassrooms', array(
                                                       'components' => array('Auth' => array('user'), 'Mailer', 'Acl', 'Session', 'RequestHandler')
                                                       ));
   #$this->controller->Session->expects($this->once())->method('check');

   $this->testAction('/admin/vclassrooms/listing', array('return' => 'contents'));

   $this->assertRegexp('#<title>Karamelo::cPanel</title>#', $this->contents);
 }

 # it "should return null (unauthorized) without a valid session"
 public function testAddVclassroom() 
 {
  #$this->markTestIncomplete('This test testAdminListing has not been implemented yet.');
  $this->controller = $this->generate('Vclassrooms', array(
                                                       'components' => array('Auth' => array('user'), 'Mailer', 'Acl', 'Session', 'RequestHandler')
                                                       ));
  #$this->controller->Session->expects($this->once())->method('check');

  $data = array('Vclassroom' => array(
                                      'quote'   => 'New Vclassroom',
                                      'author'  => 'My great author',
                                      'user_id' => 1,
                                      'id'      => 1000
                                   )
                   );
  $results = $this->testAction('/admin/vclassrooms/add', array('data' => $data, 'method' => 'post'));
  # some assertioons
  debug( $this->headers);
  $this->assertContains('/admin/vclassrooms/listing', $this->headers['Location']);
  $this->assertEquals($results, True);
  #$this->assertRegexp('#<title>Karamelo::cPanel</title>#', $this->contents);
 }

 
  public function testListing() 
  {
    $result = $this->testAction('/admin/vclassrooms/listing');
    #debug($result);
  }

 # Just clean the mess
  public function tearDown() 
  {
   parent::tearDown();
   # Clean up after we're done
   unset($this->Controller);
 }

 }

# ? > EOF
