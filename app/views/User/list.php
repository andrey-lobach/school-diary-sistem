<!DOCTYPE html>
<html>
<head>
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
  <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body>
<?php require __DIR__.'/../Core/menu.php'; ?>
<h1>Users</h1>
<a href="/users/create">Create new user</a>
<?php require __DIR__.'/../Core/messages.php'; ?>
<table width="100%" cellspacing="0" style="text-align: center">
    <thead>
    <tr>
        <th>Login</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Role</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->data['users'] as $user) { ?>
        <tr>
            <td><?php echo $user['login'] ?></td>
            <td><?php echo $user['first_name'] ?></td>
            <td><?php echo $user['last_name'] ?></td>
            <td><?php echo $user['role']; ?></td>
            <td>
                <a href="/users/<?php echo $user['id']; ?>/edit">Edit</a>
                <a href="/users/<?php echo $user['id']; ?>/delete">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php require __DIR__.'/../Core/footer.html'; ?>
</body>
