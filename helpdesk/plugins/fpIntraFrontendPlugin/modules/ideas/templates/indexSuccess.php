<?php use_helper('Text', 'Date') ?>

<?php include_component('ideas', 'filters',
  array(
    'filter_form' => $filter_form,
    'filter' => $filters,
  )
)?>

<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination">
    <a href="<?php echo url_for($baseRoute) ?>?page=1">
      <?php echo __('First')?>
    </a>

    <a href="<?php echo url_for($baseRoute) ?>?page=<?php echo $pager->getPreviousPage() ?>">
      <?php echo __('<<')?>
    </a>

    <?php foreach ($pager->links as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="<?php echo url_for($baseRoute) ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>

    <a href="<?php url_for($baseRoute) ?>?page=<?php echo $pager->getNextPage() ?>">
      <?php echo __('>>')?>
    </a>

    <a href="<?php echo url_for($baseRoute) ?>?page=<?php echo $pager->getLastPage() ?>">
      <?php echo __('Last')?>
    </a>
  </div>
<?php endif; ?>

<br />
<a href="<?php echo url_for('ideas_new')?>"><?php echo __('New idea')?></a>
<br />
<a href="<?php echo "http://" . $_SERVER['HTTP_HOST']."/images/instruction-ideas.pdf"?>">
  <?php echo __('Instruction ideas')?>
</a>

<table cellspacing="0" width="100%" class="gray" id="example">
  <thead>
  <tr>
    <th><?php echo __('Id')?></th>
    <th><?php echo __('Name')?></th>
    <th><?php echo __('Createdatetime')?></th>
    <th><?php echo __('Staff')?></th>
    <th><?php echo __('Total')?></th>
  </tr>
  </thead>
  <tbody>
  <?php
  $total = 0;
  foreach ($records as $record) :
    $total += $record->getTotal();
    ?>
    <tr>
      <td>
        <a href="<?php echo url_for($showRoute, array('id' => $record->getId()))?>">
          <?php echo $record->getId()?>
        </a>
      </td>
      <td>
        <?php echo $record->getName()?>
      </td>
      <td>
        <?php echo format_date($record->getCreatedatetime(), 'dd.MM.yyyy HH:mm', 'ru')?>
      </td>
      <td>
        <?php echo $record->getUser()?>
      </td>
      <td>
        <?php echo $record->getTotal()?>
      </td>
    </tr>
  <?php endforeach;?>
  <tr>
    <td colspan="4"><?php echo __('Total')?></td>
    <td><?php echo $total?></td>
  </tr>
  </tbody>
</table>

<?php if ($pager->haveToPaginate()): ?>
  <div class="pagination">
    <a href="<?php echo url_for($baseRoute) ?>?page=1">
      <?php echo __('First')?>
    </a>

    <a href="<?php echo url_for($baseRoute) ?>?page=<?php echo $pager->getPreviousPage() ?>">
      <?php echo __('<<')?>
    </a>

    <?php foreach ($pager->links as $page): ?>
      <?php if ($page == $pager->getPage()): ?>
        <?php echo $page ?>
      <?php else: ?>
        <a href="<?php echo url_for($baseRoute) ?>?page=<?php echo $page ?>"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>

    <a href="<?php url_for($baseRoute) ?>?page=<?php echo $pager->getNextPage() ?>">
      <?php echo __('>>')?>
    </a>

    <a href="<?php echo url_for($baseRoute) ?>?page=<?php echo $pager->getLastPage() ?>">
      <?php echo __('Last')?>
    </a>
  </div>
<?php endif; ?>