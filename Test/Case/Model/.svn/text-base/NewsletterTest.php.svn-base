<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: APP/Test/Case/Model/NewsletterTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Newsletter', 'Model');

class NewsletterTestCase extends CakeTestCase {
 
 public $fixtures = array('app.quote', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->Newsletter = ClassRegistry::init('Newsletter');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Newsletter');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeNewsletters() 
 {
   $result  = $this->Newsletter->threeNewsletters();
   $expected = array(
                     array('Newsletter' => array(
                                      'id'      => 1,
                                      'quote'   => 'Newsletter Newsletter Newsletter ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Newsletter' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Newsletter' => array(
                                      'id'      => 3,
                                      'quote'   => 'Newsletter 333 Newsletter 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Newsletter');
 }
}

# ? > EOF
