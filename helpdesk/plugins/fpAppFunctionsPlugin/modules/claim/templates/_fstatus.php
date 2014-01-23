<?php
  echo $claim->getFinanceClaim()?($claim->getFinanceClaim()->getIsClosed()?'Утверждено':'Неутверждено'):'Неутверждено';
?>
