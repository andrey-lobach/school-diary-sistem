<div class="errors-wrap">
    <?php
    /** @var \Core\Form\FormInterface $form */
    $form = $this->data['form'];
    foreach ($form->getViolations() as $key => $violation) { ?>
        <div class="error-item"><?php echo $violation; ?></div>
    <?php } ?>
</div>
