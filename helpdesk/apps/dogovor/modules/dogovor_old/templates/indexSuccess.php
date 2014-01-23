<?php use_helper('Text', 'Date') ?>
<?php 
// обьявление фильтров
$filters = array(
        '2'=>__("Organization"),
        '6'=>__("Город"),
        '8'=>__("Статус"),
        '9'=>__("Тип догвора"),
        '10'=>__("Маштаб"),
        
        
      );
include_partial('common/datatables_general', array('filters'=> $filters)); 
?>   

<!--вставка фильтров-->
<?php include_partial('common/datatables_show_filters', array('filters'=> $filters)); ?> 
<!--вставка фильтров конец-->
 
 

<div class="groupbox">Список договоров</div>
<table cellspacing="0" width="100%" class="gray" id="example">
  <thead>
    <tr>
      <th>Id</th>
      <th>C пролонгацией</th>
      <th>Организация</th>
      <th>Название</th>
      <th>Дата заключения</th>
      <th>Дата окончания</th>
      <th>Город</th>
      <th>Предмет</th>
      <th>Статус</th>
      <th>Тип договора</th>
      <th>Маштаб</th>
      <th>Действия</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($dogovors as $dogovor): ?>
    <tr>
      <td><a href="<?php echo url_for('dogovor/show?id='.$dogovor->getId()) ?>"><?php echo $dogovor->getId() ?></a></td>
      <td><?php echo $dogovor->getProlongation() ? 'Да' : 'Нет' ?></td>
      <td><?php echo $dogovor->getOrganization() ?></td>
      <td><?php echo $dogovor->getName() ?></td>
      <td><?php echo format_date($dogovor->getStartdatetime(), 'dd.MM.yyyy', 'ru'); ?></td>
      <td><?php echo format_date($dogovor->getStopdatetime(), 'dd.MM.yyyy', 'ru'); ?></td>
      <td><?php echo $dogovor->getCity() ?></td>
      <td><?php echo $dogovor->getSubject() ?></td>
      <td><?php echo $dogovor->getIsActive() ? 'Активный' : 'Неактивный'?></td>
      <td><?php echo $dogovor->getDogovorType() ?></td>
      <td><?php echo $dogovor->getMashtab() == 'm_global' ? 'Глобальный' : 'Сетевой' ?></td>
      <td>
      <ul class="sf_admin_td_actions">
        <li class="sf_admin_action_view">
             <a href="<?php echo url_for('dogovor/show?id='.$dogovor->getId()) ?>">Подробнее</a>
        </li> 
      </ul>
       
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

