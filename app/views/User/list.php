<!DOCTYPE html>
<html>
<head></head>
<body>

<table width="100%" cellspacing="0" style="text-align: center">
    <tr>
        <th>Id</th>
        <th>Login</th>
        <th>Password</th>
        <th>Roles</th>
        <th></th>
    </tr>
    <h1>Users:<?php echo count($this->data['users']); ?></h1>
    <?php foreach ($this->data['users'] as $user){?>
        <tr>
            <td><?php echo $user['id'] ?></td>
            <td><?php echo $user['login']?></td>
            <td><?php echo $user['password']?></td>
            <td><?php echo implode(', ',json_decode($user['roles']));?></td>
            <td>
                <a href="/app.php/users/<?php echo $user['id']; ?>/edit">Edit</a>
                <a href="/app.php/users/<?php echo $user['id']; ?>/delete">Delete</a>
            </td>
        </tr>
    <?php } ?>
</body>
</html>
