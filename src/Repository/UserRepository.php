<?php

namespace App\Repository;

use App\Entity\User;

/**
 * UserRepo... for SQL ACCESS
 */
class UserRepository extends Repository
{

  /**
   * Contruct a new UserRepo... by the \PDO set in BaseRepository
   * @param \PDO 
   */
  public function __construct(\PDO $db) {
    $this->db = $db;
    $this->repo = 'user';
  }

  /**
   * @param limit:integer
   * @param order:integer
   * @return mixed (JSONObject)
   */
  public function users() {
    $sql = sprintf("SELECT * FROM %s ORDER BY username ASC", $this->getRepo());
    $stm = $this->db->query($sql);

    $obj_a = [];
    while ( $obj = $stm->fetch() ) {
      $obj_a[]  = new User($obj); 
    }

    if( !isset($obj_a, $obj_a[0]) ) {
      $this->err = true;
      $this->msg = "No Users in DB";
      return $this->JSONObject($obj_a);
    }
    
    $this->err = false;
    $this->msg = count($obj_a) . " user(s) from DB.";
    return $this->JSONObject($obj_a);
  }

  public function findUserById($id) {
    $sql = sprintf("SELECT * FROM %s WHERE id=:id", $this->getRepo());
    $stm = $this->db->prepare($sql);
    $stm->bindParam('id', $id, \PDO::PARAM_INT);
    $stm->execute();

    $obj_a = [];
    while ( $obj = $stm->fetch() ) {
      $obj_a[]  = new User($obj); 
    }

    if( !isset($obj_a, $obj_a[0]) ) {
      $this->err = true;
      $this->msg = "User identify by id=$id doesn't exist.";
      return $this->JSONObject($obj_a);
    }
    
    $this->err = false;
    $this->msg = "User identify by id=$id exists.";
    return $this->JSONObject($obj_a);
  }

  public function findUserByEmail($email) {
    $stm = null;
    $obj_a = [];
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $sql = sprintf("SELECT * FROM %s WHERE email=:email", $this->getRepo());
      $stm = $this->db->prepare($sql);
      $stm->bindParam('email', $email, \PDO::PARAM_STR);
      $stm->execute();
      while ( $obj = $stm->fetch() ) {
        $obj_a[]  = new User($obj); 
      }
    }

    if( !isset($obj_a, $obj_a[0]) ) {
      $this->err = true;
      $this->msg = "Bad Email. Look wether the email format is good or not. Also verify that user exists";
      return $this->JSONObject($obj_a);
    }
    
    $this->err = false;
    $this->msg = "Email is Good.";
    return $this->JSONObject($obj_a);
  }


  public function findUserByName($username) {
    $sql = sprintf("SELECT * FROM %s WHERE username=:username", $this->getRepo());
    $stm = $this->db->prepare($sql);
    $stm->bindParam('username', $username, \PDO::PARAM_STR);
    $stm->execute();
    $obj_a = [];

    while ( $obj = $stm->fetch() ) {
      $obj_a[]  = new User($obj); 
    }

    if( !isset($obj_a, $obj_a[0]) ) {
      $this->err = true;
      $this->msg = "Bad Name given or user with this name doesn't exist in DB";
      return $this->JSONObject($obj_a);
    }
    
    $this->err = false;
    $this->msg = "Credential is Good.";

    return $this->JSONObject($obj_a);
  }

  /**
   * @param login:string
   * @param password:string
   * @return user:mixed (JSONObject)
   */
  public function findUserByCredential($username, $password) {
    $sql = sprintf("SELECT * FROM %s WHERE (username=? OR email=?) AND password=?", $this->getRepo());
    $stm = $this->db->prepare($sql);
    $stm->execute([$username, $username, $password]);

    $obj_a = [];
    while ( $obj = $stm->fetch() ) {
      $obj_a[]  = new User($obj); 
    }

    if( !isset($obj_a, $obj_a[0]) ) {
      $this->err = true;
      $this->msg = "Bad Credentials given";
      return $this->JSONObject($obj_a);
    }
    
    $this->err = false;
    $this->msg = "Credentials are Good.";
    return $this->JSONObject($obj_a);
  }

  /**
   * @param login:string
   * @param password:mixed
   */
  public function login($login, $password) {
    return $this->findUserByCredential($login, $password);
  }

  /**
   * @Deprecate
   */
  public function logout() {

  }

  /**
   * @param user:string (JSONObject)
   * @return user:mixed (JSONObject)
   */
  public function findUser($user) {
    $this->findUserByCredential($user->email, $user->password);
  }


  /**
   * 
   * @param int
   * @return int
   */
  public function deleteUser($id) {
    $sql = sprintf("DELETE %s WHERE id=:id", $this->getRepo());
    $stm = $this->db->prepare($sql);
    $stm->bindParam('id', $id, \PDO::PARAM_INT);
    $stm->execute();

    $row = $stm->rowCount();
    if($stm->closeCursor()) {
      return $row;
    }
    return null;
  }

  /**
   * @param id:integer
   * @param user:string (JSONOject)
   * @return row:integer
   */
  public function updateUser($id, $user) {
    $sql = sprintf("UPDATE %s SET username=:username, email=:email, password=:pass WHERE id=:id", $this->getRepo());
    $stm = $this->db->prepare($sql);
    $stm->bindParam('id', $id, \PDO::PARAM_INT);
    $stm->bindParam('username', $user->getUsername(), \PDO::PARAM_STR);
    $stm->bindParam('email', $user->getEmail(), \PDO::PARAM_STR);
    $stm->bindParam('pass', $user->getPassword(), \PDO::PARAM_STR);
    $stm->execute();

    if($stm->closeCursor()) {
      return $this->db->lastInsertId();
    }
    return null;
  }

  /**
   * Used to create a new user
   * @param user:mixed (JSONObject)
   * @return row:integer 
   */
  public function addUser($user) {
    $sql = sprintf("INSERT INTO %s VALUES(null,?,?,?)", $this->getRepo());
    $stm = $this->db->prepare($sql);
    $stm->execute([$user->getUsername(), $user->getEmail(), $user->getPassword()]);

    if($stm->closeCursor()) {
      return $this->db->lastInsertId();
    }
    return null;
  }

}