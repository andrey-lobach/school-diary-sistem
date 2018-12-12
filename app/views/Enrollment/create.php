<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<a href="/app.php/enrollments">Enrollments List</a>
<br>
<h1><?php echo isset($this->data['enrollment']) ? 'Edit Enrollment' : 'Create Enrollment'; ?></h1>
<div class="errors-wrap">
    <?php
    $form = $this->data['form'];
    foreach ($form->getViolations() as $key => $violation) { ?>
        <div class="error-item"><?php echo $violation; ?></div>
    <?php } ?>
</div>

<form method="post">
    <button type="submit" name="submit">Accept</button>
</form>
</body>
</html>