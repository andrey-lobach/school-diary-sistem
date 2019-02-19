<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
  <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <title></title>
</head>
<body>
<?php require __DIR__.'/../Core/menu.php';
$title = $this->data['class']['title'];
?>
<h1><?php if (count($this->data['availableUsers']) === 0) {echo 'No available users';}
    elseif ($this->data['teacher']) {echo 'Add teacher to '.$title.' class';}
    else {echo 'Add student to '.$title.' class';} ?></h1>
<?php require __DIR__.'/../Core/form_errors.php'; ?>
<form method="post">
    <select name="user_ids[]" multiple required>
        <?php foreach($this->data['availableUsers'] as $user){ ?>
        <option value="<?php echo $user['id'] ?>"><?php echo $user['first_name'].' '.$user['last_name'] ?></option><?php } ?>
    </select>
    <button type="submit" name="submit">Accept</button>
</form>
<?php require __DIR__.'/../Core/footer.html'; ?>
</body>
</html>