<?php use_helper('Text', 'Date') ?>
<?php 
// обьявление фильтров
$filters = array(
        '2'=>__("Organization"),
        '7'=>__("Город"),
        '9'=>__("Статус"),
        '10'=>__("Тип догвора"),
        '13'=>__("Маштаб"),
      );
$summ_columns = array(16);
include_partial('common/datatables_general', 
  array(
    'filters'=> $filters, 
    'date_sorting' => array('sort_columns' => array(5, 6),
                            'columns_count' => 18
                            ),
    'summ_columns' => $summ_columns
    ));  
?>   

<!--вставка фильтров-->
<?php include_partial('common/datatables_show_filters', array('filters'=> $filters, 'prefix'=>'dogovor')); ?>
<!--вставка фильтров конец-->
 
 

<div class="groupbox">Список договоров</div>
<table cellspacing="0" width="100%" class="gray" id="example">
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
      <th><?php echo __('Company role')?></th>
      <th>Маштаб</th>
      <th>Payment deferment</th>
      <th><?php echo __('Total')?></th>
      <th>Действия</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($dogovors as $dogovor): ?>
    <tr>
      <td><a href="<?php echo url_for('dogovor/edit?id='.$dogovor->getId()) ?>"><?php echo $dogovor->getId() ?></a></td>
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
      <td><?php echo $dogovor->getCompanyRole() ?></td>
      <td><?php echo $dogovor->getMashtab() == 'm_global' ? 'Сетевой' : 'Локальный' ?></td>
      <td><?php echo $dogovor->getPaymentDeferment()?></td>
      <td><?php echo $dogovor->getTotal() ?></td>
      <td>
      <ul class="sf_admin_td_actions">
        <li class="sf_admin_action_view">
             <a href="<?php echo url_for('dogovor/edit?id='.$dogovor->getId()) ?>">Подробнее</a>
        </li> 
      </ul>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
  <tr> 
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
  </tfoot>
</table>

<?php if ($sf_user->hasCredential('dogovoradmin')):?>
  <a href="<?php echo url_for('dogovor/new')?>"><?php echo __('New')?></a>
<?php endif;?>

