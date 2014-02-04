<?php $positionList = DepartmentPeoplePosition::getList()?>
<table width="100%" class="gray">
  <tr>
    <td><?php echo __('#')?></td>
    <td><?php echo __('Is Active')?></td>
    <td><?php echo __('Mpk')?></td>
    <td><?php echo __('Number')?></td>
    <td><?php echo __('Name')?></td>
    <td><?php echo __('Last name')?></td>
    <td><?php echo __('First name')?></td>
    <td><?php echo __('Middle name')?></td>
    <td><?php echo __('Drfo')?></td>
    <td><?php echo __('Passport')?></td>
    <td><?php echo __('Type')?></td>
    <td><?php echo __('Employment type')?></td>
    <td><?php echo __('Salary')?></td>
    <td><?php echo __('Admission date')?></td>
    <td><?php echo __('Dismissal date')?></td>
    <td><?php echo __('Position')?></td>
    <td><?php echo __('Birthday')?></td>
    <td><?php echo __('Person code')?></td>
    <td><?php echo __('Companystructure')?></td>
    <td><?php echo __('Exists in january')?></td>
  </tr>
  <?php $i = 0; foreach ($peoples as $people): ?>
  <?php if ($people['full_name'] || $people['name']) : ?>
  <tr>
    <td><?php echo ++$i ?></td>
    <td><?php echo $people['status_id'] == 1 ? 'Да' : 'Нет' ?></td>
    <td><?php echo $people['mpk'] ?></td>
    <td><?php echo $people['number']?></td>
    <td><?php echo $people['full_name'] ? $people['full_name'] : $people['name']?></td>
    <td><?php echo $people['last_name'] ?></td>
    <td><?php echo $people['first_name'] ?></td>
    <td><?php echo $people['middle_name'] ?></td>
    <td><?php echo $people['drfo']?></td>
    <td><?php echo $people['passport']?></td>
    <?php $typeString = $people['type_string']?>
    <td><?php echo $typeString ?></td>
    <td><?php echo $people['employment_type_id'] ? $lookup[$people['employment_type_id']] : ''?></td>
    <td><?php echo $people['salary']?></td>
    <td><?php echo format_date($people['admission_date'], 'dd.MM.yyyy', 'ru')?></td>
    <td><?php echo format_date($people['dismissal_date'], 'dd.MM.yyyy', 'ru')?></td>
    <td><?php echo isset($positionList[$people['position_id']]) ? $positionList[$people['position_id']] : ''?></td>
    <td><?php echo format_date($people['birthday'], 'dd.MM.yyyy', 'ru')?></td>
    <td><?php echo $people['person_code']?></td>
    <td><?php echo $people['companystructure_name']?></td>
  </tr>
  <?php endif;?>
  <?php endforeach;?>
</table>