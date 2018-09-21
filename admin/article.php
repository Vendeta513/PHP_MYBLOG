<?php
  require("../includes/init.php");

  Auth::requiredLogIn();

  $conn = require("../includes/db.php");

  if (isset($_GET['id'])) {
    $article = Article::getWithCategories($conn, $_GET['id']);
  } else {
    $article = null;
  }
?>


<?php require("../includes/header.php");?>
  <?php if($article): ?>
    <ul>
      <li>
        <article>
          <h2><?= htmlspecialchars($article[0]['title']); ?></h2>  <!--keeping input as is, not be evaluated.-->
          <?php if($article[0]['published_at']): ?>
            <time><?= $article[0]['published_at']; ?></time>
          <?php else: ?>
            Unpublished
          <?php endif; ?>
          <?php if($article[0]['category_name']): ?>
            <p>
              Categories:
              <?php foreach($article as $a): ?>
                <?= htmlspecialchars($a['category_name']); ?>
              <?php endforeach; ?>
            </p>
          <?php endif;?>
          <?php if($article[0]['image_file']): ?>
            <img src="/uploads/<?= $article[0]['image_file']; ?>"/>
          <?php endif;?>
          <p><?= htmlspecialchars($article[0]['content']); ?></p>
        </article>
        <a href="edit_article.php?id=<?= $article[0]['id']; ?>">Edit</a>
        <a class="delete" href="delete_article.php?id=<?= $article[0]['id']; ?>">Delete</a>
        <a href="edit_article_image.php?id=<?= $article[0]['id'];?>">Edit Image</a>
      </li>
    </ul>
  <?php else: ?>
    <p>Article not found.</p>
  <?php endif; ?>
<?php require("../includes/footer.php")?>
