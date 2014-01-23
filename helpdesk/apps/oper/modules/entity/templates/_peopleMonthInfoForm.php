<form action="<?php echo url_for('entity/people_month_info_form_submit')?>" id="people_form" method="post">
  <?php

  /** @var DepartmentPeopleMonthInfo $monthInfo */
  $monthInfo = $peopleMonthInfoForm->getObject() ;
  $isNew = $monthInfo->isNew();

  $surchargeError = $peopleMonthInfoForm->getOption('surchargeError');
  $bonusError = $peopleMonthInfoForm->getOption('bonusError');
  $fineError = $peopleMonthInfoForm->getOption('fineError');

  echo $peopleMonthInfoForm->renderHiddenFields();

  if ($isNew)
  {
    echo $peopleMonthInfoForm['department_people_id']->renderRow();
  }
  else
  {
    echo $peopleMonthInfoForm['department_people_name']->renderRow();
    //echo $peopleMonthInfoForm['department_people_parent_id']->renderRow();
  }

  echo $peopleMonthInfoForm['salary']->renderRow();
  echo $peopleMonthInfoForm['position_id']->renderRow();
  echo $peopleMonthInfoForm['type_id']->renderRow();
  echo $peopleMonthInfoForm['type_string']->renderRow(); ?>

  <?php
    $displayReplacement = 'none';
    if (!$peopleMonthInfoForm->isNew()
      && (
        $monthInfo->getTypeLukey() == lookup::DEPARTMENT_PEOPLE_TYPE_REPLACEMENT
      ))
    {
      $displayReplacement = 'block';
    }

    $replacementError = '';
    if ($replacementError = $peopleMonthInfoForm->getOption('replacementError'))
    {
      $displayReplacement = 'block';
    }
  ?>
  <?php if ($replacementError):?>
    <ul class="error_list">
      <li><?php echo $replacementError?></li>
    </ul>
  <?php endif;?>
  <div id="department_people_replacement_id_holder" style="display: <?php echo $displayReplacement?>">
    <?php echo $peopleMonthInfoForm['department_people_replacement_id']->renderRow(); ?>
  </div>
  <?php
  echo $peopleMonthInfoForm['employment_type_id']->renderRow();
  //echo $peopleMonthInfoForm['salary_type_id']->renderRow();?>

  <?php if ($surchargeError):?>
    <ul class="error_list">
      <li><?php echo $surchargeError?></li>
    </ul>
  <?php endif;?>
  <?php
  echo $peopleMonthInfoForm['surcharge']->renderRow();
  echo $peopleMonthInfoForm['surcharge_type_id']->renderRow();?>

  <?php if ($bonusError):?>
    <ul class="error_list">
      <li><?php echo $bonusError?></li>
    </ul>
  <?php endif;?>

  <?php
  echo $peopleMonthInfoForm['bonus']->renderRow();
  echo $peopleMonthInfoForm['bonus_type_id']->renderRow();?>

  <?php if ($fineError):?>
    <ul class="error_list">
      <li><?php echo $fineError?></li>
    </ul>
  <?php endif;?>

  <?php
  echo $peopleMonthInfoForm['fine']->renderRow();
  echo $peopleMonthInfoForm['fine_type_id']->renderRow();
  ?>
  <?php
  $display = 'none';

  if (!$peopleMonthInfoForm->isNew()
    && (
      $peopleMonthInfoForm->getObject()->getEmploymentTypeLukey() == lookup::EMPLOYMENT_TYPE_A ||
      $peopleMonthInfoForm->getObject()->getEmploymentTypeLukey() == lookup::EMPLOYMENT_TYPE_C ||
      $peopleMonthInfoForm->getObject()->getEmploymentTypeLukey() == lookup::EMPLOYMENT_TYPE_B
    ))
  {
    $display = 'block';
  }
  ?>

  <div id="is_clean_salary" style="display: <?php echo $display?>">
    <?php
    echo $peopleMonthInfoForm['is_clean_salary']->renderRow();
    echo $peopleMonthInfoForm['norma_days']->renderRow();
    ?>
  </div>
  <input type="submit" value="<?php echo __('Save')?>">
  <input type="button" id="people_cancel_btn" value="<?php echo __('Cancel')?>">
</form>

<?php if (!$peopleMonthInfoForm->getObject()->isNew()) : ?>
  <?php
  include_component('Fmodel', 'delete_record_advanced',
    array(
      'model'   => 'DepartmentPeopleMonthInfo',
      'parents_tag'   => 'not_exist',
      'where'      => array(
        'department_people_replacement_id'=> $peopleMonthInfoForm->getObject()->getDepartmentPeopleReplacementId(),
        'department_people_id'=> $peopleMonthInfoForm->getObject()->getDepartmentPeopleId(),
        'year' => $peopleMonthInfoForm->getObject()->getYear(),
        'month' => $peopleMonthInfoForm->getObject()->getMonth()
      ),
      'ref_functions_names' => array('updatePeoplePist', 'closePeopleDialog')
    ))
  ?>
<?php endif;?>