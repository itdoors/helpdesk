  <?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<form action="<?php echo url_for('claimopened/'.($form->getObject()->isNew() ? 'createclaimtypeajax' : 'updateclaimtypeajax').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> id="dispatcher_form_claimtype_ajax">
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
      <?php echo $form->renderHiddenFields(false); ?>
      <?php echo $form['claimtype_id']->render(array('class'=>'input_ajax')); ?>
      <input type="submit" value="<?php echo __('Save')?>" class="input_ajax_submit"/> 
      <input type="button" value="<?php echo __('Cancel')?>" id="dispatcher_button_claimtype_cancel"/>
</form>
