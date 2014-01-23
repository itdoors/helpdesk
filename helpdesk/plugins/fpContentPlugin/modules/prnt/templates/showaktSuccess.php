<?php use_helper('Text', 'Date') ?>
<div id="PrintArea"> 
<div class="groupbox"><?php echo $claim->getOrganization()?> - <?php echo $claim->getDepartments()?></div>
<table width='100%' cellpadding='0' cellspacing='0' class="gray">
    <tr>
        <td class='option' width='20%'>Id тикета</td>
        <td class='value' width='30%'><?php echo $claim->id?></td>
        <td class='option' width='20%'>Куратор</td>
        <td class='value' width='30%'>&nbsp;<?php echo $claim->getKurator()?></td>
    </tr>
    <tr>
        <td class='option'>Отдел</td>
        <td class='value'><?php echo $claim->getClaimtype()?></td>
        <td class='option'>Исполнитель</td>
        <td class='value'>&nbsp;<?php echo $claim->getStuff()?></td>
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
        <td class='value'>&nbsp;<?php  echo $claim->getDescription()?></td>
        <td class='option'><?php echo __('Work list')?></td>
        <td class='value'>&nbsp;<?php  echo $claim->getStuffdescription()?></td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Our costs')?></td>
        <td class='value'>&nbsp;<?php  echo $claim->getOurcosts()?></td>
        <td class='option'>История</td>
        <td class='value'>&nbsp;</td>
    </tr>
</table>
<div id="<?php echo $claim->getId()?>" class="claim_id"></div>
</div>
<input type="button" id="print_button" value="<?php echo __('Print')?>" />
<script>
$("#print_button").click(function(){
    $("#PrintArea").jqprint({ operaSupport: true });
});
</script>
<style>
  .gray td{
      border:3px solid #000;
  }
</style>