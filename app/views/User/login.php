<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">

  <title></title>
</head>
<body>
<?php require __DIR__.'/../Core/menu.php'; ?>
<h1>Log in</h1>
<div class="errors-wrap">
    <?php
    $form = $this->data['form'];
    foreach ($form->getViolations() as $key => $violation) { ?>
      <div class="error-item"><?php echo $violation; ?></div>
    <?php } ?>
</div>
<form method="post">
  <input type="text" name="login" placeholder="login" required value="<?php echo $form->getData()['login']; ?>">
  <input type="text" name="password" placeholder="password" required>
  <button type="submit" name="submit">Accept</button>
</form>
</body>
</html>