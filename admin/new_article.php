<?php

  require("../includes/init.php");

  Auth::requiredLogIn();

  $conn = require("../includes/db.php");

  $category_ids = [];
  $categories = Category::getAll($conn);


  $article = new Article();

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    $article->title = $_POST['title'];
    $article->content = $_POST['content'];
    $article->published_at = $_POST['published_at'];
    $category_ids = $_POST['category'] ?? [];


    if($article->create($conn)) {
        $article->setCategories($conn, $category_ids);
        Url::redirect("/admin/article.php?id={$article->id}");
    }
  }
?>


<?php require("../includes/header.php")?>


  <h2>New Article</h2>

  <?php require("includes/form_article.php")?>

<?php require("../includes/footer.php")?>
