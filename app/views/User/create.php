<?php $isCreate = !isset($this->data['user']); ?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<a href="/app.php/users">Users List</a>
<br>
<h1><?php echo  $isCreate? 'Create User':'Edit User'; ?></h1>
<div class="errors-wrap">
    <?php
    $form = $this->data['form'];
    foreach ($form->getViolations() as $key => $violation) { ?>
        <div class="error-item"><?php echo $violation; ?></div>
    <?php } ?>
</div>

<form method="post">
    <input type="text" name="login" placeholder="Login" required value="<?php echo $form->getData()['login']; ?>">
    <input type="password" name="plain_password" placeholder="password" <?php if ($isCreate) echo 'required'?>>
    <input type="password" name="plain_password_confirm" placeholder="confirm password" <?php if ($isCreate) echo 'required'?>>
    <input type="text" name="first_name" placeholder="First Name" required value="<?php echo $form->getData()['first_name']; ?>">
    <input type="text" name="last_name" placeholder="Last Name" required value="<?php echo $form->getData()['last_name']; ?>">

    <select name="role" required>
        <option value=""></option>
        <?php foreach (\Enum\RolesEnum::getAll() as $role) { ?>
            <option value="<?php echo $role ?>"
                <?php if ($role === $form->getData()['role']) {echo 'selected';} ?>>
                <?php echo $role ?>
            </option>
        <?php } ?>
    </select>
    <button type="submit" name="submit">Accept</button>
</form>
</body>
</html>