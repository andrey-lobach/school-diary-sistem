<!DOCTYPE html>
<html>
<head>
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">

</head>
<body>
<?php use Enum\RolesEnum;

require __DIR__.'/../Core/menu.php'; ?>
<h1>Classes</h1>
<?php if ($this->data['role'] === RolesEnum::ADMIN){ ?>
<a href="/app.php/classes/create">Create new class</a> <?php } ?>
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
        <a href="<?php echo '/classes/'.$class['id'].'/addStudent' ?>">Add students to class</a>
        <?php if ($this->data['role'] === RolesEnum::ADMIN){ ?>
        <a href="<?php echo '/classes/'.$class['id'].'/addTeacher' ?>">Add teachers to class</a> <?php } ?>
      </td>
      <td>
          <?php if ($this->data['role'] === RolesEnum::TEACHER) {
          if ($this->data['enrollmentModel']->isEnrollment($this->data['currentUserId'], $class['id'])) { ?>
            <a href="<?php echo '/enrollment/'.$this->data['currentUserId'].'/'.$class['id'].'/delete' ?>"><?php echo 'Leave class' ?></a>
          <?php } else { ?>
        <a href="<?php echo '/enrollment/'.$this->data['currentUserId'].'/'.$class['id'].'/create' ?>"><?php echo 'Join class';
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
</body>