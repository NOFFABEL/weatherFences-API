<?php

namespace App\Controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Container\ContainerInterface;
use App\Repository\UserRepository;

class UserController
{
  protected $container;
  protected $userRepo;

  public function __construct(ContainerInterface $container) {
    $this->container = $container;
    $this->userRepo = new UserRepository($this->container->pdo);
  }

  /**
   * used to get user by his id.
   */
  public function getUser(Request $req, Response $res, $args) {
    if(!isset($args, $args['id']))
      return null;

    return $this->userRepo->findUserById($args['id']);
  }

  /**
   * return all user in DB.
   */
  public function users(Request $req, Response $res, $args) {
    return $this->userRepo->users();
  }

  /**
   * used to add user in DB.
   */
  public function addUser(Request $req, Response $res, $args) {

  }


  /**
   * return user by his credential.
   */
  public function login(Request $req, Response $res, $args) {
    $credential = $req->getQueryParams();
    //var_dump($credential['login']);
    //var_dump($credential['password']);
    if( !isset($credential, $credential['login'], $credential['password']) )
      return null;

    return $this->userRepo->login($credential['login'], $credential['password']);
  }

}