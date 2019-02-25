<?php
/** @var \Core\Form\FormInterface $form */
$form = $this->data['form'];
if (!$form->isValid()) {
?>
<div class="errors-wrap">
  <p>There was an error with your submission!</p>
  <ul>
    <?php
    foreach ($form->getViolations() as $key => $violation) { ?>
        <li class="error-item"><?php echo $violation; ?></li>
    <?php } ?>
  </ul>
  <p>Please retry.</p>

</div>
<?php } ?>