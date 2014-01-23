<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('claimopened/'.($form->getObject()->isNew() ? 'creategroup' : 'updategroup').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table class="tableform claim_form_outer">
    <tfoot>
      <tr>
        <td colspan="2">
           &nbsp;<a href="<?php echo url_for('claimopened/index') ?>"><?php echo __('Back to list')?></a>
          <input type="submit" value="<?php echo __('Send')?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form ?>
    </tbody>
  </table>
</form>
