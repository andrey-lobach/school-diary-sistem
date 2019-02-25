<?php
$flash = $this->data['flash'];
if (count($flash['errors'])){
?>
<div class="messages-errors">
<i class="fas fa-exclamation-triangle"></i>
<?php foreach ($flash['errors'] as $error) {?>
<div class="message"><?php echo $error; } ?></div>
</div>
<?php } if (count($flash['messages'])){ ?>
<div class="messages-messages">
  <i class="fas fa-check"></i>
<?php foreach ($flash['messages'] as $message) {?>
  <div class="message"><?php echo $message;}  ?></div>
</div> <?php } ?>
