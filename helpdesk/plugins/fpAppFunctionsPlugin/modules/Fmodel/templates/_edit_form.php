<form action="<?php echo url_for('Fmodel/save_form') ?>" method="post">  
<?php
  echo $form;
?>
<?php if (isset($default))
  foreach($default as $key => $value)
  {
     echo "<input type=\"hidden\" name =\"default[$key]\" value=\"$value\" />";
  }
?>
<input type="hidden" value="<?php echo $model?>" name="model"/> 
<input type="hidden" value="<?php echo $form_class?>" name="form_class"/> 
<input type="submit" value="<?php echo __('Save')?>" /> 
<input type="button" value="<?php echo __('Cancel')?>" class="cancel_form"/> 
</form>
