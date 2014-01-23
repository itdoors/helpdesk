<form action="<?php echo url_for('ajax/ajaxFieldFormSave') ?>" id="submitform" method="post" enctype="multipart/form-data">
<?php
  echo $form[$formfield]->renderError();
  echo $form[$formfield];
  echo $form->renderHiddenFields();
 
?>
<input type="hidden" name="field" value="<?php echo $formfield?>">
<?php if ($relfield) :?>
    <input type="hidden" name="relfield" value="<?php echo $relfield?>">
<?php endif;?>
<input type="submit" value="<?php echo __('Save')?>" /> 
<input type="button" value="<?php echo __('Cancel')?>" class="cancel_form"/> 
</form> 

 

