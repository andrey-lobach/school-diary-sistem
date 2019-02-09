<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title></title>
</head>
<body>
<?php require __DIR__.'/../Core/menu.php'; ?>
<h1>Class: <?php echo $this->data['title'] ?></h1>
<table width="100%" cellspacing="0" style="text-align: center">
  <thead>
  <caption>Students</caption>
  <tr>
    <th>First Name</th>
    <th>Last Name</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($this->data['list']['students'] as $student) { ?>
  <tr>
    <td><?php echo $this->data['userModel']->getUser($student['user_id'])['first_name'] ?></td>
    <td><?php echo $this->data['userModel']->getUser($student['user_id'])['last_name']; }?></td>
  </tr>
  </tbody>
</table>
<table width="100%" cellspacing="0" style="text-align: center">
  <thead>
  <caption>Teachers</caption>
  <tr>
    <th>First Name</th>
    <th>Last Name</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($this->data['list']['teachers'] as $teacher) { ?>
  <tr>
    <td><?php echo $this->data['userModel']->getUser($teacher['user_id'])['first_name'] ?></td>
    <td><?php echo $this->data['userModel']->getUser($teacher['user_id'])['last_name']; }?></td>
  </tr>
  </tbody>
</table>
</body>
</html>