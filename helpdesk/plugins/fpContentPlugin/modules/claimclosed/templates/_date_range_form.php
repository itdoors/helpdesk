<form action="<?php echo url_for('claimclosed/done')?>" method="post">
<table>
<?php
  echo $form;
?>
<tr>
  <td colspan="2">
    <input type="submit" value="<?php echo __('Submit')?>">
  </td>
</tr>
</table>
