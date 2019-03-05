<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
  <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
  <title>Something went wrong...</title>
</head>
<body>
<?php require __DIR__.'/menu.php'; ?>
<?php require __DIR__.'/footer.html'; ?>
<?php
echo $this->data['code'].' '.$this->data['message'];
?>
</body>
</html>