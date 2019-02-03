<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<h1><?php if (count($this->data['availableUsers']) === 0) {echo 'No available users';}
    elseif ($this->data['teacher']) {echo 'Add teacher to class';}
    else {echo 'Add student to class';} ?></h1>
<a href="/enrollment">Enrollments List</a>
<?php require __DIR__.'/../Core/form_errors.php'; ?>
<form method="post">
    <select name="user_ids[]" multiple required>
        <?php foreach($this->data['availableUsers'] as $user){ ?>
        <option value="<?php echo $user['id'] ?>"><?php echo $user['first_name'].' '.$user['last_name'] ?></option><?php } ?>
    </select>
    <select name="class_ids[]" <?php if ($this->data['teacher']){ echo 'multiple';} ?> required>
        <option></option>
        <?php foreach($this->data['classes'] as $class){ ?>
            <option value="<?php echo $class['id'] ?>"><?php echo $class['title'] ?></option><?php } ?>
    </select>
    <button type="submit" name="submit">Accept</button>
</form>
</body>
</html>