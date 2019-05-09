<?php

namespace App\Entity;

trait Hydrate
{
  public function hydrate(array $obj_a)
  {
    foreach ($obj_a as $key => $value)
    {
      $method = 'set'.ucfirst($key);
      if (method_exists($this, $method))
      {
        $this->$method($value);
      }
    }
  }
}