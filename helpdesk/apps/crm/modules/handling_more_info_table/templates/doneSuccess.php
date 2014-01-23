<a href="<?php echo url_for('handling_more_info_table')?>">
  <?php echo __('New request')?>
</a>
<br />
<?php echo $fromDate?> - <?php echo $toDate?>
<br />
<?php
  $moreInfo = HandlingMoreInfo::getAllFormattedData();
?>
<?php include_component('handling_more_info_table', 'filters',
  array(
    'filter_form' => $filter_form,
    'filter' => $filters,
    'baseRoute' => $baseRoute,
    'doneRoute' => $doneRoute
  )
)?>
<table class="gray">
  <tr>
    <td><?php echo __('Id')?></td>
    <td><?php echo __('Manager')?></td>
    <td><?php echo __('Organization')?></td>
    <td><?php echo __('Scope')?></td>
    <td><?php echo __('Result')?></td>
    <td><?php echo __('Предложенная цена ИГГ')?></td>
    <?php foreach($types as $type):?>
      <td><?php echo $type->getName()?></td>
    <?php endforeach;?>
  </tr>
  <?php foreach ($results as $result):?>
    <tr>
      <td>
        <a href="<?php echo url_for('handling_show', array('handling_id' => $result->getId()))?>" target="_blank">
          <?php echo $result->getId()?>
        </a>
      </td>
      <td>
        <?php foreach ($result->getHandlingUser() as $handlingUser) : ?>
          <?php echo $handlingUser->getUser()->getLastName()?> <?php echo $handlingUser->getUser()->getFirstName()?>,
        <?php endforeach;?>
      </td>
      <td>
        <?php echo $result->getOrganization()?>
      </td>
      <td>
        <?php echo $result->getOrganization() ? $result->getOrganization()->getScope(): ''?>
      </td>
      <td>
        <?php echo $result->getResultName()?>
      </td>
      <td>
        <?php echo $result->getBudget() * 1.2?>
      </td>
      <?php foreach($types as $type):?>
        <td>
          <?php
          echo isset($moreInfo[$result->getId()][$type->getId()]) ? $moreInfo[$result->getId()][$type->getId()] : ''  ?>
        </td>
      <?php endforeach;?>
    </tr>
  <?php endforeach;?>
</table>