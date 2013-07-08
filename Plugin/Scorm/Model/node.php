<?php
/**
 * Handle XML nodes with polymorphism
 * @author Manuel Montoya
 * @license GPLv3
 */
# file: PluginScorm/models/node.php

abstract class BaseClass
{
 public $resources = array();

 abstract public function myMethod()
 {
   echo "BaseClass method called \n";
 }
}
 
class Metadata extends BaseClass
{
 public function myMethod()
 {
   echo "DerivedClass method called \n";
 }
}

class Organizations extends BaseClass
{
 public function myMethod()
 {
    echo "Clase derivada method called \n";
 }
 public function added() 
 { 
    print "subclass-added-method\n"; 
 }
}

class Resources extends BaseClass
{
 public function myMethod()
 {
   echo "DerivedClass method called \n";
 }
}

class Manifest extends BaseClass
{
  public function handle($obj)
  {
     if ($obj->hasAttributes()):
         foreach($obj->attributesas as $res_attr):
             if ($res_attr->type == XML_ATTRIBUTE_NODE):
			     $this->resource['atts'][$res_attr->name] = $res_attr->value;
             endif;
         endforeach;
     endif;
	 if ($obj->hasChildNodes()):
         $h = (int) 0;
         foreach($obj->objNodes as $resource_node):
             if ($resource_node->hasChildNodes()):
                 $h++;
			     $this->resources[$h] = $this->__scormResource('manifest',$resource_node);
             endif;
         endforeach;
     endif;  
  }
 public function myMethod()
 {
   echo "DerivedClass method called \n";
 }
}

# XML_TEXT_NODE    XML_ATTRIBUTE_NODE    XML_ELEMENT_NODE

class XmlElementNode extends BaseClass
{
 public function myMethod()
 {
   echo "DerivedClass method called \n";
 }
}

class XmlAttributeNode extends BaseClass
{
 public function myMethod()
 {
   echo "DerivedClass method called \n";
 }
}

class XmlTextNode extends BaseClass
{
 public function myMethod()
 {
   echo "DerivedClass method called \n";
 }
}

class Lom extends BaseClass
{
 public function myMethod()
 {
   echo "DerivedClass method called \n";
 }
}

class Schema extends BaseClass
{
 public function myMethod($child)
 {
   #echo "Schema method called \n";
   foreach($child->childNodes as $childchild):
       # there is generally only one child here
       # $this->schema = $childchildren[$index]->textContent;
       $this->data = $childchild->nodeValue;
   endforeach;
   return $this->data;
 }
}

class Schemaversion extends BaseClass
{
 public function myMethod()
 {
   echo "DerivedClass method called \n";
 }
}            
                                    
class Location extends BaseClass
{
 public function myMethod()
 {
   echo "DerivedClass method called \n";
 }
}        
 
# ? > EOF