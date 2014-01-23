<table width='100%' cellpadding='0' cellspacing='0' class="gray">
    <tr>
        <td class='option'><?php echo __('Income with VAT')?></td>
        <td class='value'><div class="totalincome<?php echo $claim->getId()?>"><?php echo $claim->getTotalIncomeNds();?></div></td>
        <td class='option'><?php echo __('Costs total with VAT')?></td>
        <td class='value'><div class="totalcosts<?php echo $claim->getId()?>"><?php echo $claim->getTotalCostsNds();?></div> </td>
    </tr>
 
    <tr>
        <td class='option'><?php echo __('Documents')?></td>
        <td class='value'><?php echo get_component('ajax','ajaxField', 
                                   array(
                                       'default'=>get_component('ajax','ajaxAllDocumentsList', array('claim_id'=>$claim->getId())),  
                                       'field' => 'smeta_file',
                                       'claim_id' => $claim->getId(), 
                                       'url_open'=>url_for('ajax/ajaxFieldFormDocuments'),
                                       'url_save'=>url_for('ajax/ajaxFieldFormSaveDocuments'),
                                       'formtemplate' => 'ajaxFieldFormDocuments',
                                       //'formtemplate' => url_for('_formsmeta'),
                                       'url_refresh' =>url_for('ajax/getAjaxField')
                                       )) 
                            ?></td>
        <td class='option'><?php echo __('Profitability')?></td>
        <td class='value'><div class="totalprofitability<?php echo $claim->getId()?>"><?php echo $claim->getTotalProfitabilityResponse();?></div></td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Bill number')?></td>
        <td class='value'>
        <?php echo get_component('Fmodel','ajax_field',
        array(
          'id'=> $claim->getId(),
          'model' => 'claim',
          'field' => 'bill_number',
          'toString' =>'getBillNumber',
          'default' => $claim->getBillNumber(),
          )
       )?>
        </td>
        <td class='option'><?php echo __('Akt date')?></td>
        <td class='value'>        
        <?php echo get_component('Fmodel','ajax_field',
        array(
          'id'=> $claim->getId(),
          'model' => 'claim',
          'field' => 'akt_date',
          'toString' =>'getAktDate',
          'default' => $claim->getAktDate(),
          )
       )?></td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Smeta number')?></td>
        <td class='value'><?php echo get_component('Fmodel','ajax_field',
        array(
          'id'=> $claim->getId(),
          'model' => 'claim',
          'field' => 'smeta_number',
          'toString' =>'getSmetaNumber',
          'default' => $claim->getSmetaNumber(),
          )
       )?>
        </td>
        <td class='option'><?php echo __('Preliminary smeta costs')?></td>
        <td class='value'><?php echo get_component('Fmodel','ajax_field',
        array(
          'id'=> $claim->getId(),
          'model' => 'claim',
          'field' => 'smeta_costs',
          'toString' =>'getSmetaCosts',
          'default' => $claim->getSmetaCosts(),
          )
       )?>        
         </td>
    </tr>
    
    <tr>
        <td class='option'><?php echo __('Finance status')?></td>
        <td class='value'>
        <?php echo get_component('ajax','boolButton',
        array(
          'claim_id'=> $claim->getId(),
          'url_change' => url_for('ajax/change_bool_claim')
          )
       )?>
        </td>
        <td class='option'><?php echo __('Bill date')?></td>
        <td class='value'><?php echo get_component('Fmodel','ajax_field',
          array(
            'id'=> $claim->getId(),
            'model' => 'claim',
            'field' => 'bill_date',
            'toString' =>'getBillDateFormatted',
            'default' => $claim->getBillDateFormatted(),
            )
         )?>        
        </td>
    </tr>
    
    
</table>