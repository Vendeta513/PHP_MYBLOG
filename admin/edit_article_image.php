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
    try {
      if(empty($_FILES)) {
        throw new Exception("Invalid upload");
      }
      switch($_FILES['image']['error']) {
        case UPLOAD_ERR_OK:
          break;
        case UPLOAD_ERR_NO_FILE:
          throw new Exception("No file uploaded");
          break;
        case UPLOAD_ERR_INI_SIZE:
          throw new Exception("File is too large(from the server settings)");
          break;
        default:
          throw new Exception("An error occured");
          break;
      }

      if($_FILES['image']['size'] > 4000000) {
        throw new Exception("File is too large.");
      }

      $mime_types = ['image/gif', 'image/png', 'image/jpeg'];

      $mime_resource = finfo_open(FILEINFO_MIME_TYPE);
      $mime_type = finfo_file($mime_resource, $_FILES['image']['tmp_name']);

      if(!in_array($mime_type, $mime_types)) {
        throw new Exception("Invalid file type");
      }

      $pathinfo = pathinfo($_FILES['image']['name']);
      $base = $pathinfo['filename'];
      $base = preg_replace('/[^a-zA-Z0-9_-]/', '_', $base);
      $base = mb_substr($base, 0, 200);

      $filename = $base . "." . $pathinfo['extension'];

      $destination = "../uploads/$filename";

      $i = 1;
      while(file_exists($destination)) {
        $filename = $base . "-$i." . $pathinfo['extension'];
        $destination = "../uploads/$filename";

        $i++;
      }

      if(move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
        $previous_image = $article->image_file;

        if($article->setImageFile($conn, $filename)) {
          if($previous_image) {
            unlink("../uploads/$previous_image");

            Url::redirect("/admin/article.php?id={$article->id}");
          }

          Url::redirect("/admin/article.php?id={$article->id}");
        }
      } else {
        throw new Exception("Unsuccessful");
      }
    } catch (Exception $e) {
      $error = $e->getMessage();
    }
  }
?>

<?php require("../includes/header.php")?>


  <h2>Edit Article Image</h2>

    <?php if(isset($error)):?>
      <p><?= $error; ?></p>
    <?php endif;?>
    <?php if($article->image_file):?>
      <img src="/uploads/<?= $article->image_file; ?>"/>
      <a class="delete" href="/admin/delete_article_image.php?id=<?= $article->id?>">Delete</a>
    <?php endif;?>

    <form method="post" enctype="multipart/form-data">
      <div>
        <label for="image">Image file</label>
        <input type="file" name="image" id="image" />
      </div>
      <button>Upload</button>
    </form>

<?php require("../includes/footer.php")?>
