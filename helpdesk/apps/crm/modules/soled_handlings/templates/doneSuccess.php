<a href="<?php echo url_for('soled_handlings')?>">
  <?php echo __('New request')?>
</a>
<br />
<?php echo $fromDate?> - <?php echo $toDate?>
<br />
<?php include_component('soled_handlings', 'filters',
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
    <td><?php echo __('Number')?></td>
    <td><?php echo __('Startdatetime')?></td>
    <td><?php echo __('Stopdatetime')?></td>
    <td><?php echo __('Subject')?></td>
    <td><?php echo __('Launch date')?></td>
    <td><?php echo __('Mashtab')?></td>
    <td><?php echo __('Summ Month Vat')?></td>
    <td><?php echo __('Planned Pf1')?></td>
    <td><?php echo __('Planned Pf1 Percent')?></td>
  </tr>
  <?php foreach ($results as $result):?>
    <tr>
      <td><?php
        $data = $result->getDogovorHandling()->getRawValue()->getData();
        $handlingId = isset($data[0]) && $data[0]->getHandlingId() ? $data[0]->getHandlingId() : null;?>
        <?php if ($handlingId) : ?>
          <a href="<?php echo url_for('handling_show', array('handling_id' => $handlingId))?>" target="_blank">
        <?php endif;?>
          <?php echo $handlingId?>
        <?php if ($handlingId) : ?>
          </a>
        <?php endif;?>
      </td>
      <td><?php echo $result->getStuff()?></td>
      <td><?php echo $result->getNumber()?></td>
      <td><?php echo format_date($result->getStartdatetime(), 'dd.MM.yyyy', 'ru')?></td>
      <td><?php echo format_date($result->getStopdatetime(), 'dd.MM.yyyy', 'ru'); ?></td>
      <td><?php echo $result->getSubject()?></td>
      <td><?php echo format_date($result->getLaunchDate(), 'dd.MM.yyyy', 'ru'); ?></td>
      <td><?php echo $result->getMashtab() == 'm_global' ? 'Сетевой' : 'Локальный' ?></td>
      <td><?php echo $result->getSummMonthVat()?></td>
      <td><?php echo $result->getPlannedPf1()?></td>
      <td><?php echo $result->getPlannedPf1Percent()?></td>
    </tr>
  <?php endforeach; ?>
</table>