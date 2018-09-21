<?php

class User
{
  /*
  * Unique identifier;
  * @var integer;
  */
  public $id;

  /*
  * unique username;
  * @var string;
  */
  public $username;

  /*
  * user password;
  * @var string;
  */
  public $password;

  public $errors = [];

/*
* validate the credential of the user from the database
* @param $conn OBJECT, connection to the database;
* @param $username STRING, name of the user;
* @param $password STRING, password of the user;
* @return true if the password match with the user's password;
*/
  public static function authenticate($conn, $username, $password) {
    $sql = "SELECT *
            FROM user
            WHERE username = :username";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':username', $username, PDO::PARAM_STR);

    $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');

    $stmt->execute();

    if($user = $stmt->fetch()) {
      return password_verify($password, $user->password);
    }
  }

  public static function getAllUsers($conn) {
    $sql = "SELECT *
            FROM user
            ORDER BY id";
    $stmt = $conn->query($sql);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function create($conn) {
    if($this->validate()) {
      $sql = "INSERT INTO user(username, password)
              VALUES (:username, :password)";

      $stmt = $conn->prepare($sql);

      $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);

      $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);

      try {
        $stmt->execute();
        return true;
      }catch(PDOException $e) {
        if($e->errorInfo[1] == 1062) {
          $this->errors[] = "Username is already in used";
        }
      }
    }else {
      return false;
    }
  }

  protected function validate() {
    if($this->username == '') {
      $this->errors[] = "Username is required.";
    }
    if($this->password == '') {
      $this->errors[] = "Password is required";
    }
    return empty($this->errors);
  }
}
