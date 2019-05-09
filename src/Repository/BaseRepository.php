<?php

namespace App\Repository;

/**
 * 
 */
trait BaseRepository
{
  private $db;

  public function getDb() : \PDO {
    return $this->db;
  }

  public function __set($name, $value) {
    if(property_exists($this, $name)) {
      $this->$name = $value;
    }
  }

}