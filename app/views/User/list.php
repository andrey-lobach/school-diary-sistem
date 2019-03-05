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
$current_page = $data['page']['offset'] ?? 1;

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
            <input class="filter_direction" name="order_dir" value="" hidden>
            <!-- //TODO  -->
            <input class="offset" name="page[current_page]" value="<?php echo $data['page']['offset']; ?>" hidden>
            <input class="offset" name="page[offset]" value="<?php echo $data['page']['offset']; ?>" hidden>
            <input class="offset" name="page[offset]" value="<?php echo $data['page']['offset']; ?>" hidden>
            <button type="submit" class="submit_button">Filter</button>
        </div>


        <div class="list">
            <div class="head">
                <div class="fields">
                    <div id="login" data-field="login" class="<?php if ($data['order_by'] === 'login') {
                        echo ($data['order_dir'] === 'asc') ? 'asc' : 'desc';
                    } ?>">Login
                    </div>
                    <div id="first_name" class="<?php if ($data['order_by'] === 'first_name') {
                        echo ($data['order_dir'] === 'asc') ? 'asc' : 'desc';
                    } ?>">First Name
                    </div>
                    <div id="last_name" class="<?php if ($data['order_by'] === 'last_name') {
                        echo ($data['order_dir'] === 'asc') ? 'asc' : 'desc';
                    } ?>">Last Name
                    </div>
                    <div id="role" class="<?php if ($data['order_by'] === 'role') {
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
                    <a href="<?php // change a to buttons

                    ?>"> <i class="fas fa-arrow-circle-left"></i></a>
                    <?php
                    for ($i = 1; $i <= $countOfPages; $i++) { ?>
                        <button type="submit" class="<?php if ((int)$current_page === $i) {
                            echo 'current_page';
                        } ?>"><?php echo $i; ?></button>
                        <?php if ($countOfPages === 1) break;
                    }
                    ?>
                    <a href=""><i class="fas fa-arrow-circle-right"></i></a>
                </div>
                <div>
                    <label>Per page</label>

                    <select name="page[limit]" class="per_page_select">
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
