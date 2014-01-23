<h1><?php echo __('Change password')?></h1>
<?php if ($sf_user->hasFlash('notice')): ?>
  <div class="flash_notice"><?php echo __($sf_user->getFlash('notice')) ?></div>
<?php endif; ?>
<?php include_partial('form', array('form' => $form)) ?>
