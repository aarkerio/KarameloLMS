<?php
# Author:  http://www.insecure.ws/2009/06/09/cakephp-without-a-database
# This is used by the istall plugin

class MyDatasource extends DataSource {

 public $description = "This is a dummy data source used in installer process";

 public function connect()
 {
    $this->connected = True;
    $this->default['database']  = Null;
    return $this->connected;
 }

 public function calculate()
 {
    $this->connected = True;
    $this->default['database']  = Null;
    return $this->connected;
 }
 public function disconnect()
 {
    $this->connected = false;
    return !$this->connected;
 }
 public function value()
 {
    return null;
 }
 public function fullTableName() 
 {
     return 'loquesea';
 }
 public function query()
 {
     return 'loquesea';
 }
 public function name()
 {
     return 'loquesea';
 }
 public function execute()
 {
     return 'loquesea';
 }
}

# ? > EOF
