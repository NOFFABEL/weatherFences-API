<?php

namespace App\Entity;

abstract class Entity implements \JsonSerializable
{
  public function __construct($obj_a) {
    if(!empty($obj_a) && !is_array($obj_a)) {
      $obj_a = [$obj_a];
    }
    $this->hydrate($obj_a);
  }

  public function __get($name) {
    if(property_exists($this, $name)){
      $method = 'get' . ucfirst($name);
    }

    return $this->$method();
  }

  abstract public function jsonSerialize();

}