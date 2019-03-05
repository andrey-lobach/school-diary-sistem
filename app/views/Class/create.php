<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
  <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
  <link href="/css/errors_style.css" type="text/css" rel="stylesheet">
  <link href="/css/class_form_style.css" type="text/css" rel="stylesheet">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <title>Create class</title>
</head>
<body>
<?php require __DIR__.'/../Core/menu.php'; ?>
<div class="wrap">
  <form method="post">
    <h1><?php echo isset($this->data['class']) ? 'Edit Class' : 'Create Class'; ?></h1>
      <?php require __DIR__.'/../Core/form_errors.php'; ?>
      <label>Title:</label>
    <input type="text" name="title" placeholder="Title" required value="<?php echo $form->getData()['title']; ?>">
    <button type="submit" name="submit">Accept</button>
  </form>
</div>
<?php require __DIR__.'/../Core/footer.html'; ?>
</body>
</html>