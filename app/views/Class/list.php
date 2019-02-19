<!DOCTYPE html>
<html>
<head>
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
  <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</head>
<body>
<?php use Enum\RolesEnum;

require __DIR__.'/../Core/menu.php'; ?>
<h1>Classes</h1>
<?php if ($this->data['role'] === RolesEnum::ADMIN) { ?>
  <a href="/app.php/classes/create">Create new class</a> <?php } ?>
  <?php require __DIR__.'/../Core/messages.php'; ?>
<table width="100%" cellspacing="0" style="text-align: center">
  <thead>
  <caption></caption>
  <tr>
    <th>Class name</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($this->data['classes'] as $class) { ?>
    <tr>
      <td><a href="<?php echo '/classes/'.$class['id'] ?>"><?php echo $class['title'] ?></a></td>
      <td>
        Students: <?php echo $this->data['countOfUsers'][$class['id']]['students']; ?>
        Teachers: <?php echo $this->data['countOfUsers'][$class['id']]['teachers']; ?>
      </td>
      <td>
          <?php if ($this->data['role'] === RolesEnum::TEACHER) {
          if ($this->data['enrollmentModel']->isEnrollment($this->data['currentUserId'], $class['id'])) { ?>
            <a href="<?php echo '/classes/'.$class['id'].'/leave-class' ?>"><?php echo 'Leave class' ?></a>
          <?php } else { ?>
        <a href="<?php echo '/classes/'.$class['id'].'/join-class' ?>"><?php echo 'Join class';
            }
            } ?></a>
          <?php if ($this->data['role'] === RolesEnum::ADMIN) { ?>
            <a href="/classes/<?php echo $class['id']; ?>/edit">Edit</a>
            <a href="/classes/<?php echo $class['id']; ?>/delete">Delete</a>
          <?php } ?>
      </td>
    </tr>
  <?php } ?>
  </tbody>
</table>
<?php require __DIR__.'/../Core/footer.html'; ?>
</body>