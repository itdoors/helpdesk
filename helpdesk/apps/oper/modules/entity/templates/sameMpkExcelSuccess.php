<?php $positionList = DepartmentPeoplePosition::getList()?>
<table width="100%" class="gray">
  <tr>
    <td><?php echo __('ID')?></td>
    <td><?php echo __('Mpk')?></td>
    <td><?php echo __('Organization')?></td>
    <td><?php echo __('Region')?></td>
    <td><?php echo __('City')?></td>
    <td><?php echo __('Address')?></td>
    <td><?php echo __('Is Active')?></td>
    <td><?php echo __('Companystructure')?></td>
  </tr>
  <?php $i = 0; foreach ($peoples as $people): ?>
  <tr>
    <td><?php echo $people['id'] ?></td>
    <td><?php echo $people['mpk'] ?></td>
    <td><?php echo $people['organization_name'] ?></td>
    <td><?php echo $people['region_name'] ?></td>
    <td><?php echo $people['city_name'] ?></td>
    <td><?php echo $people['address'] ?></td>
    <td><?php echo $people['status_id'] == 1 ? 'Да' : 'Нет' ?></td>
    <td><?php echo $people['companystructure_name']?></td>
  </tr>
  <?php endforeach;?>
</table>