<?php

namespace App\Repository;

class Repository
{
  protected $err = false;
  protected $msg = null;
  protected $repo = null;
  protected $db;

  /**
   * @param val:mixed
   * @return string (JSON)
   */
  public function JSONObject($val = []) {
    $obj = ['error' => $this->err, 'msg' => $this->msg, $this->repo => $val];
    return json_encode($obj);
  }

  public function getRepo() {
    return $this->repo;
  }

  public function afterExecution($obj_a) {
    if(!is_array($obj_a) | !isset($obj_a, $obj_a[0])) {
      $this->err=true;
      $this->msg = "Request didn't return anything. For => '" . $this->repo . "'";
      return $this->JSONObject();
    }

    return $this->JSONObject($obj_a);
  }

  public function getDb() {
    return $this->db;
  }

  public function __set($name, $value) {
    if(property_exists($this, $name)) {
      $this->$name = $value;
    }
  }

}