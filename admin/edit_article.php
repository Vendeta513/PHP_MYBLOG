<?php

  require("../includes/init.php");

  Auth::requiredLogIn();

  $conn = require("../includes/db.php");

  if (isset($_GET['id'])) {
    $article = Article::getById($conn, $_GET['id']);

    if( ! $article) {
      die("article not found");
    }
  }else{
    die("ID not supplied, article not found");
  }

  $category_ids = array_column($article->getCategories($conn), 'id');
  $categories = Category::getAll($conn);


  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $article->title = $_POST['title'];
    $article->content = $_POST['content'];
    $article->published_at = $_POST['published_at'];
    $category_ids = $_POST['category'] ?? [];




    if($article->update($conn)){
      $article->setCategories($conn, $category_ids);
      Url::redirect("/admin/article.php?id={$article->id}");
    }
  }
?>

<?php require("../includes/header.php")?>


  <h2>Edit Article</h2>

  <?php require("includes/form_article.php")?>

<?php require("../includes/footer.php")?>
