<table width='100%' cellpadding='0' cellspacing='0' class="gray">
    <tr>
        <td class='option'>Доход (без НДС)</td>
        <td class='value'><?php echo get_component('ajax','ajaxField', 
                                   array(
                                       'default'=>number_format($claim->getFinanceClaim()->getIncomeNonnds(), 2),
                                       'field' => 'income_nonnds',
                                       'relfield' => 'income_nds',
                                       'relfieldRefreshFunction' => url_for('ajax/getAjaxField'),
                                       'claim_id' => $claim->getId(), 
                                       'url_open'=>url_for('ajax/ajaxFieldForm'),
                                       'formtemplate' => '',
                                       'url_refresh' =>url_for('ajax/getAjaxField')
                                       ))
                            ?></td>
        <td class='option'>Затраты (нал)</td>
        <td class='value'><?php echo get_component('ajax','ajaxField', 
                                   array(
                                       'default'=>number_format($claim->getFinanceClaim()->getCostsN(), 2),
                                       'field' => 'costs_n',
                                       'claim_id' => $claim->getId(), 
                                       'url_open'=>url_for('ajax/ajaxFieldForm'),
                                       'formtemplate' => '',
                                       'url_refresh' =>url_for('ajax/getAjaxField')
                                       ))
                            ?>
         </td>
    </tr>
    <tr>
        <td class='option'>Доход (с НДС)</td>
        <td class='value'><?php echo get_component('ajax','ajaxField', 
                                   array(
                                       'default'=>number_format($claim->getFinanceClaim()->getIncomeNds(), 2),
                                       'field' => 'income_nds',
                                       'relfield' => 'income_nonnds',
                                       'relfieldRefreshFunction' => url_for('ajax/getAjaxField'),
                                       'claim_id' => $claim->getId(), 
                                       'url_open'=>url_for('ajax/ajaxFieldForm'),
                                       'formtemplate' => '',
                                       'url_refresh' => url_for('ajax/getAjaxField')
                                       ))
                            ?>
        </td>
        
        <td class='option'>Затраты (без НДС)</td>
        <td class='value'><?php echo get_component('ajax','ajaxField', 
                                   array(
                                       'default'=>number_format($claim->getFinanceClaim()->getCostsNonnds(), 2),
                                       'field' => 'costs_nonnds',
                                       'relfield' => 'costs_nds',
                                       'relfieldRefreshFunction' => url_for('ajax/getAjaxField'),
                                       'claim_id' => $claim->getId(), 
                                       'url_open'=>url_for('ajax/ajaxFieldForm'),
                                       'formtemplate' => '',
                                       'url_refresh' =>url_for('ajax/getAjaxField')
                                       ))
                            ?>
        </td>
    </tr>
        <tr>
        <td class='option'>Рентабельность</td>
        <td class='value'><div id="result_profitability"><?php echo $claim->getFinanceClaim()->getProfitabilityResponse()?></div>
        </td>
        
        <td class='option'>Затраты (с НДС)</td>
        <td class='value'><?php echo get_component('ajax','ajaxField', 
                                   array(
                                       'default'=>number_format($claim->getFinanceClaim()->getCostsNds(), 2),
                                       'field' => 'costs_nds',
                                       'relfield' => 'costs_nonnds',
                                       'relfieldRefreshFunction' => url_for('ajax/getAjaxField'),
                                       'claim_id' => $claim->getId(), 
                                       'url_open'=>url_for('ajax/ajaxFieldForm'),
                                       'formtemplate' => '',
                                       'url_refresh' =>url_for('ajax/getAjaxField')
                                       ))
                            ?>
        </td>
    </tr>
    <tr>
        <td class='option'>Документы</td>
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
        <td class='option'>История</td>
        <td class='value'><?php echo get_component('dialog','dialogopen', array('url'=>url_for('history/showfinance').'/claimid/'.$claim->getId(),'text'=>'Показать историю'))?>
        </td>
    </tr>
        <tr>
        <td class='option'>Статус</td>
        <td class='value'><?php echo $claim->getFinanceClaim()->getIsClosed()?'Утверждена':'Неутверждена'?></td>
        <td class='option'></td>
        <td class='value'>
        </td>
    </tr>
    
    
</table>