<?php
  if (!isset($params) && isset($where))
  {
    $params= array(
      'where' => $where,
      'model' => $model,
      'field' => $field,
      'toString' => $toString
    );

    if (isset($withLabel))
    {
      $params['withLabel'] = $withLabel;
    }

    if (isset($form))
    {
      $params['form'] = $form;
    }

    if (isset($ref_functions))
    {
      $params['ref_functions'] = $ref_functions;
    }

    if (isset($ref_functions_names))
    {
      $params['ref_functions_names'] = $ref_functions_names;
    }

    $params = json_encode($params);
  }
?>
<div class="ajax_field_container" data-url="<?php echo url_for('Fmodel/ajax_field_edit')?>" data-params="<?php echo $params?>">
  <div class="ajax_field_value">
    <?php echo !isset($shortEdit) ? html_entity_decode($default) : ''?>
  </div>
  <div class="ajax_field_edit" data-add="<?php echo __('Add')?>" data-edit="<?php echo __('Edit')?>">
    <a href="#" class="ajax_field_edit_btn">
      <?php echo html_entity_decode($default) ? (!isset($shortEdit) ? __('Edit') : html_entity_decode($default)) : __('Add')?></a>
  </div>
</div>
