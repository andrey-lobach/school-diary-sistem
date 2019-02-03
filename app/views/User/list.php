<!DOCTYPE html>
<html>
<head></head>
<body>
<h1>Users</h1>
<a href="/users/create">Create new user</a>
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
</body>
