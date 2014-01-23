<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('docdocument_version/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php
            $document_id = sfContext::getInstance()->getUser()->getAttribute('document_id');
            $s = $document_id ? "/id/$document_id":'';
          ?>
          &nbsp;<a href="<?php echo url_for('docdocument/show').$s ?>"><?php echo __('Back to list')?></a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php //echo link_to(__('Delete'), 'docdocument_version/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="<?php echo __('Save')?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form ?>
    </tbody>
  </table>
</form>
