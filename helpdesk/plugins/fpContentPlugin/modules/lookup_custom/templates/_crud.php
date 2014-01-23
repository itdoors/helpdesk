<div id="lookup_list">
  <?php include_component('lookup_custom', 'list',
    array(
      'lukey' => $lukey,
    ));?>
</div>
<?php
  include_component('Fmodel','form_add',
    array(
      'model' => 'lookup',
      'form_class' => 'lookup',
      'target'=>'lookup_custom_list',
      'button_text' => __('Add record'),
      'default' =>
      array(
        'lukey'=>$lukey,
      ),
      'ref_functions'=>
      array(
        '#lookup_list'=>url_for('lookup_custom/refresh_list').'/lukey/'.$lukey
      )
    )
  )
?>