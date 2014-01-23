<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('groupclaimperiod/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('groupclaimperiod/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'groupclaimperiod/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['groupclaim_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['groupclaim_id']->renderError() ?>
          <?php echo $form['groupclaim_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['period_day']->renderLabel() ?></th>
        <td>
          <?php echo $form['period_day']->renderError() ?>
          <?php echo $form['period_day'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['period_month']->renderLabel() ?></th>
        <td>
          <?php echo $form['period_month']->renderError() ?>
          <?php echo $form['period_month'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['period_year']->renderLabel() ?></th>
        <td>
          <?php echo $form['period_year']->renderError() ?>
          <?php echo $form['period_year'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
