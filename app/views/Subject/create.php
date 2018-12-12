<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<a href="/app.php/subjects">Subjects List</a>
<br>
<h1><?php echo isset($this->data['subject']) ? 'Edit Subject' : 'Create Subject'; ?></h1>
<div class="errors-wrap">
    <?php
    $form = $this->data['form'];
    foreach ($form->getViolations() as $key => $violation) { ?>
        <div class="error-item"><?php echo $violation; ?></div>
    <?php } ?>
</div>

<form method="post">
    <input type="text" name="name" placeholder="name" required value="<?php echo $form->getData()['name']; ?>">
    <button type="submit" name="submit">Accept</button>
</form>
</body>
</html>