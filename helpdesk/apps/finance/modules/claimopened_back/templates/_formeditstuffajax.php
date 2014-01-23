<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('claimopened/'.($form->getObject()->isNew() ? 'createstuffajax' : 'updatestuffajax').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> id="dispatcher_form_stuff_ajax">
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
     
      <?php echo $form ?><br />
      <input type="submit" value="<?php echo __('Save')?>" />
</form>
