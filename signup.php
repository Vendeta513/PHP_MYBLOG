<?php
  require("includes/init.php");

  $conn = require("includes/db.php");

  $user = new User();

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = '';

    $user->username = $_POST['username'];
    $user->password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $_POST['password'];

    if($user->create($conn)) {
        Auth::login();
        Url::redirect("/");
    }
  }
?>

<?php require("includes/header.php"); ?>
  <h1>Sign Up</h1>
  <?php if(! empty($user->errors)): ?>
    <ul>
      <?php foreach($user->errors as $error):?>
        <li><?= $error; ?></li>
      <?php endforeach;?>
    </ul>
  <?php endif;?>

  <form method="post" id="signUp">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" name="username" id="username" value="<?= htmlspecialchars($user->username); ?>" />
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" name="password" id="password"/>
    </div>

    <button class="btn btn-primary">Sign Up</button>
  </form>

<?php require("includes/footer.php"); ?>
