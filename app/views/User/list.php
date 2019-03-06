<!DOCTYPE html>
<html>
<head>
    <link href="/css/menu_style.css" type="text/css" rel="stylesheet">
    <link href="/css/footer_style.css" type="text/css" rel="stylesheet">
    <link href="/css/messages_style.css" type="text/css" rel="stylesheet">
    <link href="/css/user_list_style.css" type="text/css" rel="stylesheet">
    <link href="/css/errors_style.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <title>Users</title>
</head>
<body>

<?php require __DIR__ . '/../Core/menu.php';
$data = $this->data['form']->getData();
$countOfPages = $this->data['countOfPages'];
?>

<div class="wrap">
    <div class="title">
        <h1>Users list</h1>
        <?php require __DIR__ . '/../Core/messages.php'; ?>
        <a href="/users/create"><i class="fas fa-user-plus"></i>Add user</a>
    </div>
    <form method="get">
        <div class="filter">
            <?php require __DIR__ . '/../Core/form_errors.php'; ?>
            <input type="text" class="filter_value" name="filter[name]" value="<?php echo $data['filter']['name'] ?>">
            <select name="filter[role]">
                <option value=""></option>
                <?php foreach (\Enum\RolesEnum::getAll() as $role) { ?>
                    <option value="<?php echo $role ?>"
                        <?php if ($role === $data['filter']['role']) {
                            echo 'selected';
                        } ?>>
                        <?php echo $role ?>
                    </option>
                <?php } ?>
            </select>
            <input class="filter_field" name="order_by" value="<?php echo $data['order_by'] ?>" hidden>
            <input class="filter_direction" name="order_dir" value="<?php echo $data['order_dir'] ?>" hidden>
            <input class="current_page" name="page[current_page]" value="<?php echo $data['page']['current_page']; ?>" hidden>
            <input class="offset" name="page[offset]" value="<?php echo $data['page']['offset']; ?>" hidden>
            <input class="limit" name="page[limit]" value="<?php echo $data['page']['limit']; ?>" hidden>
            <button type="submit" class="submit_button">Filter</button>
        </div>


        <div class="list">
            <div class="head">
                <div class="fields">
                    <div data-fld="login" class="<?php if ($data['order_by'] === 'login') {
                        echo ($data['order_dir'] === 'asc') ? 'asc' : 'desc';
                    } ?>">Login
                    </div>
                    <div data-fld="first_name" class="<?php if ($data['order_by'] === 'first_name') {
                        echo ($data['order_dir'] === 'asc') ? 'asc' : 'desc';
                    } ?>">First Name
                    </div>
                    <div data-fld="last_name" class="<?php if ($data['order_by'] === 'last_name') {
                        echo ($data['order_dir'] === 'asc') ? 'asc' : 'desc';
                    } ?>">Last Name
                    </div>
                    <div data-fld="role" class="<?php if ($data['order_by'] === 'role') {
                        echo ($data['order_dir'] === 'asc') ? 'asc' : 'desc';
                    } ?>">Role
                    </div>
                </div>
            </div>
            <?php foreach ($this->data['users'] as $user) { ?>
                <div class="row">
                    <div><?php echo $user['login'] ?></div>
                    <div><?php echo $user['first_name'] ?></div>
                    <div><?php echo $user['last_name'] ?></div>
                    <div><?php echo $user['role']; ?></div>
                    <div class="buttons">
                        <a href="/users/<?php echo $user['id']; ?>/edit" class="edit_button"><i
                                    class="fas fa-user-edit"></i> Edit</a>
                        <a href="/users/<?php echo $user['id']; ?>/delete" class="delete_button"><i
                                    class="fas fa-user-times"></i>Delete</a>
                    </div>
                </div>
            <?php } ?>
            <div class="row end">
                <div class="pages">
                   <button class="prev"><i class="fas fa-arrow-circle-left"></i></button>
                    <input class="number_of_pages" hidden value="<?php echo $countOfPages ?>">
                    <?php
                    for ($i = 1; $i <= $countOfPages; $i++) {
                        if ($countOfPages>7 && $i>3 && $i<$countOfPages-2) {
                            if ($i===4) {
                            ?>
                            <select class="page_select" >
                                <option></option>
                                <?php for($j=$i; $j<$countOfPages-2; $j++) { ?>
                                    <option <?php if ($j===(int)$data['page']['current_page']) echo 'selected'?>><?php echo $j; ?></option><?php
                                } } else {
                                    continue;
                                } ?>
                            </select><?php }else{ ?>
                        <button type="submit" class="page <?php if ((int)$data['page']['current_page'] === $i) {
                            echo 'current_page';
                        } ?>"><?php echo $i; ?></button>
                    <?php } }
                    ?>
                    <button class="next"><i class="fas fa-arrow-circle-right"></i></button>
                </div>
                <div class="per_page">
                    <label>Per page</label>

                    <select name="page[limit]" class="per_page_select">
                        <option <?php if ((int)$data['page']['limit'] === 1) {
                            echo 'selected';
                        } ?>>1</option>
                        <option <?php if ((int)$data['page']['limit'] === 2) {
                                echo 'selected';
                            } ?>>2</option>
                        <option <?php if ((int)$data['page']['limit'] === 5) {
                            echo 'selected';
                        } ?>>5
                        </option>
                        <option <?php if ((int)$data['page']['limit'] === 10) {
                            echo 'selected';
                        } ?>>10
                        </option>
                        <option <?php if ((int)$data['page']['limit'] === 20) {
                            echo 'selected';
                        } ?>>20
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
<?php require __DIR__ . '/../Core/footer.html'; ?>
<script type="text/javascript" src="/js/filter.js"></script>
</body>
