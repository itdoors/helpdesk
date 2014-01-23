<form action="<?php echo url_for('ajax/ajaxFieldFormSaveDocuments') ?>" id="submitform" method="post" enctype="multipart/form-data">

<?php
  echo $form;
?>

<input type="submit" value="<?php echo __('Save')?>" /> 
<input type="button" value="<?php echo __('Cancel')?>" class="cancel_form"/> 
</form> 