<?php

  require("../includes/init.php");

  Auth::requiredLogIn();

  $conn = require("../includes/db.php");

  if (isset($_GET['id'])) {
    $article = Article::getById($conn, $_GET['id']);

    if(!$article) {
      die("article not found");
    }
  } else {
    die("ID not supplied, article not found");
  }

  if($_SERVER['REQUEST_METHOD'] == "POST") {
    $previous_image = $article->image_file;

    if($article->setImageFile($conn, null)) {
      if($previous_image) {
        unlink("../uploads/$previous_image");

        Url::redirect("/admin/article.php?id={$article->id}");
      }
    }
  }
?>

<?php require("../includes/header.php")?>

  <h2>Delete article image</h2>
    <form method="post">
      <div>
        <p>Are you sure?</p>
      </div>
      <button>Delete</button>
    </form>

<?php require("../includes/footer.php")?>
