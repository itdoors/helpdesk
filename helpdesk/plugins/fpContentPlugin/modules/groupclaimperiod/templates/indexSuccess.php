<h1><b>Периодичность запуска</b></h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Групповая заявка</th>
      <th>Дни</th>
      <th>Месяц</th>
      <th>Год</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($groupclaimperiods as $groupclaimperiod): ?>
    <tr>
      <td style="padding: 5px;"><a href="<?php echo url_for('groupclaimperiod/edit?id='.$groupclaimperiod->getId()) ?>"><?php echo $groupclaimperiod->getId() ?></a></td>
      <td style="padding: 5px;"><?php echo $groupclaimperiod->getGroupclaimId() ?></td>
      <td style="padding: 5px;"><?php echo $groupclaimperiod->getPeriodDay() ?></td>
      <td style="padding: 5px;"><?php echo $groupclaimperiod->getPeriodMonth() ?></td>
      <td style="padding: 5px;"><?php echo $groupclaimperiod->getPeriodYear() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('groupclaimperiod/new') ?>">Создать</a>
