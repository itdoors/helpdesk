<table width='100%' cellpadding='0' cellspacing='0' class="gray">
    <tr>
        <td class='option' width='20%'><?php echo __('Claim №')?></td>
        <td class='value' width='30%'><?php echo $claim->getId()?></td>
        <td class='option' width='20%'><?php echo __('Kurator')?></td>
        <td class='value' width='30%'><?php echo $claim->getKurator()?></td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Claimtype')?></td>
        <td class='value'>&nbsp;<?php echo $claim->getClaimtype()?></td>
        <td class='option'><?php echo __('Stuff')?></td>
        <td class='value'>&nbsp;<?php echo $claim->getStuff()?></td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Createdatetime')?></td>
        <td class='value'><?php  echo $claim->getCreatedatetimeGood()?></td>
        <td class='option'><?php echo __('Importance')?></td>
        <td class='value'><?php echo $claim->getImportance()?></td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Closedatetime')?></td>
        <td class='value'>&nbsp;<?php  echo $claim->getClosedatetimeGood()?></td>
        <td class='option'>Статус</td>
        <td class='value'>
        <?php echo $claim->getStatusLastDate()?><br />
        <?php echo get_component('Fmodel','ajax_field',
            array(
              'id'=> $claim->getId(),
              'model' => 'claim',
              'field' => 'status_id',
              'toString' =>'getStatus',
              'default' => $claim->getStatus(),
              )
           )?>
           
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
        <td class='option'><?php echo __('History')?></td>
        <td class='value'>
        <?php echo get_component('dialog','dialogopen', array('url'=>url_for('history/show').'/claimid/'.$claim->getId(),'text'=>__('Show history')))?>
        </td>
    </tr>
</table>