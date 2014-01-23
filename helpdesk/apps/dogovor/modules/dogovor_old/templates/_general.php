<table width='100%' cellpadding='0' cellspacing='0' class="gray">
    <tr>
        <td class='option' width='20%'>Id</td>
        <td class='value' width='30%'><?php echo $dogovor->getId()?></td>
        <td class='option' width='20%'>Пролонгация</td>
        <td class='value' width='30%'><?php echo $dogovor->getProlongation() ? 'Да' : 'Нет' ?></td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Organization')?></td>
        <td class='value'><?php echo $dogovor->getOrganization()?></td>
        <td class='option'>Название</td>
        <td class='value'><?php echo $dogovor->getName()?></td>
    </tr>
    <tr>
        <td class='option'>Дата заключения</td>
        <td class='value'><?php  echo format_date($dogovor->getStartdatetime(), 'dd.MM.yyyy', 'ru')?></td>
        <td class='option'>Дата окончания</td>
        <td class='value'><?php echo format_date($dogovor->getStopdatetime(), 'dd.MM.yyyy', 'ru')?></td>
    </tr>
    <tr>
        <td class='option'>Город</td>
        <td class='value'><?php  echo $dogovor->getCity()?></td>
        <td class='option'>Предмет</td>
        <td class='value'><?php  echo $dogovor->getSubject()?></td>
    </tr>
    <tr>
        <td class='option'>Файл</td>
        <td class='value'><a href="/uploads/dogovor/<?php echo $dogovor->getFilepath()?>" target="_blank">Файл</a></td>
        <td class='option'>Тип договора</td>
        <td class='value'><?php  echo $dogovor->getDogovorType()?></td>
    </tr>
    <tr>
        <td class='option'>Статус</td>
        <td class='value'><?php echo $dogovor->getIsActive() ? 'Активный' : 'Неактивный'?></td>
        <td class='option'>Маштаб</td>
        <td class='value'><?php  echo $dogovor->getMashtab() == 'm_global' ? 'Глобальный' : 'Сетевой'?></td>
        
    </tr>

</table>
