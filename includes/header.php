<head>
  <title>My Blog</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/jquery.datetimepicker.min.css" />

  <link rel="stylesheet" href="/css/styles.css"/>
</head>

<body>
  <div class="container">
    <header>
      <h1>My Blog</h1>
      <nav>
        <ul class="nav">
          <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
          <?php if(Auth::isLoggedIn()):?>
            <li class="nav-item"><a class="nav-link" href="/admin/">Admin</a></li>
            <li class="nav-item"><a class="nav-link" href="/logout.php">Logout</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="/login.php">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="/signup.php">Sign Up</a></li>
          <?php endif;?>
          <li class="nav-item"><a class="nav-link" href="/contact.php">Contact</a></li>


        </ul>
      </nav>
    </header>
