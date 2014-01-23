<div id="department_contacts">
  <?php include_component('entity', 'department_contact_list', 
    array(
      'department_id' => $department->getId(), 
      'can_edit' => $can_edit
    ));?>
</div>
<?php
echo 
!$can_edit ? '' :
get_component('Fmodel','form_add',
   array(
      'model' => 'ModelContact',
      'form_class' => 'ModelContact',
      'target'=>'model_contacts_list',
      'button_text' => __('Add contact'),
      'default' => 
         array(
            'model_name'=> ModelContact::MODEL_DEPARTMENTS,
            'model_id'=>$department->getId(),
         ),
       'ref_functions'=>
       array(
           '#department_contacts'=>url_for('entity/refresh_contacts').'/department_id/'.$department->getId()
       )
   
   )
)   
?>
