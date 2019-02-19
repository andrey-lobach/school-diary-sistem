<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
  <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
  <link href="/css/my_profile_style.css" type="text/css" rel="stylesheet">
  <link href="/css/errors_style.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <title>My profile</title>

</head>
<body>
<?php require __DIR__.'/../Core/menu.php'; ?>
<div class="wrap">

  <div class="profile-block">
    <h1>Profile of <?php echo $this->data['role'] ?></h1>
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
  <form method="post">
      <?php require __DIR__.'/../Core/form_errors.php'; ?>
    <h3>Change password</h3>
    <input placeholder="Current password" name="currentPassword" type="password">
    <input placeholder="New password" name="newPassword" type="password">
    <input placeholder="Confirm new password" name="passwordConfirm" type="password">
    <button type="submit">Change password</button>
  </form>
</div>
<?php require __DIR__.'/../Core/footer.html'; ?>
</body>
</html>
