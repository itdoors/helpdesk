<?php use_helper('Text', 'Date') ?>

<?php include_component('organization', 'filters',
  array(
    'filter_form' => $filter_form,
    'filter' => $filters,
  )
)?>
<br />
<a href="<?php echo url_for('organization_new')?>"><?php echo __('Create Organization') ?> </a>
<br />

<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination">
    <a href="<?php echo url_for('organization/index') ?>?page=1">
      <?php echo __('First')?>
    </a>

    <a href="<?php echo url_for('organization/index') ?>?page=<?php echo $pager->getPreviousPage() ?>">
      <?php echo __('<<')?>
    </a>

    <?php foreach ($pager->links as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="<?php echo url_for('organization/index') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>

    <a href="<?php url_for('organization/index') ?>?page=<?php echo $pager->getNextPage() ?>">
      <?php echo __('>>')?>
    </a>

    <a href="<?php echo url_for('organization/index') ?>?page=<?php echo $pager->getLastPage() ?>">
      <?php echo __('Last')?>
    </a>
  </div>
<?php endif; ?>

<table cellspacing="0" width="100%" class="gray" id="example">
  <thead>
  <tr>
  <th><?php echo __('Id')?></th>
  <th>
    <?php include_partial('sort', array(
      'text' => 'Name',
      'sort_field' => 'name',
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
  <th>
    <?php include_partial('sort', array(
      'text' => 'Region',
      'sort_field' => 'region',
      'sort' => $sort
    ))?>
  </th>
  <th>
    <?php include_partial('sort', array(
      'text' => 'Scope',
      'sort_field' => 'scope',
      'sort' => $sort
    ))?>
  </th>
  <th><?php echo __('Managers')?></th>
  <th><?php echo __('Actions')?></th>
  </thead>
  <tbody>
  <?php foreach ($organizations as $organization) : ?>
  <tr>
    <td>
      <a href="<?php echo url_for('organization_show', array('organization_id' => $organization->getId()))?>">
        <?php echo $organization->getId()?>
      </a>
    </td>
    <td>
      <?php echo $organization->getName()?>
    </td>
    <td>
      <?php echo $organization->getCity()?>
    </td>
    <td>
      <?php echo $organization->getCity() ? $organization->getCity()->getRegion() : ''?>
    </td>
    <td>
      <?php echo $organization->getScope()?>
    </td>
    <td>
      <?php foreach ($organization->getOrganizationUser() as $organizationUser) : ?>
        <?php echo $organizationUser->getUser()->getLastName()?> <?php echo $organizationUser->getUser()->getFirstName()?>,
      <?php endforeach;?>
    </td>
    <td>
      <a href="<?php echo url_for('handling_list', array('organization_id' => $organization->getId()))?>">
        <?php echo __('Handling List')?>
      </a>
    </td>
  </tr>
  <?php endforeach;?>
  </tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination">
    <a href="<?php echo url_for('organization/index') ?>?page=1">
      <?php echo __('First')?>
    </a>

    <a href="<?php echo url_for('organization/index') ?>?page=<?php echo $pager->getPreviousPage() ?>">
      <?php echo __('<<')?>
    </a>

    <?php foreach ($pager->links as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="<?php echo url_for('organization/index') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>

    <a href="<?php url_for('organization/index') ?>?page=<?php echo $pager->getNextPage() ?>">
      <?php echo __('>>')?>
    </a>

    <a href="<?php echo url_for('organization/index') ?>?page=<?php echo $pager->getLastPage() ?>">
      <?php echo __('Last')?>
    </a>
  </div>
<?php endif; ?>