<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('dogovor/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('dogovor/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'dogovor/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['prolongation']->renderLabel() ?></th>
        <td>
          <?php echo $form['prolongation']->renderError() ?>
          <?php echo $form['prolongation'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['organization_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['organization_id']->renderError() ?>
          <?php echo $form['organization_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['startdatetime']->renderLabel() ?></th>
        <td>
          <?php echo $form['startdatetime']->renderError() ?>
          <?php echo $form['startdatetime'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['stopdatetime']->renderLabel() ?></th>
        <td>
          <?php echo $form['stopdatetime']->renderError() ?>
          <?php echo $form['stopdatetime'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['city_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['city_id']->renderError() ?>
          <?php echo $form['city_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['subject']->renderLabel() ?></th>
        <td>
          <?php echo $form['subject']->renderError() ?>
          <?php echo $form['subject'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['filepath']->renderLabel() ?></th>
        <td>
          <?php echo $form['filepath']->renderError() ?>
          <?php echo $form['filepath'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['is_active']->renderLabel() ?></th>
        <td>
          <?php echo $form['is_active']->renderError() ?>
          <?php echo $form['is_active'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['dogovor_type_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['dogovor_type_id']->renderError() ?>
          <?php echo $form['dogovor_type_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['mashtab']->renderLabel() ?></th>
        <td>
          <?php echo $form['mashtab']->renderError() ?>
          <?php echo $form['mashtab'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
