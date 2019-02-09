<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My profile</title>
  <style>
    p {
      display: inline;
    }
  </style>
</head>
<body>
<?php require __DIR__.'/../Core/menu.php'; ?>
<h1>Profile of <?php echo $this->data['role'] ?></h1>
<div>
  <p>Login: </p>
  <p><?php echo $this->data['user']['login'] ?></p>
</div>
<div>
  <p>First name: </p>
  <p><?php echo $this->data['user']['first_name'] ?></p>
</div>
<div>
  <p>Last name: </p>
  <p><?php echo $this->data['user']['last_name'] ?></p>
</div>

</body>
</html>
