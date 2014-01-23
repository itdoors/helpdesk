<?php echo $form->renderGlobalErrors();?>
<form action="<?php echo url_for('Fmodel/ajax_field_save') ?>" method="post" class="ajax_field_form">
<?php
  foreach ($params['fields'] as $field)
  {
    if (isset($params['withLabel']))
    {
      echo $form[$field]->renderLabel();
    }
    echo $form[$field]->renderError();
    echo $form[$field];
  }

  echo $form->renderHiddenFields();
?>
 <input type="submit" value="<?php echo __('Save')?>" /> 
<input type="button" value="<?php echo __('Cancel')?>" class="ajax_field_cancel_form"/> 
</form>
