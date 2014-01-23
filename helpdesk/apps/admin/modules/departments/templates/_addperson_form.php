<?php use_helper('I18N', 'Date') ?> 
<form action="<?php echo url_for('departments/addperson')?>" class="add_person_form" method="post">
<table>
<?php echo $form?>
<tfoot>
  <td colspan="2">
    <input type="hidden" name="<?php echo $form->getName()?>[departments_id]" value="<?php echo $departments_id?>">
    <input type="submit" value="<?php echo __('Add')?>">
  </td>
</tfoot>
</table>
</form>