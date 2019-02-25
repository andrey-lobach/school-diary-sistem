<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
  <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
  <link href="/css/login_style.css" type="text/css" rel="stylesheet">
  <link href="/css/errors_style.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <title>Electronic diary system</title>
</head>
<body>

<?php require __DIR__.'/../Core/menu.php'; ?>
<div class="wrap">
  <h1>Electronic diary system</h1>
  <div class="login">
    <h1>Log in</h1>
      <?php require __DIR__.'/../Core/form_errors.php'; ?>
    <form method="post">
      <input type="text" name="login" placeholder="Login" required value="<?php echo $form->getData()['login']; ?>">
      <input type="text" name="password" placeholder="Password" required>
      <button type="submit" name="submit">Log in</button>
    </form>
  </div>
</div>
<?php require __DIR__.'/../Core/footer.html'; ?>
</body>
</html>