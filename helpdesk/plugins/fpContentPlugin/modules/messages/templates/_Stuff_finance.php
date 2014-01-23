<table width='100%' cellpadding='0' cellspacing='0' class="gray">
    <tr>
        <td class='option'>Доход (c НДС)</td>
        <td class='value'><div class="totalincome<?php echo $claim->getId()?>"><?php echo $claim->getTotalIncomeNds();?></div></td>
        <td class='option'>Затраты (Общие С НДС)</td>
        <td class='value'><div class="totalcosts<?php echo $claim->getId()?>"><?php echo $claim->getTotalCostsNds();?></div> </td>
    </tr>
 
    <tr>
        <td class='option'>Документы</td>
        <td class='value'><?php get_component('ajax','ajaxAllDocumentsList', array('claim_id'=>$claim->getId()));
 
                            ?></td>
        <td class='option'>Рентабельность</td>
        <td class='value'><div class="totalprofitability<?php echo $claim->getId()?>"><?php echo $claim->getTotalProfitabilityResponse();?></div></td>
    </tr>
    <tr>
        <td class='option'>Номер счета</td>
        <td class='value'>
            <?php echo  $claim->getBillNumber();?>
        </td>
        <td class='option'>Формулировка в счете</td>
        <td class='value'>        
        <?php echo  $claim->getBillDescription();?></td>
    </tr>

    <tr>
        <td class='option'>Номер сметы</td>
        <td class='value'><?php echo $claim->getSmetaNumber()?>
        </td>
        <td class='option'>Предварительная сметная стоимость</td>
        <td class='value'><?php echo $claim->getSmetaCosts()?>        
         </td>
    </tr>
    <?php if ($sf_user->hasCredential('superkurator')) :?>
    <tr>
      <td class='option'><?php echo __('Bill date')?></td>
      <td class='value'><?php echo get_component('Fmodel','ajax_field',
          array(
            'id'=> $claim->getId(),
            'model' => 'claim',
            'field' => 'bill_date',
            'toString' =>'getBillDateFormatted',
            'default' => $claim->getBillDateFormatted(),
            )
         )?> </td>
      <td class='option'></td>
      <td class='value'></td>
    </tr>
    <?php endif;?>
    
    
</table>