<?php
  /*
  * Log in, log out function;
  * Response method;
  */
  class Url
  {
    /*
    * @param $path address of the URL to be redirected.
    */

    public static function redirect($path) {
      if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
        $protocol = 'https';
      }else {
        $protocol = 'http';
      }

      header("Location: $protocol://" . $_SERVER['HTTP_HOST'] . $path);
      exit;
    }
  }
