<?php
/*
 * Chipotle Software(c) 2006-2012
 * GPLv3 License
 * File: APP/Test/Case/Model/PermanentClassTest.php
 */

App::uses('Controller', 'Controller');
App::uses('PermanentClass', 'Model');
App::uses('PcStudent', 'Model');

class PermanentClassTestCase extends CakeTestCase {
 
 public $fixtures = array('app.permanent_class', 'app.pc_student', 'app.user');

 #public $dropTables = False;

 public function setUp() 
 {
     parent::setUp();
     $this->PermanentClass = ClassRegistry::init('PermanentClass');
 }

 # it "should return unauthorized without a valid session"
 # it "should return a populated array"
 public function testGetStudents()
 {
   $result = $this->PermanentClass->getStudents(1, 12);
   #die(debug($result));
   $this->assertInternalType('array',$result);
   $this->assertClassHasAttribute('validationErrors', 'PermanentClass');
   $this->assertClassHasAttribute('actsAs', 'PermanentClass');
   $this->assertClassHasAttribute('validate', 'PermanentClass');
 }

 public function addList($user_id, $vclassroom_id, $pc_id) #addList($user_id, $vclassroom_id, $pc_id)
 {
 
 }
}

# ? > EOF
