<?php

  require("../includes/init.php");
  Auth::requiredLogIn();
  $conn = require("../includes/db.php");

    if (isset($_GET['id'])) {
      $article = Article::getById($conn, $_GET['id'], 'id');

      if(! $article) {
        die("article not found");
      }
    }else{
      die("ID not supplied, article not found");
    }
    if($_SERVER["REQUEST_METHOD"] == "POST") {

        if($article->delete($conn)) {
          Url::redirect("/admin/index.php");
        }
    }
  ?>

  <?php require("../includes/header.php"); ?>

    <h2>Delete article</h2>
    <p>Are you sure?</p>
    <form method="post">
      <button>Delete</button>
      <a href="article.php?id=<?= $article->id; ?>">Cancel</a>
    </form>

  <?php require("../includes/footer.php"); ?>
