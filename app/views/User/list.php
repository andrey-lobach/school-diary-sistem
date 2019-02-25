<!DOCTYPE html>
<html>
<head>
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
  <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
  <link href="/css/messages_style.css" type="text/css" rel="stylesheet">
  <link href="/css/user_list_style.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
   <title>Users</title>
</head>
<body>
<?php require __DIR__.'/../Core/menu.php'; ?>

<div class="wrap">
<div class="title">
  <h1>Users list</h1>
  <?php require __DIR__.'/../Core/messages.php'; ?>
  <a href="/users/create" ><i class="fas fa-user-plus"></i>Add user</a>
</div>
  <div class="list">
    <div class="row head">
      <div>Login</div>
      <div>First Name</div>
      <div>Last Name</div>
      <div>Role</div>
      <div></div>
    </div>
    <?php foreach ($this->data['users'] as $user) { ?>
      <div class="row">
        <div><?php echo $user['login'] ?></div>
        <div><?php echo $user['first_name'] ?></div>
        <div><?php echo $user['last_name'] ?></div>
        <div><?php echo $user['role']; ?></div>
        <div class="buttons">
          <a href="/users/<?php echo $user['id']; ?>/edit" class="edit_button"><i class="fas fa-user-edit"></i> Edit</a>
          <a href="/users/<?php echo $user['id']; ?>/delete" class="delete_button"><i class="fas fa-user-times"></i>Delete</a>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
<?php require __DIR__.'/../Core/footer.html'; ?>
</body>
