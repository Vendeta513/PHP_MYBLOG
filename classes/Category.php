<?php
  /**
  * Categories for grouping articles
  */
  class Category {
    /**
    * Get all the categories
    * @param object $conn, connection to the database
    * @return array, an associative array of all the categories
    */
    public static function getAll($conn) {
      $sql = "SELECT *
              FROM category
              ORDER BY name";

      $stmt = $conn->query($sql);

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }
