<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<a href="/classes">Classes List</a>
<br>
<h1><?php echo isset($this->data['class']) ? 'Edit Class' : 'Create Class'; ?></h1>
<div class="errors-wrap">
    <?php
    $form = $this->data['form'];
    foreach ($form->getViolations() as $key => $violation) { ?>
        <div class="error-item"><?php echo $violation; ?></div>
    <?php } ?>
</div>

<form method="post">
    <input type="text" name="title" placeholder="title" required value="<?php echo $form->getData()['title']; ?>">
    <button type="submit" name="submit">Accept</button>
</form>
</body>
</html>