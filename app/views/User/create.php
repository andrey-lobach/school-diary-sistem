<?php $isCreate = !isset($this->data['user']); ?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
  <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
  <link href="/css/user_form_style.css" type="text/css" rel="stylesheet">
  <link href="/css/errors_style.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <title></title>
</head>
<body>
<?php require __DIR__.'/../Core/menu.php'; ?>

<div class="wrap">

  <form method="post">
    <h1><?php echo $isCreate ? 'Create User' : 'Edit User'; ?></h1>
      <?php require __DIR__.'/../Core/form_errors.php'; ?>
  <label>Login:</label>
    <input type="text" name="login" placeholder="Login" required value="<?php echo $form->getData()['login']; ?>">
      <label>Password:</label>
      <input type="password" name="plain_password" placeholder="Password" <?php if ($isCreate)
        echo 'required' ?>>
      <label>Password confirm:</label>
      <input type="password" name="plain_password_confirm" placeholder="Confirm password" <?php if ($isCreate)
        echo 'required' ?>>
      <label>First Name:</label>
      <input type="text" name="first_name" placeholder="First Name" required value="<?php echo $form->getData(
    )['first_name']; ?>">
      <label>Last Name:</label>
      <input type="text" name="last_name" placeholder="Last Name" required value="<?php echo $form->getData(
    )['last_name']; ?>">

    <select name="role" required>
      <option value=""></option>
        <?php foreach (\Enum\RolesEnum::getAll() as $role) { ?>
          <option value="<?php echo $role ?>"
              <?php if ($role === $form->getData()['role']) {
                  echo 'selected';
              } ?>>
              <?php echo $role ?>
          </option>
        <?php } ?>
    </select>
    <button type="submit" name="submit"><?php echo $isCreate ? 'Create user' : 'Edit user'; ?></button>
  </form>
</div>
<?php require __DIR__.'/../Core/footer.html'; ?>
</body>
</html>