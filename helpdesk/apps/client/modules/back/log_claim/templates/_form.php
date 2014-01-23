<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('log_claim/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('log_claim/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'log_claim/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['claim_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['claim_id']->renderError() ?>
          <?php echo $form['claim_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['action_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['action_id']->renderError() ?>
          <?php echo $form['action_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['createdatetime']->renderLabel() ?></th>
        <td>
          <?php echo $form['createdatetime']->renderError() ?>
          <?php echo $form['createdatetime'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['user_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['user_id']->renderError() ?>
          <?php echo $form['user_id'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
