<?php

namespace App\Repository;

use App\Entity\Weather;

class WeatherRepository extends Repository
{

  public function __construct(\PDO $db) {
    $this->db = $db;
    $this->repo = 'weather';
  }

  public function findWeatherById($id) {
    $sql = sprintf("SELECT * FROM %s WHERE id=?", $this->getRepo());
    $stm = $this->db->prepare($sql);
    $stm->execute([$id]);

    $obj_a = [];
    while ( $obj = $stm->fetch() ) {
      $obj_a[]  = new Weather($obj); 
    }

    return $this->afterExecution($obj_a);
  }

  public function findWeatherByLocation($city, $country) {
    $stm = null;
    $sql = sprintf("SELECT * FROM %s WHERE city=:city AND country=:country", $this->getRepo());
    $stm = $this->db->prepare($sql);
    $stm->bindParam('city', $city, \PDO::PARAM_STR);
    $stm->bindParam('country', $country, \PDO::PARAM_STR);
    $stm->execute();

    $obj_a = [];
    while ( $obj = $stm->fetch() ) {
      $obj_a[]  = new Weather($obj); 
    }

    return $this->afterExecution($obj_a);
  }

  /**
   * @param limit:integer
   * @param order:integer
   * @return Weather[]|Weather
   */
  public function weathers() {
    $sql = sprintf("SELECT * FROM %s ORDER BY date_in DESC", $this->getRepo());
    $stm = $this->db->prepare($sql);
    $stm->execute();

    $obj_a = [];
    while ( $obj = $stm->fetch() ) {
      $obj_a[]  = new Weather($obj); 
    }

    if( !isset($obj_a, $obj_a[0]) ) {
      $this->err = true;
      $this->msg = "No Weather in DB";
      return $this->JSONObject($obj_a);
    }
    
    $this->err = false;
    $this->msg = count($obj_a) . " weather(s) from DB.";
    return $this->JSONObject($obj_a);
  }

  /**
   * Used to create a new user
   * @param mixed (JSONObject)
   * @return  Weather
   */
  public function addWeather($weather) {
    $sql = sprintf("INSERT INTO %s VALUES(null, ?,?,?,?,?,?,?,?) ", $this->getRepo());
    $stm = $this->db->prepare($sql);
    $stm->execute([$weather->city, $weather->country, $weather->temp, $weather->date_in,
      $weather->temp_min, $weather->temps_max, $weather->icon, $weather->usr_id]);

    if($stm->closeCursor()) {
      return findWeatherById($this->db->lastInsertId());
    }
    return null;
  }


}