<?php require("../includes/init.php");?>

<?php Auth::requiredLogIn(); ?>
<!doctype html>
<html>
<?php require("../includes/header.php"); ?>

  <?php
    $conn = require("../includes/db.php");

    $paginator = new Paginator($_GET['page'] ?? 1, 3, Article::getTotal($conn));
    $articles = Article::getPage($conn, $paginator->limit, $paginator->offset);
  ?>

  <h2>Administration</h2>

  <a href="new_article.php">New article</a>

  <?php if(empty($articles)): ?>
    <p>No articles found.</p>
  <?php else: ?>
    <table class="table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Published</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($articles as $article): ?>
          <tr>
              <td><a href="article.php?id=<?= $article["id"]?>"><?= htmlspecialchars($article['title']);?></a></td>
              <td>
                <?php if($article['published_at']): ?>
                  <time><?= $article['published_at']; ?></time>
                <?php else: ?>
                  Unpublished
                  <button class="publish" data-id="<?= $article['id']; ?>">Publish</button>
                <?php endif;?>
              </td>
          </tr>

        <?php endforeach; ?>
      </tbody>
    </table>
    <?php require("../includes/pagination.php")?>
  <?php endif; ?>
<?php require("../includes/footer.php"); ?>

</html>
