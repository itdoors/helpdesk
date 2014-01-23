<?php $worklist = $claim->getFinanceClaimRecords();?>
<table width='100%' cellpadding='0' cellspacing='0' class="gray">
    <tr>
      <th>Работа</th>
      <th>Доход (С НДС)</th>
      <th>Затраты (Нал)</th>
      <th><?php echo __('Costs without VAT')?></th>
      <th>Затраты (С НДС)</th>
      <th>Рентабельность</th>  
      <th>Статус</th>
    </tr>
<?php foreach ($worklist as $work):?>
    <tr>
       <td>
       <?php echo  $work->getWork();?>
       </td> 
       <td>
       <?php echo  $work->getIncomeNdsFloat();?>
       </td> 
       <td>
       <?php if ($sf_user->hasCredential('superkurator') && !$claim->getIsclosedstuff()):?>
       <?php 
       echo get_component('dialog','dialogopen', 
                    array(
                        'url'=>url_for('FcCostsn/show').'/finance_claim_id/'.$work->getId(),
                        'text'=>finance_claim::getTotalCostsnStatic($work->getId()),
                        'target' => 'costsn'.$work->getId(),
                        'ref_functions' =>
                          array(
                           '.costsn'.$work->getId()."_link"=>url_for('F_finance_claim/refresh_costsn').'/finance_claim_id/'.$work->getId(),
                           '#profitability'.$work->getId()=>url_for('F_finance_claim/refresh_profitability').'/id/'.$work->getId(),
                           '.totalcosts'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalCostsNds',
                           '#showTotalCostsString'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalCostsNds',
                            '.totalprofitability'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalProfitabilityResponse'
                               )
                    )
       )?>
       <?php else:?>
       <?php echo finance_claim::getTotalCostsnStatic($work->getId());?>
       <?php endif;?>
       </td>
       <td><?php echo $work->getCostsBeznalnonnds()?></td> 
       <td>
       <?php echo $work->getCostsNdsFloat();?>
       </td> 
       <td><div id="profitability<?php echo $work->getId()?>"><?php echo include_partial('F_finance_claim/profitability_response', array('finance_claim'=>$work))?></div></td> 
       <td>
       <?php echo  $work->getStatus().' ('.$work->getStatusLastDate().')';?>
       </td> 
    </tr>
    
<?php endforeach;?>    
<tfoot>
  <td></td>
  <td></td>
  <td>Всего: <div class="totalincome<?php echo $claim->getId()?>"><?php echo $claim->getTotalIncomeNds();?></div></td>
  <td></td>
  <td></td>
  <td>Всего: <div class="totalcosts<?php echo $claim->getId()?>"><?php echo $claim->getTotalCostsNds();?></div></td>
  <td>Всего: <div class="totalprofitability<?php echo $claim->getId()?>"><?php echo $claim->getTotalProfitabilityResponse();?></div></td>
  <td></td>
</tfoot>
</table>
