<?php
$action = $form->getObject()->isNew() ? url_for('organization/create') : url_for('organization/update').'?id='.$form->getObject()->getId();
?>
<form action="<?php echo $action?>" method="post">
  <table>
    <?php
    //echo $form->renderHiddenFields();
    echo $form;
    ?>
    <tfoot>
    <tr>
      <td colspan="2">
        <?php echo $form->renderHiddenFields(false) ?>
        &nbsp;<a href="<?php echo url_for('organization/index')?>"><?php echo __('Cancel')?></a>
        <input type="submit" value="<?php echo __("Save")?>" />
      </td>
    </tr>
    </tfoot>
  </table>
</form>

