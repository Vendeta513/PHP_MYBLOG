<?php

  require("../includes/init.php");

  Auth::requiredLogin();

  $conn = require("../includes/db.php");

  $article = Article::getById($conn, $_POST['id']);

  $published_at = $article->publish($conn);

?>
<time><?= $published_at; ?></time>
