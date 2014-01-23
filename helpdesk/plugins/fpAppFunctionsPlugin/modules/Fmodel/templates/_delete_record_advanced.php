<form action="<?php echo url_for('Fmodel/delete_record_advanced')?>" method="post"
   class="delete_record_advanced_form" 
   <?php if (isset($parants)):?>data-parents_tag="<?php echo $parents?>"<?php endif;?>
   <?php if (isset($ref_functions)):?>data-ref_functions="<?php echo $ref_functions?>"<?php endif;?>
   <?php if (isset($ref_functions_names)):?>data-ref_functions_names="<?php echo $ref_functions_names?>"<?php endif;?>
   data-confirm_text = "<?php echo __('Are you sure')?>"> 
  <input type="hidden" name="model" value="<?php echo $model?>">
  <input type="hidden" name="where" value="<?php echo $where?>">
  <input type="submit" value="<?php echo __('Delete')?>" />
</form>