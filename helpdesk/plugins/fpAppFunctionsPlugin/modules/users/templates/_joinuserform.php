<form action="<?php echo url_for('users/joinusersave')?>" method="post" name="<?php echo $form->getName()?>" >
<table>
<?php
  echo $form;
?>
<tfoot>
  <tr>
    <td colspan="2"><input type="submit" value="Сохранить"></td>
  <tr>
</tfoot>
</table>
</form>
