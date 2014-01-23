<?php use_helper('Text', 'Date') ?>
<div class="groupbox"><?php echo $claim->getOrganization()?> - <?php echo $claim->getDepartments()?>
<?php if (!$claim->getIsclosedclient()):?>
<div style="float: right;">
    <a onclick="if (!confirm('Вы уверены что хотите закрыть заявку?')){return false}; " href="<?php echo url_for('claimopened/close').'/claimid/'.$claim->getId() ?>" class="close">Закрыть</a>      
</div>
<?php endif;?>
</div>
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
        <td class='value'><?php echo $claim->getStuff()?></td>
    </tr>
    <tr>
        <td class='option'>Создана</td>
        <td class='value'><?php  echo $claim->getCreatedatetimeGood()?></td>
        <td class='option'>Важность</td>
        <td class='value'><?php echo $claim->getImportance()?></td>
    </tr>
    <tr>
        <td class='option'>Закрыта</td>
        <td class='value'><?php  echo $claim->getClosedatetimeGood()?></td>
        <td class='option'>Статус</td>
        <td class='value'><?php echo $claim->getStatus()?></td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Your Price with VAT')?></td>
        <td class='value'>&nbsp;<?php  echo $claim->getDescription()?></td>
        <td class='option'><?php echo __('Work list')?></td>
        <td class='value'>&nbsp;<?php echo htmlspecialchars_decode(str_replace(' &lt;br /&gt;',' ', $claim->getWorkList()))?></td>
    </tr>
</table>
   <div class="delimiter"></div>    
 <?php foreach ($commentss as $comments): ?>
     <div class="groupbox grayblack"><?php echo $comments->getUsers() ?> - <?php echo $comments->getCreatedatetimeGood() ?></div>
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
