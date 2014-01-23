<form action="<?php echo url_for('handling_more_info_table')?>" method="post">
  <table>
    <?php
    echo $form;
    ?>
    <tr>
      <td colspan="2">
        <input type="submit" value="<?php echo __('Show result')?>">
      </td>
    </tr>
  </table>
</form>