<?php

  class Auth

    /*
    * @return TRUE if log in otherwise false.
    */
  {
    public static function isLoggedIn() {
      return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
    }


    /*
    * required to log in first before access to adding new article.
    * return void;
    */
    public static function requiredLogIn() {
      if(! static::isLoggedIn()) {
        die('unauthorized');
      }
    }

    /*
    * log in using the session.
    * @return void;
    */
    public static function login() {
      session_regenerate_id(true);
      $_SESSION['is_logged_in'] = true;
    }

    /*
    * logout using session;
    * @return void;
    */

    public static function logout() {
      $_SESSION = [];

      if(ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();

        setcookie(
          session_name(),
          '',
          time() - 42000,
          $params["path"],
          $params["domain"],
          $params["secure"],
          $params["httponly"]
        );
      }

      session_destroy();
    }
  }
