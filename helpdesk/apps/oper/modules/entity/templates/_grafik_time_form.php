<form action="<?php echo url_for('entity/grafik_time_form_submit')?>" id="grafik_time_form" method="post">
  <table>
    <?php
      echo $grafik_time_form;
      echo $grafik_time_form->renderHiddenFields();
    ?>
    <tr>
      <td colspan="2">
        <input type="submit" value="<?php echo __('Save')?>">
        <input type="button" id="grafik_time_cancel_btn" value="<?php echo __('Cancel')?>">
      </td>
    </tr>
  </table>
</form>