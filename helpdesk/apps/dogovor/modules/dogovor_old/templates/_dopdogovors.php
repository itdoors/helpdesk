<table cellspacing="0" width="100%" class="gray" id="example">
  <thead>
    <tr>
      <th>Id</th>
      <th>Тип дополнительного соглашения</th>
      <th>Номер</th>
      <th>Дата заключения</th>
      <th>Дата активации</th>
      <th>Предмет</th>
      <th>Статус</th>
      <th>Файл</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($dopdogovors as $dogovor): ?>
    <tr>
      <td><?php echo $dogovor->getId() ?></td>
      <td><?php echo $dogovor->getDopDogovorType() ?></td>
      <td><?php echo $dogovor->getNumber() ?></td>
      <td><?php echo format_date($dogovor->getStartdatetime(), 'dd.MM.yyyy', 'ru') ?></td>
      <td><?php echo format_date($dogovor->getActivedatetime(), 'dd.MM.yyyy', 'ru') ?></td>
      <td><?php echo $dogovor->getSubject() ?></td>   
      <td><?php echo $dogovor->getIsActive() ? 'Активный' : 'Неактивный' ?></td>   
      <td><a href="/uploads/dogovor/<?php echo $dogovor->getFilepath()?>" target="_blank">Файл</a></td>   

    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
