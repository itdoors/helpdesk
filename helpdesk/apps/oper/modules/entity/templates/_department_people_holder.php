<div id="department_people_list">
  <?php include_component('entity', 'department_people_list', array('department' => $department))?>
</div>

<div id="department_people_form_holder" style="display: none;"></div>
<?php
include_component('Fmodel','form_add',
  array(
    'model' => 'DepartmentPeople',
    'form_class' => 'DepartmentPeople',
    'target'=>'department_people_form_holder',
    'button_text' => __('Add department people'),
    'default' =>
    array(
      'department_id'=>$department->getId()
    ),
    'ref_functions'=>
      array(
        '#department_people_list'=>url_for('entity/refresh_department_people_list').'?department_id='.$department->getId().'&'
    )
  )
);?>