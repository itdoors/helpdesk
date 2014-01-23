<div id="handling_managers">
  <?php include_component('handling', 'managers_list',
    array(
      'handling_id' => $handling->getId(),
    ));?>
</div>
<?php
if ($sf_user->hasCredential('crmadmin'))
  include_component('Fmodel','form_add',
    array(
      'model' => 'HandlingUser',
      'form_class' => 'HandlingUser',
      'target'=>'handling_managers_list',
      'button_text' => __('Add manager'),
      'default' =>
      array(
        'handling_id'=>$handling->getId(),
      ),
      'ref_functions'=>
      array(
        '#handling_managers'=>url_for('handling/refresh_managers').'/handling_id/'.$handling->getId()
      )
    )
  )
?>