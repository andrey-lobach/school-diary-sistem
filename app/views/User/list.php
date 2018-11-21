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
    <?php
    echo '<h1>Users: '.count($users).'</h1>';
    foreach ($users as $user){
        echo '<tr>';
        echo '<td>'.$user['id'].'</td>';
        echo '<td>'.$user['login'].'</td>';
        echo '<td>'.$user['password'].'</td>';
       /* foreach (json_decode($user['roles']) as $role)
        {
            echo '<td>'.$role.'</td>';
        }
       */
       echo '<td>'.$user['roles'].'</td>';
       echo '</tr>';
    }
    ?>
</body>
</html>