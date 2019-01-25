<!DOCTYPE html>
<html>
<head></head>
<body>
<h1>Enrollments</h1>
<a href="/enrollment/addStudent">Add students to classes</a>
<br>
<a href="/enrollment/addTeacher">Add teachers to classes</a>
<?php foreach($this->data['list'] as $classId => $class){ ?>
<h2><?php echo $this->data['classModel']->getClass($classId)['title'] ?></h2>
<a href="#">TODO Join class(for teachers)</a>
<table width="100%" cellspacing="0" style="text-align: center">
    <thead>
    <caption>Students</caption>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($class['students'] as $student) { ?>
        <tr>
            <td><?php echo $this->data['userModel']->getUser($student['user_id'])['first_name'] ?></td>
            <td><?php echo $this->data['userModel']->getUser($student['user_id'])['last_name']?></td>
            <td><a href="<?php echo 'enrollment/'.$student['user_id'].'/delete' ?>">Remove from class</a></td> <?php } ?>
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
        <?php foreach($class['teachers'] as $teacher) { ?>
        <tr>
            <td><?php echo $this->data['userModel']->getUser($teacher['user_id'])['first_name'] ?></td>
            <td><?php echo $this->data['userModel']->getUser($teacher['user_id'])['last_name']; }?></td>
        </tr>
    </tbody>
</table>
<hr>
<?php } ?>
</body>