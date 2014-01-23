<h1>История заявок</h1>
<table>
  <thead>
    <tr>
      <th># Заявки</th>
      <th>Действие</th>
      <th>Дата создания</th>
      <th>Кто осуществил действие</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($log_claims as $log_claim): ?>
    <tr>
      <td style="padding: 5px; border: 1px solid #000;"><?php echo $log_claim->getClaimId() ?></td>
      <td style="padding: 5px; border: 1px solid #000;"><?php echo $log_claim->getDescription() ?></td>
      <td style="padding: 5px; border: 1px solid #000;"><?php echo $log_claim->getCreatedatetime() ?></td>
      <td style="padding: 5px; border: 1px solid #000;"><?php echo $log_claim->getUsers() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

