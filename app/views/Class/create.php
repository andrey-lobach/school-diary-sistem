<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
  <title></title>
</head>
<body>
<?php require __DIR__.'/../Core/menu.php'; ?>
<a href="/classes">Classes List</a>
<br>
<h1><?php echo isset($this->data['class']) ? 'Edit Class' : 'Create Class'; ?></h1>
<?php require __DIR__.'/../Core/form_errors.php'; ?>

<form method="post">
  <input type="text" name="title" placeholder="title" required value="<?php echo $form->getData()['title']; ?>">
  <button type="submit" name="submit">Accept</button>
</form>
</body>
</html>