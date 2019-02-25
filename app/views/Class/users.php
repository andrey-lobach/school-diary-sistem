<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
  <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
  <link href="/css/class_users_style.css" type="text/css" rel="stylesheet">
  <link href="/css/messages_style.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <title>Class list</title>
</head>
<body>
<?php use Enum\RolesEnum;

require __DIR__.'/../Core/menu.php'; ?>
<div class="wrap">
  <div class="title">
    <h1>Class: <?php echo $this->data['class']['title'] ?></h1>

      <?php require __DIR__.'/../Core/messages.php';
      if ($this->data['role'] === RolesEnum::TEACHER || $this->data['role'] === RolesEnum::ADMIN) { ?>
        <a href="<?php echo '/classes/'.$this->data['class']['id'].'/add-student' ?>">Add students to class</a>
          <?php if ($this->data['role'] === RolesEnum::ADMIN) { ?>
          <a href="<?php echo '/classes/'.$this->data['class']['id'].'/add-teacher' ?>">Add teachers to
            class</a> <?php }
      } ?>
  </div>
  <div class="students">
    <h3>Students:</h3>
      <?php foreach ($this->data['list']['students'] as $student) { ?>
        <div class="row">
          <div><?php echo $this->data['userModel']->getUser($student['user_id'])['first_name'] ?></div>
          <div><?php echo $this->data['userModel']->getUser($student['user_id'])['last_name']; ?></div>
            <?php if ($this->data['role'] !== RolesEnum::STUDENT) { ?>
              <div>
              <a class="delete_button" href="<?php echo '../enrollment/'.$student['user_id'].'/'.$this->data['class']['id'].'/delete' ?>"><i class="fas fa-user-minus"></i>Remove
              </a> </div><?php } ?>

        </div> <?php } ?>
  </div>
  <div class="teachers">
    <h3>Teachers:</h3>
      <?php foreach ($this->data['list']['teachers'] as $teacher) { ?>
        <div class="row">
          <div><?php echo $this->data['userModel']->getUser($teacher['user_id'])['first_name'] ?></div>
          <div><?php echo $this->data['userModel']->getUser($teacher['user_id'])['last_name']; ?> </div>
          <?php if ($this->data['role'] === RolesEnum::ADMIN) { ?>
            <div><a class="delete_button" href="<?php echo '../enrollment/'.$teacher['user_id'].'/'.$this->data['class']['id'].'/delete' ?>"><i class="fas fa-user-minus"></i>Remove
            </a></div><?php } ?>

        </div> <?php } ?>
  </div>
</div>
<?php require __DIR__.'/../Core/footer.html'; ?>
</body>
</html>