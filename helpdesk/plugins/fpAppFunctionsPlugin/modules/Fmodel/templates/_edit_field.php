<form action="<?php echo url_for('Fmodel/save_field') ?>" method="post">
<?php
  echo $form[$field]->renderError();
  echo $form[$field];
  echo $form->renderHiddenFields();
?>
<input type="hidden" name="field" value="<?php echo $field?>"> 
<input type="hidden" name="model" value="<?php echo $model?>"> 
<input type="hidden" name="id" value="<?php echo $id?>"> 
<input type="hidden" name="toString" value="<?php echo $toString?>"> 
<input type="hidden" name="float" value="<?php echo isset($float) ? $float : ''?>">
<input type="submit" value="<?php echo __('Save')?>" /> 
<input type="button" value="<?php echo __('Cancel')?>" class="cancel_form"/> 
</form>
