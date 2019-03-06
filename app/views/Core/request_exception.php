<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
    <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
    <link href="/css/request_exception_style.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <title>Something went wrong...</title>
</head>
<body>
<?php require __DIR__ . '/menu.php'; ?>
<?php require __DIR__ . '/footer.html'; ?>
<div class="wrap">
    <div class="text">
        <h1>Something went wrong...</h1>
        <h1>Error <?php echo $this->data['code'] ?></h1>
        <h2><?php echo $this->data['message'] ?></h2>
    </div>
    <i class="fas fa-exclamation-triangle"></i>
</div>
</body>
</html>