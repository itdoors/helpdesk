<form action="<?php echo url_for('entity/people_form_submit')?>" id="people_form" method="post">
<?php
  echo $people_form->renderHiddenFields();
  echo $people_form['name']->renderRow();
  echo $people_form['salary']->renderRow();
  echo $people_form['number']->renderRow();
  echo $people_form['position_id']->renderRow();
  echo $people_form['birthday']->renderRow();
  echo $people_form['type_id']->renderRow();
  echo $people_form['type_string']->renderRow();
  echo $people_form['employment_type_id']->renderRow();
  //echo $people_form['salary_type_id']->renderRow();
  echo $people_form['contacts']->renderRow();
  echo $people_form['bonus']->renderRow();
  echo $people_form['fine']->renderRow();
?>
<?php
  $display = 'none';

  if (!$people_form->isNew()
      && (
        $people_form->getObject()->getEmploymentTypeLukey() == lookup::EMPLOYMENT_TYPE_C ||
        $people_form->getObject()->getEmploymentTypeLukey() == lookup::EMPLOYMENT_TYPE_B
      ))
  {
    $display = 'block';
  }
?>

<div id="is_clean_salary" style="display: <?php echo $display?>">
<?php
  echo $people_form['is_clean_salary']->renderRow();
  echo $people_form['norma_days']->renderRow();
?>
</div>
  <input type="submit" value="<?php echo __('Save')?>">
  <input type="button" id="people_cancel_btn" value="<?php echo __('Cancel')?>">
</form>

<?php if (!$people_form->getObject()->isNew()) : ?>
<?php 
include_component('Fmodel', 'delete_record_advanced',
  array(
    'model'   => 'DepartmentPeople',
    'parents_tag'   => 'not_exist',
    'where'      => array(
      'id' =>$people_form->getObject()->getId()
    ),
    'ref_functions_names' => array('updatePeoplePist', 'closePeopleDialog')
  ))
?>
<?php endif;?>