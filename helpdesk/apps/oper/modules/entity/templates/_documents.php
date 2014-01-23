<?php if (!sizeof($dogovors)):?>
<div class="groupbox"><?php echo __('There is no documents')?></div>
<?php else:?>
<div class="groupbox">Список договоров</div>
<table cellspacing="0" width="100%" class="gray">
  <thead>
    <tr>
      <th>Id</th>
      <th>C пролонгацией</th>
      <th>Организация</th>
      <th>Название</th>
      <th>Номер</th>
      <th>Дата заключения</th>
      <th>Дата окончания</th>
      <th>Город</th>
      <th>Предмет</th>
      <th>Статус</th>
      <th>Тип договора</th>
      <th><?php echo __('Creator')?></th>
      <th><?php echo __('Sell manager')?></th>
      <th>Маштаб</th>
      <th>Payment deferment</th>
      <th><?php echo __('Total')?></th>
      <th><?php echo __('File')?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($dogovors as $dogovor): ?>
    <tr>
      <td><?php echo $dogovor->getId() ?></td>
      <td><?php echo $dogovor->getProlongation() ? 'Да' : 'Нет' ?></td>
      <td><?php echo $dogovor->getOrganization() ?></td>
      <td><?php echo $dogovor->getName() ?></td>
      <td><?php echo $dogovor->getNumber() ?></td>
      <td><?php echo format_date($dogovor->getStartdatetime(), 'dd.MM.yyyy', 'ru'); ?></td>
      <td><?php echo format_date($dogovor->getStopdatetime(), 'dd.MM.yyyy', 'ru'); ?></td>
      <td><?php echo $dogovor->getCity() ?></td>
      <td><?php echo $dogovor->getSubject() ?></td>
      <td><?php echo $dogovor->getIsActive() ? 'Активный' : 'Неактивный'?></td>
      <td><?php echo $dogovor->getDogovorType() ?></td>
      <td><?php echo $dogovor->getUser() ?></td>
      <td><?php echo $dogovor->getStuff() ?></td>
      <td><?php echo $dogovor->getMashtab() == 'm_global' ? 'Сетевой' : 'Локальный' ?></td>
      <td><?php echo $dogovor->getPaymentDeferment()?></td>
      <td><?php echo $dogovor->getTotal() ?></td>
      <td><a href="/uploads/dogovor/<?php echo $dogovor->getFilepath()?>" target="_blank">Файл</a></td>    
    </tr>
    <tr>
      <td></td>
      <td colspan="16">
        <?php if (isset($dop_dogovors[$dogovor->getId()])):?>
          <div class="groupbox">Список доп соглашений для договора №<?php echo $dogovor->getId()?></div>
          <?php include_partial('entity/dop_dogovors_list', array('dopdogovors' => $dop_dogovors[$dogovor->getId()]))?>
        <?php else:?>
          <div class="groupbox">Нет дополнительных соглашений</div>
        <?php endif;?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif;?>