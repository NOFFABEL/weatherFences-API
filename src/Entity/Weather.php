<?php

namespace App\Entity;

class Weather extends Entity
{
  use Hydrate;

  private $id, $temp, $temp_min, $temp_max, $date_in, $city, $country, $usr_id, $icon;

  public function __construct($weather) {
    parent::__construct($weather);
  }

  public function jsonSerialize() {
    return [
      "id" => $this->id,
      "city" => $this->city,
      "country" => $this->country,
      "temp" => $this->temp,
      "date_in" => $this->date_in,
      "temp_min" => $this->temp_min,
      "temp_max" => $this->temp_max,
      "icon" => $this->icon,
      "usr_id" => $this->usr_id
    ];
  }


  /**
   * Get the value of id
   */ 
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */ 
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of temp
   */ 
  public function getTemp()
  {
    return $this->temp;
  }

  /**
   * Set the value of temp
   *
   * @return  self
   */ 
  public function setTemp($temp)
  {
    $this->temp = $temp;

    return $this;
  }

  /**
   * Get the value of temp_min
   */ 
  public function getTemp_min()
  {
    return $this->temp_min;
  }

  /**
   * Set the value of temp_min
   *
   * @return  self
   */ 
  public function setTemp_min($temp_min)
  {
    $this->temp_min = $temp_min;

    return $this;
  }

  /**
   * Get the value of temp_max
   */ 
  public function getTemp_max()
  {
    return $this->temp_max;
  }

  /**
   * Set the value of temp_max
   *
   * @return  self
   */ 
  public function setTemp_max($temp_max)
  {
    $this->temp_max = $temp_max;

    return $this;
  }

  /**
   * Get the value of date_in
   */ 
  public function getDate_in()
  {
    return $this->date_in->format('Y-MM-DD H:i');
  }

  /**
   * Set the value of date_in
   *
   * @return  self
   */ 
  public function setDate_in($date_in='now')
  {
    $this->date_in = new DateTime($date_in, \date_default_timezone_get);

    return $this;
  }

  /**
   * Get the value of city
   */ 
  public function getCity()
  {
    return $this->city;
  }

  /**
   * Set the value of city
   *
   * @return  self
   */ 
  public function setCity($city)
  {
    $this->city = $city;

    return $this;
  }

  /**
   * Get the value of country
   */ 
  public function getCountry()
  {
    return $this->country;
  }

  /**
   * Set the value of country
   *
   * @return  self
   */ 
  public function setCountry($country)
  {
    $this->country = $country;

    return $this;
  }

  /**
   * Get the value of usr_id
   */ 
  public function getUsr_id()
  {
    return $this->usr_id;
  }

  /**
   * Set the value of usr_id
   *
   * @return  self
   */ 
  public function setUsr_id($usr_id)
  {
    $this->usr_id = $usr_id;

    return $this;
  }

  /**
   * Get the value of icon
   */ 
  public function getIcon()
  {
    return $this->icon;
  }

  /**
   * Set the value of icon
   *
   * @return  self
   */ 
  public function setIcon($icon)
  {
    $this->icon = $icon;

    return $this;
  }
}