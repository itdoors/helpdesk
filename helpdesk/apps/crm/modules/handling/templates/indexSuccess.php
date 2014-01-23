<?php use_helper('Text', 'Date') ?>

<?php include_component('handling', 'filters',
  array(
    'filter_form' => $filter_form,
    'filter' => $filters,
  )
)?>

<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination">
    <a href="<?php echo url_for('handling/index') ?>?page=1">
      <?php echo __('First')?>
    </a>

    <a href="<?php echo url_for('handling/index') ?>?page=<?php echo $pager->getPreviousPage() ?>">
      <?php echo __('<<')?>
    </a>

    <?php foreach ($pager->links as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="<?php echo url_for('handling/index') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>

    <a href="<?php url_for('handling/index') ?>?page=<?php echo $pager->getNextPage() ?>">
      <?php echo __('>>')?>
    </a>

    <a href="<?php echo url_for('handling/index') ?>?page=<?php echo $pager->getLastPage() ?>">
      <?php echo __('Last')?>
    </a>
  </div>
<?php endif; ?>

<?php if (Handling::getSessionOrganizationId()) : ?>
  <a href="<?php echo url_for('handling_new')?>"><?php echo __('New Handling')?></a>
<?php else :?>
  <?php __('Choose organization to create Handling')?>
<?php endif;?>

<table cellspacing="0" width="100%" class="gray" id="example">
  <thead>
  <tr>
  <th><?php echo __('Id')?></th>
  <th>
    <?php include_partial('sort', array(
      'text' => 'Organization',
      'sort_field' => 'organization_id',
      'sort' => $sort
    ))?>
  </th>
  <th>
    <?php include_partial('sort', array(
      'text' => 'Createdatetime',
      'sort_field' => 'createdatetime',
      'sort' => $sort
    ))?>
  </th>
  <th>
    <?php include_partial('sort', array(
      'text' => 'Last handling date',
      'sort_field' => 'last_handling_date',
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
      'text' => 'Scope',
      'sort_field' => 'scope',
      'sort' => $sort
    ))?>
  </th>
  <th>
    <?php include_partial('sort', array(
      'text' => 'Service offered',
      'sort_field' => 'service_offered',
      'sort' => $sort
    ))?>
  </th>
  <th>
    <?php include_partial('sort', array(
      'text' => 'Chance',
      'sort_field' => 'chance',
      'sort' => $sort
    ))?>
  </th>
  <th>
    <?php include_partial('sort', array(
      'text' => 'Status',
      'sort_field' => 'status',
      'sort' => $sort
    ))?>
  </th>
  <th>
    <?php include_partial('sort', array(
      'text' => 'Result',
      'sort_field' => 'result_id',
      'sort' => $sort
    ))?>
  </th>
  <th>
    <?php include_partial('sort', array(
      'text' => 'Managers',
      'sort_field' => 'Managers',
      'sort' => $sort
    ))?>
  </th>
  </thead>
  <tbody>
  <?php foreach ($handlings as $handling) : ?>
    <tr>
      <td>
        <a href="<?php echo url_for('handling_show', array('handling_id' => $handling->getId()))?>">
          <?php echo $handling->getId()?>
        </a>
      </td>
      <td>
        <?php echo $handling->getOrganization()?>
      </td>
      <td>
        <?php echo format_date($handling->getCreatedatetime(), 'dd.MM.yyyy, HH:mm', 'ru')?>
      </td>
      <td>
        <?php echo format_date($handling->getLastHandlingDate(), 'dd.MM.yyyy', 'ru')?>
      </td>
      <td>
        <?php echo $handling->getOrganization() ? $handling->getOrganization()->getCity(): ''?>
      </td>
      <td>
        <?php echo $handling->getOrganization() ? $handling->getOrganization()->getScope(): ''?>
      </td>
      <td>
        <?php echo $handling->getServiceOffered()?>
      </td>
      <td>
        <?php echo $handling->getChance()?>
      </td>
      <td>
        <?php echo $handling->getStatusWithDate()?>
      </td>
      <td>
        <?php echo $handling->getResultName()?>
      </td>
      <td>
        <?php foreach ($handling->getHandlingUser() as $handlingUser) : ?>
          <?php echo $handlingUser->getUser()->getLastName()?> <?php echo $handlingUser->getUser()->getFirstName()?>,
        <?php endforeach;?>
      </td>
    </tr>
  <?php endforeach;?>
  </tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination">
    <a href="<?php echo url_for('handling/index') ?>?page=1">
      <?php echo __('First')?>
    </a>

    <a href="<?php echo url_for('handling/index') ?>?page=<?php echo $pager->getPreviousPage() ?>">
      <?php echo __('<<')?>
    </a>

    <?php foreach ($pager->links as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="<?php echo url_for('handling/index') ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>

    <a href="<?php url_for('handling/index') ?>?page=<?php echo $pager->getNextPage() ?>">
      <?php echo __('>>')?>
    </a>

    <a href="<?php echo url_for('handling/index') ?>?page=<?php echo $pager->getLastPage() ?>">
      <?php echo __('Last')?>
    </a>
  </div>
<?php endif; ?>