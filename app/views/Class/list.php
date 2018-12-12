<!DOCTYPE html>
<html>
<head></head>
<body>
<h1>Classes</h1>
<a href="/app.php/classes/create">Create new class</a>
<table width="100%" cellspacing="0" style="text-align: center">
    <thead>
    <tr>
        <th>Id</th>
        <th>Class name</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->data['classes'] as $class) { ?>
        <tr>
            <td><?php echo $class['id'] ?></td>
            <td><?php echo $class['title'] ?></td>
            <td>
                <a href="/app.php/classes/<?php echo $class['id']; ?>/edit">Edit</a>
                <a href="/app.php/classes/<?php echo $class['id']; ?>/delete">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>