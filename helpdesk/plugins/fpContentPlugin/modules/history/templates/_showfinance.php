<?php use_helper('Date')?>
<table class="tableform">
  <thead>
    <tr>
      <th>N работы</th>
      <th>Действие</th>
      <th>Дата создания</th>
      <th>Кто осуществил действие</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($log_claims as $log_claim): ?>
    <tr>
      <td style="padding: 5px; border: 1px solid #000;"><?php echo $log_claim->getFinanceClaim()->getWork() ?></td>
      <td style="padding: 5px; border: 1px solid #000;"><?php echo $log_claim->getDescription() ?></td>
      <td style="padding: 5px; border: 1px solid #000;"><?php echo $log_claim->getCreatedatetimeGood() ?></td>
      <td style="padding: 5px; border: 1px solid #000;"><?php echo $log_claim->getUsers() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>