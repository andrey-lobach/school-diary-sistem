<div class="menu">
    <?php
    /** @var \Core\Template\Menu $menu */
    $menu = $this->data['menu'];
    foreach ($menu as $item) { ?>
    <a class='menu_item' href="<?php echo $item['url'] ?>"><?php echo $item['title'] ?></a>
      <?php } ?>
</div>