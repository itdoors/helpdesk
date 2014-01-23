<?php use_helper('Text', 'Date') ?>
<div class="groupbox"><?php echo $claim->getOrganization()?> - <?php echo $claim->getDepartments()?></div>
<table width='100%' cellpadding='0' cellspacing='0' class="gray">
    <tr>
        <td class='option' width='20%'>Id тикета</td>
        <td class='value' width='30%'><?php echo $claim->id?></td>
        <td class='option' width='20%'>Куратор</td>
        <td class='value' width='30%'><div><?php echo $claim->getKurator()?><a href="<?php echo url_for('claimopened/editkuratorajax').'/id/'.$claim->id; ?>" id="dispatcher_change_kurator_button" class="sf_admin_action_edit"><?php echo __('Change')?></a></div></td>
    </tr>
    <tr>
        <td class='option'>Отдел</td>
        <td class='value'><div id="dispatcher_change_claimtype_value"><?php echo $claim->getClaimtype()?><a href="#" id="dispatcher_change_claimtype_button" class="sf_admin_action_edit"><?php echo __('Change')?></a></div></td>
        <td class='option'>Исполнитель</td>
        <td class='value'><?php echo $claim->getStuff()?></td>
    </tr>
    <tr>
        <td class='option'>Создана</td>
        <td class='value'><?php  echo $claim->getCreatedatetimeGood()?></td>
        <td class='option'>Важность</td>
        <td class='value'><?php echo $claim->getContractImportance()?></td>
    </tr>
    <tr>
        <td class='option'>Закрыта</td>
        <td class='value'><?php  echo $claim->getClosedatetimeGood()?></td>
        <td class='option'>Статус</td>
        <td class='value'><div id="loading"></div><div id="dispatcher_change_status_value"><?php echo $claim->getStatus()?><a href="<?php echo url_for('claimopened/editstatusajax').'/id/'.$claim->id; ?>" id="dispatcher_change_status_button" class="sf_admin_action_edit"><?php echo __('Change')?></a></div></td>
    </tr>
    <tr>
        <td class='option'>Закрыта</td>
        <td class='value'><?php  echo $claim->getDescription()?></td>
        <td class='option'>Статус</td>
        <td class='value'><div id="loading"></div><div id="dispatcher_change_status_value"><?php echo $claim->getStatus()?><a href="<?php echo url_for('claimopened/editstatusajax').'/id/'.$claim->id; ?>" id="dispatcher_change_status_button" class="sf_admin_action_edit"><?php echo __('Change')?></a></div></td>
    </tr>
</table>
   <div class="delimiter"></div>    
 <?php foreach ($commentss as $comments): ?>
     <div class="groupbox grayblack"><?php echo $comments->getUser() ?> - <?php echo $comments->getCreatedatetimeGood();?> <?php if ($comments->isvisible) echo __('Только для персонала'); ?></div>
     <div class="groupbox normal"><?php echo $comments->getDescription() ?></div>
     <?php endforeach; ?>
   <div class="delimiter"></div>  

<div id="tabs">
   <ul>
      <li><a href="#fragment-1"><span><?php echo __('Сообщение всем') ?></span></a></li>
      <li><a href="#fragment-2"><span><?php echo __('Сообщение сотрудникам') ?></span></a></li>
   </ul>
   <div id="fragment-1">
   <?php 
      if (!$claim->getIsclosedClient())
      {
          include_partial('form', array('form' => $form, 'claimid'=>$comments->getClaimId())); 
      }
    ?>
   </div>
   <div id="fragment-2">
       <?php 
          if (!$claim->getIsclosedClient())
          {
              include_partial('formstuff', array('form' => $form, 'claimid'=>$comments->getClaimId())); 
          }
        ?>
    </div>
</div>
<div id="result">result</div>
    




