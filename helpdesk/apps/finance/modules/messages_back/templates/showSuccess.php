<?php use_helper('Text', 'Date') ?>
<script>
$(document).ready(function() {
   $("#claimtabs").tabs();
});
</script>

<div class="groupbox"><?php echo $claim->getOrganization()?> - <?php echo $claim->getDepartments()?><div style="float: right;"><a href="<?php echo url_for('prnt/show?claimid='.$claim->getId())?>"><?php echo __('Print')?></a></div></div>
<div id="claimtabs">
   <ul>
      <li><a href="#claim_general"><span><?php echo __('Claim general') ?></span></a></li>
      <li><a href="#claim_finance"><span><?php echo __('Claim finance') ?></span></a></li>
   </ul>
   <div id="claim_general">
       
<table width='100%' cellpadding='0' cellspacing='0' class="gray">
    <tr>
        <td class='option' width='20%'>Id тикета</td>
        <td class='value' width='30%'><?php echo $claim->id?></td>
        <td class='option' width='20%'>Куратор</td>
        <td class='value' width='30%'><div id="loading_kurator" class="loading_image"></div><div id="dispatcher_change_kurator_value">&nbsp;<?php echo $claim->getKurator()?><a href="<?php echo url_for('claimopened/editkuratorajax').'/id/'.$claim->id; ?>" id="dispatcher_change_kurator_button" class="sf_admin_action_edit"><?php echo __('Change')?></a></div></td>
    </tr>
    <tr>
        <td class='option'>Отдел</td>
        <td class='value'><div id="loading_claimtype" class="loading_image"></div><div id="dispatcher_change_claimtype_value">&nbsp;<?php echo $claim->getClaimtype()?><a href="<?php echo url_for('claimopened/editclaimtypeajax').'/id/'.$claim->id; ?>" id="dispatcher_change_claimtype_button" class="sf_admin_action_edit"><?php echo __('Change')?></a></div></td>
        <td class='option'>Исполнитель</td>
        <td class='value'><div id="loading_stuff" class="loading_image"></div><div id="dispatcher_change_stuff_value">&nbsp;<?php echo $claim->getStuff()?><a href="<?php echo url_for('claimopened/editstuffajax').'/id/'.$claim->id; ?>" id="dispatcher_change_stuff_button" class="sf_admin_action_edit"><?php echo __('Change')?></a></div></td>
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
          <div id="loading_status" class="loading_image"></div>
          <div id="dispatcher_change_status_value">
              <?php echo $claim->getStatusLastDate()?><br />
              <?php echo $claim->getStatus()?>
              <a href="<?php echo url_for('claimopened/editstatusajax').'/id/'.$claim->id; ?>" id="dispatcher_change_status_button" class="sf_admin_action_edit"><?php echo __('Change')?></a>
          </div>
           
        </td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Price with VAT')?></td>
        <td class='value'><div id="loading_description" class="loading_image"></div><div id="dispatcher_change_description_value">&nbsp;<?php  echo $claim->getDescription()?><a href="<?php echo url_for('claimopened/editdescriptionajax').'/id/'.$claim->id; ?>" id="dispatcher_change_description_button" class="sf_admin_action_edit"><?php echo __('Change')?></a><div></td>
        <td class='option'><?php echo __('Work list')?></td>
        <td class='value'><div id="loading_stuffdescription" class="loading_image"></div><div id="dispatcher_change_stuffdescription_value">&nbsp;<?php  echo $claim->getStuffdescription()?><a href="<?php echo url_for('claimopened/editstuffdescriptionajax').'/id/'.$claim->id; ?>" id="dispatcher_change_stuffdescription_button" class="sf_admin_action_edit"><?php echo __('Change')?></a><div></td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Our costs')?></td>
        <td class='value'><div id="loading_ourcosts" class="loading_image"></div><div id="dispatcher_change_ourcosts_value">&nbsp;<?php  echo $claim->getOurcosts()?><a href="<?php echo url_for('claimopened/editourcostsajax').'/id/'.$claim->id; ?>" id="dispatcher_change_ourcosts_button" class="sf_admin_action_edit"><?php echo __('Change')?></a><div></td>
        <td class='option'>История</td>
        <td class='value'><?php echo get_component('dialog','dialogopen', array('url'=>url_for('history/show').'/claimid/'.$claim->getId(),'text'=>'Показать историю'))?></td>
    </tr>
</table>
   </div>
   <div id="claim_finance">
<table width='100%' cellpadding='0' cellspacing='0' class="gray">
    <tr>
        <td class='option'>Доход (без НДС)</td>
        <td class='value'><?php echo get_component('ajax','ajaxField', 
                                   array(
                                       'default'=>$claim->getFinanceClaim()->getIncomeNonnds(),
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
                                       'default'=>$claim->getFinanceClaim()->getCostsN(),
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
                                       'default'=>$claim->getFinanceClaim()->getIncomeNds(),
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
                                       'default'=>$claim->getFinanceClaim()->getCostsNonnds(),
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
                                       'default'=>$claim->getFinanceClaim()->getCostsNds(),
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
        <td class='value'><?php echo get_component('ajax','boolButton', 
                                   array(
                                       'default'=>$claim->getFinanceClaim()->getIsClosed(),  
                                       'field' => 'smeta_file',
                                       'claim_id' => $claim->getId(), 
                                       'url_change'=>url_for('ajax/changeBool'),
                                       'url_response'=>url_for('ajax/getBoolStatus'),
                                       )) 
                            ?></td>
        <td class='option'></td>
        <td class='value'>
        </td>
    </tr>
    
    
</table>
   </div>
   
</div>






<?php /*echo get_component('dialog','dialogfromsave', 
       array(
           'text'=>'Пригласить пользователя',
           'url_open'=>url_for('users/joinuserform').'/claim_id/'.$claim->getId(),
           'refresh_div' => '',
           'url_refresh' => ''
           ))*/
?>

   <div class="delimiter"></div>    
 <?php foreach ($commentss as $comments): ?>
     <div class="groupbox grayblack"><?php echo $comments->getUsers() ?> - <?php echo $comments->getCreatedatetimeGood();?> <?php if ($comments->isvisible) echo __('Только для персонала'); ?></div>
     <div class="groupbox normal"><?php echo html_entity_decode($comments->getDescription()) ?></div>
     <div class="groupbox normal"><?php include_partial('attach/attachView', array('comments'=>$comments))?></div>
     <?php endforeach; ?>
   <div class="delimiter"></div>  

<div id="tabs">
   <ul>
      <li><a href="#fragment-1"><span><?php echo __('Message') ?></span></a></li>
     
   </ul>
   <div id="fragment-1">
   <?php 
      if (!$claim->getIsclosedClient())
      {
          include_partial('form', array('form' => $form, 'claimid'=>$claim->getId())); 
      }
    ?>
   </div>
   
</div>
<div id="<?php echo $claim->getId()?>" class="claim_id"></div>
<div id="result"></div>
    




