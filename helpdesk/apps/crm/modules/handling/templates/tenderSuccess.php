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
      <?php echo __('Service offered')?>
    </th>
    <th>
      <?php echo __('Budget')?>
    </th>
    <th>
      <?php echo __('Budget client')?>
    </th>
    <th>
      <?php include_partial('sort', array(
        'text' => 'Status',
        'sort_field' => 'status',
        'sort' => $sort
      ))?>
    </th>
    <th>
      result
    </th>
    <th>
      description
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
          <?php echo $handling->getServiceOffered()?>
        </td>
        <td>
          <?php echo $handling->getBudget()?>
        </td>
        <td>
          <?php echo $handling->getBudgetClient()?>
        </td>
        <td>
          <?php echo $handling->getStatus()?>
        </td>
        <td>
          <?php echo $handling->getResultName()?>
        </td>
        <td>
          <?php echo $handling->getDescription()?>
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