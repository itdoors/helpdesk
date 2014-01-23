<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('groupuser/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?sf_guard_user_id='.$form->getObject()->getSfGuardUserId().'&doc_document_group_id='.$form->getObject()->getDocDocumentGroupId().'&actionkey='.$form->getObject()->getActionkey() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          &nbsp;<a href="<?php echo url_for('groupuser/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'groupuser/delete?sf_guard_user_id='.$form->getObject()->getSfGuardUserId().'&doc_document_group_id='.$form->getObject()->getDocDocumentGroupId().'&actionkey='.$form->getObject()->getActionkey(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form ?>
    </tbody>
  </table>
</form>
