<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">

  <title>My profile</title>

</head>
<body>
<?php require __DIR__.'/../Core/menu.php'; ?>
<h1>Profile of <?php echo $this->data['role'] ?></h1>
<div class="profile-block">
  <div class="profile-row">
    <div class="profile-label">Login:</div>
    <div class="profile-info"><?php echo $this->data['user']['login'] ?></div>
  </div>
  <div class="profile-row">
    <div class="profile-label">First name:</div>
    <div class="profile-info"><?php echo $this->data['user']['first_name'] ?></div>
  </div>
  <div class="profile-row">
    <div class="profile-label">Last name:</div>
    <div class="profile-info"><?php echo $this->data['user']['last_name'] ?></div>
  </div>
</div>
</body>
</html>
