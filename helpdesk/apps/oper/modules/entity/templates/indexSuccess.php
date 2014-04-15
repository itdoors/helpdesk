<?php use_helper('Text', 'Date') ?>
 
 <?php include_component('entity', 'filters',
    array(
      'filter_form' => $filter_form,
      'filters' => $filters,
    )
  )?> 


<table cellspacing="0" width="100%" class="gray" id="example">  
  <thead>
    <tr>
      <th></th>
      <th>
        <?php include_partial('sort', array(
          'text' => 'MPK',
          'sort_field' => 'mpk',
          'sort' => $sort
        ))?>
      </th>
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
      <th><?php echo __('Opermanager')?></th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($departments as $department) : ?>
  <tr>
    <td></td>
    <td>
      <a href="<?php echo url_for('entity_show', array('department_id' => $department->getId()))?>">
        <?php echo $department->getMpk()?>
      </a>
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
    <td><?php echo $department->getOpermanager()?></td>
  </tr>
  <?php endforeach;?>
  </tbody>
 
</table>

<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination">
    <a href="<?php echo url_for('entity/index') ?>?page=1">
      <?php echo __('First')?>
    </a>
 
    <a href="<?php echo url_for('entity/index') ?>?page=<?php echo $pager->getPreviousPage() ?>">
      <?php echo __('<<')?>
    </a>
 
    <?php foreach ($pager->links as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="<?php echo url_for('entity/index') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
 
    <a href="<?php url_for('entity/index') ?>?page=<?php echo $pager->getNextPage() ?>">
      <?php echo __('>>')?>
    </a>
 
    <a href="<?php echo url_for('entity/index') ?>?page=<?php echo $pager->getLastPage() ?>">
      <?php echo __('Last')?>
    </a>
  </div>
<?php endif; ?>