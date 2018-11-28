<?php

$data = $_POST;
$login = $data['login'];
$password = $data['password'];
foreach ($users as $user)
{
    if ($login === $user['login'])
    {
        echo 'such login exists';
        break;
    }
}
$arr=[];
preg_match_all('/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{6,}/', $password, $arr);
if ($password !== $arr[0][0])
    echo 'Password must contain at least 1 uppercase letter, 1 lowercase letter and 1 digit';


?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
</head>
<body>
<h1>Add user</h1>
<!--TODO show errors -->
<form method="post" action="/app.php/users/create">
    <!-- return field value -->
    <input type="text" name="login" placeholder="login" required>
    <input type="password" name="password" placeholder="password" required>
    <select name="roles" multiple required>
        <option value=""></option>
        <?php foreach (\Enum\RolesEnum::getAll() as $role) { ?>
            <!-- TODO if in array => selected-->
        <option value="<?php echo $role ?>"><?php echo $role ?></option>
        <?php } ?>
    </select>
    <button type="submit" name="submit">Create</button>
</form>
</body>
</html>
