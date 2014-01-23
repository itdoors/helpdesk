<?php $color = $finance_claim->getProfitability()>0?$color="color:#04712f":$color="color:#ff0000";?>
<div style="<?php echo $color?>; font-weight: bold;">
<?php echo round($finance_claim->getProfitability(),2);?>/<?php echo $finance_claim->getProfitabilityPersent()?$finance_claim->getProfitabilityPersent()."%":'Недостаточно';?>
</div>