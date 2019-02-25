<!DOCTYPE html>
<html>
<head>
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
  <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
  <link href="/css/messages_style.css" type="text/css" rel="stylesheet">
  <link href="/css/class_list_style.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <title>Classes</title>
</head>
<body>
<?php use Enum\RolesEnum;

require __DIR__.'/../Core/menu.php'; ?>
<div class="wrap">
  <div class="title">
    <h1>Classes</h1>
          <?php require __DIR__.'/../Core/messages.php'; ?>

      <?php if ($this->data['role'] === RolesEnum::ADMIN) { ?>
        <a href="/app.php/classes/create"><i class="far fa-plus-square"></i> Add class</a> <?php } ?>
  </div>
  <div class="list">
    <div class="row head">
      <div>Class name</div>
      <div></div>
      <div></div>
    </div>
      <?php foreach ($this->data['classes'] as $class) { ?>
        <div class="row">
          <div><a href="<?php echo '/classes/'.$class['id'] ?>" class="class_link"><?php echo $class['title'] ?></a></div>
          <div>
            Students: <?php echo $this->data['countOfUsers'][$class['id']]['students']; ?>
            Teachers: <?php echo $this->data['countOfUsers'][$class['id']]['teachers']; ?>
          </div>
          <div class="buttons">
              <?php if ($this->data['role'] === RolesEnum::TEACHER) {
              if ($this->data['enrollmentModel']->isEnrollment($this->data['currentUserId'], $class['id'])) { ?>
                <a href="<?php echo '/classes/'.$class['id'].'/leave-class' ?>"><?php echo 'Leave class' ?></a>
              <?php } else { ?>
            <a href="<?php echo '/classes/'.$class['id'].'/join-class' ?>"><?php echo 'Join class';
                }
                } ?></a>
              <?php if ($this->data['role'] === RolesEnum::ADMIN) { ?>
                <a href="/classes/<?php echo $class['id']; ?>/edit" class="edit_button"><i class="far fa-edit"></i>Edit</a>
                <a href="/classes/<?php echo $class['id']; ?>/delete" class="delete_button"><i class="fas fa-minus-circle"></i>Delete</a>
              <?php } ?>
          </div>
        </div>
      <?php } ?>
  </div>
</div>

<?php require __DIR__.'/../Core/footer.html'; ?>
</body>
</html>