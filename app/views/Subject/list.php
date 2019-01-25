<!DOCTYPE html>
<html>
<head></head>
<body>
<h1>Subjects</h1>
<a href="/subjects/create">Create new subject</a>
<table width="100%" cellspacing="0" style="text-align: center">
    <thead>
    <tr>
        <th>Id</th>
        <th>Subject name</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($this->data['subjects'] as $subject) { ?>
        <tr>
            <td><?php echo $subject['id'] ?></td>
            <td><?php echo $subject['name'] ?></td>
            <td>
                <a href="/subjects/<?php echo $subject['id']; ?>/edit">Edit</a>
                <a href="/subjects/<?php echo $subject['id']; ?>/delete">Delete</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>