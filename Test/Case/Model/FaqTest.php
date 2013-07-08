<?php
/**
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: APP/Test/Case/Model/FaqTest.php
 */

App::uses('Controller', 'Controller');
App::uses('Faq', 'Model');

class FaqTestCase extends CakeTestCase {
 
 public $fixtures = array('app.faq', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->Faq = ClassRegistry::init('Faq');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testMyFunction() 
 {
     $this->loadFixtures('Faq');
 }
 
 # it "should return unauthorized without a valid session"
 # it "should return a valid array"
 # it "should return a validate class attribute"
 # it "should return a populated array"
 public function testThreeFaqs() 
 {
   $this->markTestIncomplete('This is incomplete, I know!!');

   $result  = $this->Faq->threeFaqs();
   $expected = array(
                     array('Faq' => array(
                                      'id'      => 1,
                                      'quote'   => 'Faq Faq Faq ',
                                      'author'  => 'Author 111 Author 111 Author 111 Author 111 ',
                                      'user_id' => 1
                                      )
                     ),
                     array('Faq' => array(
                                      'id'      => 2,
                                      'quote'   => 'Second  Students List',
                                      'author'  => 'Author 222 Author 222Author 222Author 222',
                                      'user_id' => 1
                                         )
                        ),
                     array('Faq' => array(
                                      'id'      => 3,
                                      'quote'   => 'Faq 333 Faq 333   ',
                                      'author'  => 'Author 333 Author 333 Author 333 Author 333 ',
                                      'user_id' => 1
                                         )
                           ));

  $this->assertEquals($expected, $result);
  $this->assertInternalType('array',$result);
  $this->assertClassHasAttribute('validate', 'Faq');
 }
}

# ? > EOF
