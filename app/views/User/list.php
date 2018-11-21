<!DOCTYPE html>
<html>
<head></head>
<body>

<table width="100%" cellspacing="0" border="1" style="text-align: center">
    <tr>
        <th>Id</th>
        <th>Login</th>
        <th>Password</th>
        <th>Roles</th>
    </tr>
    <h1>Users:<?php echo count($users)?></h1>
    <?php foreach ($users as $user){ ?>
        <tr>
            <td><?php echo $user['id'] ?></td>
            <td><?php echo $user['login']?></td>
            <td><?php echo $user['password']?></td>
            <td><?php echo implode(', ',json_decode($user['roles']));}?></td>
        </tr>
</body>
</html>