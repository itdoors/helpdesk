<table width='100%' cellpadding='0' cellspacing='0' class="gray">
    <tr>
        <td class='option' width='20%'><?php echo __('Claim №')?></td>
        <td class='value' width='30%'><?php echo $claim->getId()?></td>
        <td class='option' width='20%'><?php echo __('Kurator')?></td>
        <td class='value' width='30%'><?php echo $claim->getKurator()?></td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Claimtype')?></td>
        <td class='value'><?php echo $claim->getClaimtype()?></td>
        <td class='option'><?php echo __('Stuff')?></td>
        <td class='value'><?php echo $claim->getStuff()?></td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Createdatetime')?></td>
        <td class='value'><?php  echo $claim->getCreatedatetimeGood()?></td>
        <td class='option'><?php echo __('Importance')?></td>
        <td class='value'><?php echo $claim->getImportance()?></td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Closedatetime')?></td>
        <td class='value'><?php  echo $claim->getClosedatetimeGood()?></td>
        <td class='option'><?php echo __('Status')?></td>
        <td class='value'><?php echo $claim->getStatus()?></td>
    </tr>
      <tr>
        <td class='option'><?php echo __('Price with VAT')?></td>
        <td class='value'>&nbsp;<?php  echo $claim->getDescription()?></td>
        <td class='option'><?php echo __('Our costs')?></td>
        <td class='value'>&nbsp;<?php  echo $claim->getOurcosts()?></td>
    </tr>
    <tr>
        <td class='option'><?php echo __('MPK')?></td>
        <td class='value'>&nbsp;<?php  echo $claim->getMpk()?></td>
        <td class='option'></td>
        <td class='value'></td>
    </tr>
</table>