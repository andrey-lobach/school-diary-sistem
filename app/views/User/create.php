<?php
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
</head>
<body>
<h1>Add user</h1>
<form method="post" action="/app.php/users/create">
    <input type="text" name="login" placeholder="login" required>
    <input type="password" name="password" placeholder="password" required>
    <select name="roles" multiple required>
        <option value=""></option>
        <?php foreach (\Enum\RolesEnum::getAll() as $role) { ?>
        <option value="<?php echo $role ?>"><?php echo $role ?></option>
        <?php } ?>
    </select>
    <button type="submit">Create</button>
</form>
</body>
</html>
