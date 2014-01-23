<form action="<?php echo url_for('soled_handlings')?>" method="post">
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