<!DOCTYPE html>
<html>
<head>
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
  <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
  <link href="/css/messages_style.css" type="text/css" rel="stylesheet">
  <link href="/css/user_list_style.css" type="text/css" rel="stylesheet">
  <link href="/css/errors_style.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <title>Users</title>
</head>
<body>

<?php require __DIR__.'/../Core/menu.php';
$data = $this->data['form']->getData(); ?>

<div class="wrap">
  <div class="title">
    <h1>Users list</h1>
      <?php require __DIR__.'/../Core/messages.php'; ?>
    <a href="/users/create"><i class="fas fa-user-plus"></i>Add user</a>
  </div>
  <form method="get">
    <div class="filter">
        <?php require __DIR__.'/../Core/form_errors.php'; ?>
      <input type="text" class="filter_value" name="filter_value">
      <input class="filter_field" name="filter_field" value="" hidden>
      <input class="filter_direction" name="filter_direction" value="" hidden>
      <button type="submit" class="submit_button">Filter</button>
    </div>

    <div class="list">
      <div class="head">
        <div class="fields">
          <div id="login" class="<?php if ($data['filter_field'] === 'login') {
              if ($data['filter_direction'] === 'asc') {
                  echo 'asc';
              } else {
                  echo 'desc';
              }
          } ?>">Login
          </div>
          <div id="first_name" class="<?php if ($data['filter_field'] === 'first_name') {
              if ($data['filter_direction'] === 'asc') {
                  echo 'asc';
              } else {
                  echo 'desc';
              }
          } ?>">First Name
          </div>
          <div id="last_name" class="<?php if ($data['filter_field'] === 'last_name') {
              if ($data['filter_direction'] === 'asc') {
                  echo 'asc';
              } else {
                  echo 'desc';
              }
          } ?>">Last Name
          </div>
          <div id="role" class="<?php if ($data['filter_field'] === 'role') {
              if ($data['filter_direction'] === 'asc') {
                  echo 'asc';
              } else {
                  echo 'desc';
              }
          } ?>">Role
          </div>
        </div>
      </div>
        <?php foreach ($this->data['users'] as $user) { ?>
          <div class="row">
            <div><?php echo $user['login'] ?></div>
            <div><?php echo $user['first_name'] ?></div>
            <div><?php echo $user['last_name'] ?></div>
            <div><?php echo $user['role']; ?></div>
            <div class="buttons">
              <a href="/users/<?php echo $user['id']; ?>/edit" class="edit_button"><i class="fas fa-user-edit"></i> Edit</a>
              <a href="/users/<?php echo $user['id']; ?>/delete" class="delete_button"><i class="fas fa-user-times"></i>Delete</a>
            </div>
          </div>
        <?php } ?>
      <div class="row end">
        <div></div>
        <div>
          <label>Per page</label>

          <select name="per_page" class="per_page_select">
            <option <?php if ((int) $data['per_page'] === 5) {
                echo 'selected';
            } ?>>5
            </option>
            <option <?php if ((int) $data['per_page'] === 10) {
                echo 'selected';
            } ?>>10
            </option>
            <option <?php if ((int) $data['per_page'] === 20) {
                echo 'selected';
            } ?>>20
            </option>
          </select>
        </div>
      </div>
    </div>
  </form>
</div>
<?php require __DIR__.'/../Core/footer.html'; ?>
<script type="text/javascript" src="/js/filter.js"></script>
</body>
