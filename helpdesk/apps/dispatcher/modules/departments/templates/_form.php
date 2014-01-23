<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('departments/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
            <input type="submit" value="Сохранить" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['mpk']->renderLabel() ?></th>
        <td>
          <?php echo $form['mpk']->renderError() ?>
          <?php echo $form['mpk'] ?>
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
        <th><?php echo $form['fullname']->renderLabel() ?></th>
        <td>
          <?php echo $form['fullname']->renderError() ?>
          <?php echo $form['fullname'] ?>
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
        <th><?php echo $form['address']->renderLabel() ?></th>
        <td>
          <?php echo $form['address']->renderError() ?>
          <?php echo $form['address'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['contract_id']->renderLabel() ?></th>
        <td>
          <?php echo $form['contract_id']->renderError() ?>
          <?php echo $form['contract_id'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['square']->renderLabel() ?></th>
        <td>
          <?php echo $form['square']->renderError() ?>
          <?php echo $form['square'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['client_list']->renderLabel() ?></th>
        <td>
          <?php echo $form['client_list']->renderError() ?>
          <?php echo $form['client_list'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
