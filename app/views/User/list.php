<!DOCTYPE html>
<html>
<head></head>
<body>
<h1>Users</h1>
<a href="/app.php/users/create">Create new user</a>
<table width="100%" cellspacing="0" style="text-align: center">
    <thead>
    <tr>
        <th>Id</th>
        <th>Login</th>
        <th>Password</th>
        <th>Roles</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->data['users'] as $user) { ?>
        <tr>
            <td><?php echo $user['id'] ?></td>
            <td><?php echo $user['login'] ?></td>
            <td><?php echo $user['password'] ?></td>
            <td><?php echo implode(', ', $user['roles']); ?></td>
            <td>
                <a href="/app.php/users/<?php echo $user['id']; ?>/edit">Edit</a>
                <a href="/app.php/users/<?php echo $user['id']; ?>/delete">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
