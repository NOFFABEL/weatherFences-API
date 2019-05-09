<?php

namespace App\Controller;

use App\Entity\Weather;
use App\Repository\WeatherRepository;
use \Psr\Container\ContainerInterface;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;


class WeatherController {
  protected $container;
  protected $weatherRepo;

  public function __construct(ContainerInterface $container) {
    $this->container = $container;
    $this->weatherRepo = new WeatherRepository($container->pdo);
  }

  /**
   * This is used to get all weather form DB.
   */
  public function weather(Request $req, Response $res, $args) {
    return $this->weatherRepo->weathers();
  }

  /**
   * used to add new Weather in DB.
   */
  public function addWeather(Request $req, Response $res, $args) {
    $weather = $req->getQueryParams();
    $weather = new Weather($weather);

    return $this->weatherRepo->addWeather($weather);
  }

}