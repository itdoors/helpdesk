<div id="organization_contacts">
  <?php include_component('organization', 'organization_contact_list',
    array(
      'organization_id' => $organization->getId(),
    ));?>
</div>
<?php
echo
!true ? '' :
  get_component('Fmodel','form_add',
    array(
      'model' => 'ModelContact',
      'form_class' => 'ModelContact',
      'target'=>'model_contacts_list',
      'button_text' => __('Add contact'),
      'default' =>
      array(
        'model_name'=> ModelContact::MODEL_ORGANIZATION,
        'model_id'=>$organization->getId(),
      ),
      'ref_functions'=>
      array(
        '#organization_contacts'=>url_for('organization/refresh_contacts').'/organization_id/'.$organization->getId()
      )

    )
  )
?>