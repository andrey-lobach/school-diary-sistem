<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
  <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
  <link href="/css/errors_style.css" type="text/css" rel="stylesheet">
  <link href="/css/enrollment_style.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <title>Enrollments</title>
</head>
<body>
<?php require __DIR__.'/../Core/menu.php';
$title = $this->data['class']['title'];
?>
<div class="wrap">
  <div class="title">
    <h3><?php if (count($this->data['availableUsers']) === 0) {
            echo 'No users can be added to '.$title.' class';
        } elseif ($this->data['teacher']) {
            echo 'Add teachers to '.$title.' class';
        } else {
            echo 'Add students to '.$title.' class';
        } ?></h3>
      <?php require __DIR__.'/../Core/form_errors.php'; ?>
    <a href="/classes/<?php echo $this->data['class']['id'] ?>">Back to <?php echo $title ?> class</a>
  </div>
  <?php if (count($this->data['availableUsers'])){?>
  <form method="post">
    <select name="user_ids[]" multiple required>
        <?php foreach ($this->data['availableUsers'] as $user) { ?>
          <option value="<?php echo $user['id'] ?>"><?php echo $user['first_name'].' '.$user['last_name'] ?></option><?php } ?>
    </select>
    <button type="submit" name="submit"><i class="fas fa-user-plus"></i> Accept</button>
  </form>
  <?php } ?>
</div>
<?php require __DIR__.'/../Core/footer.html'; ?>
</body>
</html>