<form action="<?php echo url_for('entity/grafik_form_submit')?>" id="grafik_form" method="post">
<table>
<?php
  echo $grafik_form->renderGlobalErrors();
  echo $grafik_form->renderHiddenFields();
  echo $grafik_form['is_sick']->renderRow();
  echo $grafik_form['is_skip']->renderRow();
  echo $grafik_form['is_fired']->renderRow();
  echo $grafik_form['is_vacation']->renderRow();
  echo $grafik_form['until_the_end_of_the_month']->renderRow();
?>
<tr>
  <td colspan="2">
    <?php
      $display = 'none';

      if ($grafik_form->getOption('dateRangeError'))
      {
        $display = 'block';
      }
    ?>
    <div id="not_work_holder" style="display: <?php echo $display?>;">
      <?php echo __('From')?>:
      <?php
        echo $grafik_form['from_not_work']->renderError();
        echo $grafik_form['from_not_work']->render();
      ?><br />
      <?php echo __('To')?>:
      <?php
        echo $grafik_form['to_not_work']->renderError();
        echo $grafik_form['to_not_work']->render();
      ?><br />
      <?php echo __('With weekends')?>:
      <?php echo $grafik_form['copy_with_weekends']->renderError();?>
      <?php echo $grafik_form['copy_with_weekends']->render();?>
    </div>
  </td>
</tr>
<tr>
  <td colspan="2">
    <input type="submit" value="<?php echo __('Save')?>">
    <input type="button" id="grafik_cancel_btn" value="<?php echo __('Cancel')?>">
  </td>
</tr>
</table>
</form>
