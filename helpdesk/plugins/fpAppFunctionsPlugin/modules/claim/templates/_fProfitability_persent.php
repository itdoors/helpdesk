<?php
   echo $claim->getFinanceClaim()?($claim->getFinanceClaim()->getIncomeNonnds()?round($claim->getFinanceClaim()->getProfitability()/$claim->getFinanceClaim()->getIncomeNonnds()*100):''):'';
?>
