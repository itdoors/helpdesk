<table width='100%' cellpadding='0' cellspacing='0' class="gray">
    <tr>
        <td class='option' width='20%'>Id тикета</td>
        <td class='value' width='30%'><?php echo $claim->id?></td>
        <td class='option' width='20%'>Куратор</td>
        <td class='value' width='30%'><?php echo $claim->getKurator()?></td>
    </tr>
    <tr>
        <td class='option'>Отдел</td>
        <td class='value'><?php echo $claim->getClaimtype()?></td>
        <td class='option'>Исполнитель</td>
        <td class='value'>
        
        <?php echo $claim->getStuff()?>
        </td>
    </tr>
    <tr>
        <td class='option'>Создана</td>
        <td class='value'><?php  echo $claim->getCreatedatetimeGood()?></td>
        <td class='option'>Важность</td>
        <td class='value'><?php echo $claim->getImportance()?></td>
    </tr>
    <tr>
        <td class='option'>Закрыта</td>
        <td class='value'>&nbsp;<?php  echo $claim->getClosedatetimeGood()?></td>
        <td class='option'>Статус</td>
        <td class='value'>
              <?php echo $claim->getStatusLastDate()?><br />
              <?php echo $claim->getStatus()?>
        </td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Price with VAT')?></td>
        <td class='value'><div id="showTotalIncomeString<?php echo $claim->getId();?>" ><?php echo $claim->showTotalIncomeString()?></div></td>
        <td class='option'><?php echo __('Smeta status')?></td>
        <td class='value'>
       <?php echo get_component('Fmodel','ajax_field',
       array(
          'id'=> $claim->getId(),
          'model' => 'claim',
          'field' => 'smeta_status_id',
          'toString' =>'getSmetaStatus',
          'default' => $claim->getSmetaStatus(),
       )
       )?>
        </td>
        
    </tr>
    <tr>
        <td class='option'><?php echo __('Our costs')?></td>
        <td class='value'><div id="showTotalCostsString<?php echo $claim->getId();?>" ><?php echo $claim->showTotalCostsString()?></div></td>
        <td class='option'>История</td>
        <td class='value'><?php echo get_component('dialog','dialogopen', array('url'=>url_for('history/show').'/claimid/'.$claim->getId(),'text'=>'Показать историю'))?></td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Work list')?></td>
        <td class='value'><?php  echo $claim->getStuffdescription()?></td>
        <td class='option'></td>
        <td class='value'></td>
    </tr>
</table>