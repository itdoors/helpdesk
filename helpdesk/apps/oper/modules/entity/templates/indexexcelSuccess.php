<?php use_helper('Text', 'Date') ?>

<table cellspacing="0" width="100%" class="gray" id="example">
  <thead>
  <tr>
    <th></th>
    <th><?php echo __('MPK')?></th>
    <th>
      <?php include_partial('sort', array(
      'text' => 'Organization',
      'sort_field' => 'organization',
      'sort' => $sort
    ))?>
    </th>
    <th>
      <?php include_partial('sort', array(
      'text' => 'Region',
      'sort_field' => 'region',
      'sort' => $sort
    ))?>
    </th>
    <th>
      <?php include_partial('sort', array(
      'text' => 'City',
      'sort_field' => 'city',
      'sort' => $sort
    ))?>
    </th>
    <th><?php echo __('Address')?></th>
    <th>
      <?php include_partial('sort', array(
      'text' => 'Status',
      'sort_field' => 'status',
      'sort' => $sort
    ))?>
    </th>
    <th><?php echo __('Status date')?></th>
    <th>
      <?php include_partial('sort', array(
      'text' => 'Type',
      'sort_field' => 'type',
      'sort' => $sort
    ))?>
    </th>
    <th><?php echo __('Description')?></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($departments as $department) : ?>
  <tr>
    <td></td>
    <td>
      <?php echo $department->getMpk()?>
    </td>
    <td>
      <?php
      /* $dep = str_replace(array("'","\""), "", htmlspecialchars_decode($department->getOrganization()));
       echo $dep;*/
      echo $department->getOrganization()
      ?>
    </td>
    <td><?php echo $department->getRegion()?></td>
    <td><?php echo $department->getCity()?></td>
    <td><?php echo $department->getAddress()?></td>
    <td><?php echo $department->getStatus()?></td>
    <td><?php echo format_date($department->getStatusDate(), 'dd.MM.yyyy', 'ru')?></td>
    <td><?php echo $department->getDepartmentsType()?></td>
    <td><?php echo $department->getDescription()?></td>
  </tr>
    <?php endforeach;?>
  </tbody>

</table>