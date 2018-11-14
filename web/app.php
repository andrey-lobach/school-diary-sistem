
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<table width="100%" cellspacing="0" border="1">
    <tr>
        <th>Id</th>
        <th>Login</th>
        <th>Password</th>
        <th>Roles</th>
    </tr>
    <?php
        require './../app/Kernel.php';
        $kernel = new Kernel;
        $result = $kernel->getConnection()->fetchAll('select * from users');
        foreach($result as $user) {
            echo '<tr>';
            echo '<td>'.$user['id'].'</td>';
            echo '<td>'.$user['login'].'</td>';
            echo '<td>'.$user['password'].'</td>';
            echo '<td>'.json_encode($user['roles']).'</td>'; //пока не очень понимаю про json
            echo '</tr>';
        }
    ?>
</table>
</body>
</html>


