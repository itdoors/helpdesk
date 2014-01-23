<?php use_helper('Date')?>
<table class="tableform">
  <thead>
    <tr>
      <th>Действие</th>
      <th>Дата создания</th>
      <th>From</th>
      <th>To</th>
      <th>Кто осуществил действие</th>
      <th>More</th>
    </tr>
</thead>
  <tbody>
    <?php foreach ($list as $history): ?>
    <tr>
      <td style="padding: 5px; border: 1px solid #000;"><?php echo $history->getFieldName() ?></td>
      <td style="padding: 5px; border: 1px solid #000;"><?php echo $history->getCreatedatetimeGood() ?></td>
      <td style="padding: 5px; border: 1px solid #000;"><?php echo $history->getOldValue() ?></td>
      <td style="padding: 5px; border: 1px solid #000;"><?php echo $history->getValue() ?></td>
      <td style="padding: 5px; border: 1px solid #000;"><?php echo $history->getUser() ?></td>
      <td style="padding: 5px; border: 1px solid #000;"><?php echo $history->getMore() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
