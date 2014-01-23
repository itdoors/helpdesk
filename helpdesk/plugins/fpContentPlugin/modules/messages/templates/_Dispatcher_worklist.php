
<?php $worklist = $claim->getFinanceClaimRecords(); 
$i = 0;?>
<table width='100%' cellpadding='0' cellspacing='0' class="gray">
    <tr>
      <th><?php echo __('#')?></th>
      <th><?php echo __('Mpk')?></th>
      <th><?php echo __('Work')?></th>
      <th><?php echo __('Income with VAT')?></th>
      <th><?php echo __('Costs (cash)')?></th>
      <th><?php echo __('Costs without VAT')?></th>
      <th><?php echo __('Costs with VAT')?></th>
      <th><?php echo __('Profitability')?></th>  
      <th><?php echo __('Status')?></th>
    </tr>
<?php foreach ($worklist as $work):?>
    <tr>
       <td><?php echo ++$i;?></td>
       <td>
       <?php echo get_component('Fmodel','ajax_field',
       array(
          'id'=> $work->getId(),
          'model' => 'finance_claim',
          'field' => 'mpk',
          'toString' =>'getMpk',
          'default' => $work->getMpk(),
          )
       )?>
       </td>
       <td>
       <?php echo get_component('Fmodel','ajax_field',
       array(
          'id'=> $work->getId(),
          'model' => 'finance_claim',
          'field' => 'work',
          'toString' =>'getWork',
          'default' => $work->getWork(),
          )
       )?>
       </td> 
       <td>
       <?php echo get_component('Fmodel','ajax_field',
       array(
          'id'=> $work->getId(),
          'model' => 'finance_claim',
          'field' => 'income_nds',
          'toString' =>'getIncomeNdsFloat',
          'default' =>  $work->getIncomeNdsFloat(),
          'ref_functions'=>
           array(
               '#profitability'.$work->getId()=>url_for('F_finance_claim/refresh_profitability').'/id/'.$work->getId(),
               '.totalincome'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalIncomeNds',
               '#showTotalIncomeString'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalIncomeNds',
               '.totalprofitability'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalProfitabilityResponse'
           )
       )
       )?>
       </td> 
       <td><?php 
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

       </td>
       <td>
       <?php echo get_component('Fmodel','ajax_field',
       array(
          'id'=> $work->getId(),
          'model' => 'finance_claim',
          'field' => 'costs_beznalnonnds',
          'toString' =>'getCostsBeznalnonnds',
          'default' => $work->getCostsBeznalnonnds(),
          'ref_functions'=>
           array(
             '#profitability'.$work->getId()=>url_for('F_finance_claim/refresh_profitability').'/id/'.$work->getId(),
             '.totalcosts'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalCostsNds',
             '#showTotalCostsString'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalCostsNds',
             '.totalprofitability'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalProfitabilityResponse'
             )
       )
       )?>
       </td>  
       <td>
       <?php echo get_component('Fmodel','ajax_field',
       array(
          'id'=> $work->getId(),
          'model' => 'finance_claim',
          'field' => 'costs_nds',
          'toString' =>'getCostsNdsFloat',
          'default' => $work->getCostsNdsFloat(),
          'ref_functions'=>
           array(
               '#profitability'.$work->getId()=>url_for('F_finance_claim/refresh_profitability').'/id/'.$work->getId(),
               '.totalcosts'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalCostsNds',
               '#showTotalCostsString'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalCostsNds',
               '.totalprofitability'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalProfitabilityResponse'
           )
       )
       )?>
       </td>
       <td><div id="profitability<?php echo $work->getId()?>"><?php echo include_partial('F_finance_claim/profitability_response', array('finance_claim'=>$work))?></div></td> 
       <td>
       <?php echo get_component('Fmodel','ajax_field',
       array(
          'id'=> $work->getId(),
          'model' => 'finance_claim',
          'field' => 'status_id',
          'toString' =>'getStatus',
          'default' => $work->getStatus().' ('.$work->getStatusLastDate().')',
       )
       )?>
       </td> 
    </tr>
<?php endforeach;?>    
<tfoot>
  <td></td>
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
