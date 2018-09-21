<?php

  require("includes/init.php");
  $conn = require("includes/db.php");

  if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(User::authenticate($conn, $_POST['username'], $_POST['password'])) {

      Auth::login();
      Url::redirect("/");

    }else {
      $error = "incorrect log in.";
    }
  }
?>


<?php require("includes/header.php"); ?>

<?php if(! empty($error)): ?>
  <p><?= $error ?></p>
<?php endif; ?>

<h2>Log in</h2>
<form method="post">
  <div class="form-group">
    <label for="name">Name:</label>
    <input type="text" name="username" id="name" class="form-control">
  </div>
  <div class="form-group">
    <label for="pass">Password:</label>
    <input type="password" name="password" id="pass" class="form-control">
  </div>

  <button class="btn btn-primary">Log in</button>

</form>
<?php require("includes/footer.php"); ?>
