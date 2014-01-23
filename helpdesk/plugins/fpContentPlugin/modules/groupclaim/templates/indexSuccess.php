<?php //TODO 1: перевод ?>  
<h1><b>Список груповых заявок</b></h1>

<table cellspacing="0" width="100%" class="gray">
  <thead>
    <tr>
      <th>№</th>
      <th>Название </th>
      <th>Категория </th>
      
     
      <th>Клиент</th>
      <th>Период запуска</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($groupclaims as $groupclaim): ?>
    <tr>
      <td style="padding: 5px;"><a href="<?php echo url_for('groupclaim/edit?id='.$groupclaim->getId()) ?>"><?php echo $groupclaim->getId() ?></a></td>
      <td style="padding: 5px;"><?php echo $groupclaim->getName() ?></td>
      <td style="padding: 5px;"><?php echo $groupclaim->getClaimtype() ?></td>
       <td style="padding: 5px;"><?php echo $groupclaim->getClient() ?></td>
      <td style="padding: 5px;"><?php echo $groupclaim->getPeriod() ?></td>  
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('groupclaim/new') ?>"><?php echo __('New')?></a>
