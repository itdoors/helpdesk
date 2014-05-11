<?php echo __('Planned accrual officially') ?>
<table class="gray">
  <tr>
    <th><?php echo __('Planned accrual name')?></th>
    <th><?php echo __('Planned accrual date')?></th>
    <th><?php echo __('Planned accrual value')?></th>
  </tr>
<?php
  /** @var plannedAccrual[] $plannedAccrualOfficially */
  foreach($plannedAccrualOfficially as $pao) : ?>
  <tr>
    <td><?php echo $pao->getName()?></td>
    <td><?php echo $pao->getPeriod()?></td>
    <td><?php echo $pao->getValue()?></td>
  </tr>
<?php endforeach; ?>
</table>

<?php echo __('Planned accrual not officially') ?>
<table class="gray">
  <tr>
    <th><?php echo __('Planned accrual name')?></th>
    <th><?php echo __('Planned accrual date')?></th>
    <th><?php echo __('Planned accrual value')?></th>
  </tr>
  <?php
  /** @var plannedAccrual[] $plannedAccrualNotOfficially */
  foreach($plannedAccrualNotOfficially as $pan) : ?>
    <tr>
      <td><?php echo $pan->getName()?></td>
      <td><?php echo $pan->getPeriod()?></td>
      <td><?php echo $pan->getValue()?></td>
    </tr>
  <?php endforeach; ?>
</table>