<div class="messages">
    <?php

    $flash = $this->data['flash'];
    foreach ($flash as $group => $messages) { ?>
        <?php foreach ($messages as $message) { ?>
        <div class="message-<?php echo $group ?>"><?php echo $message ?></div>
        <?php } ?>
    <?php } ?>
</div>