<table width='100%' cellpadding='0' cellspacing='0' class="gray">
    <tr>
        <td class='option' width='20%'><?php echo __('Claim №')?></td>
        <td class='value' width='30%'><?php echo $claim->getId()?></td>
        <td class='option' width='20%'><?php echo __('Kurator')?></td>
        <td class='value' width='30%'>
          <div class="kurator_list"><?php echo $claim->getKurator();?></div>
          <?php 
          echo get_component('Fmodel','form_add',
          array(
          'model' => 'claimusers',
          'model_id' => null,
          'form_class' => 'claimusersAddUser',
          'target'=>'addkurator'.$claim->getId(),
          'button_text' => __('Add kurator'),
          'with_dialog' => true,
          'default' => 
           array(
              'claim_id'=>$claim->getId(),
              'userkey'=>sfConfig::get('claimuserkey_kurator'),
           ),
           'ref_functions'=>
           array(
               '.kurator_list'=>url_for('users/get_kurator').'/claim_id/'.$claim->getId(),
           )
         
       )
       )?>
           
        </td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Claimtype')?></td>
        <td class='value'>
           <?php echo get_component('Fmodel','ajax_field',
            array(
              'id'=> $claim->getId(),
              'model' => 'claim',
              'field' => 'claimtype_id',
              'toString' =>'getClaimtype',
              'default' => $claim->getClaimtype(),
              )
           )?>
        </td>
        <td class='option'><?php echo __('Stuff')?></td>
        <td class='value'>
          <div class="stuff_list"><?php echo $claim->getStuff();?></div>
          <?php 
          echo get_component('Fmodel','form_add',
          array(
          'model' => 'claimusers',
          'model_id' => null,
          'form_class' => 'claimusersAddUser',
          'target'=>'addstuff'.$claim->getId(),
          'button_text' => __('Add stuff'),
          'with_dialog' => true,
          'default' => 
           array(
              'claim_id'=>$claim->getId(),
              'userkey'=>sfConfig::get('claimuserkey_stuff'),
           ),
           'ref_functions'=>
           array(
               '.stuff_list'=>url_for('users/get_stuff').'/claim_id/'.$claim->getId(),
           )
         
       )
       )?>
        </td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Createdatetime')?></td>
        <td class='value'><?php  echo $claim->getCreatedatetimeGood()?></td>
        <td class='option'><?php echo __('Importance')?></td>
        <td class='value'>
        <?php echo get_component('Fmodel','ajax_field',
            array(
              'id'=> $claim->getId(),
              'model' => 'claim',
              'field' => 'organization_importance_id',
              'toString' =>'getImportance',
              'default' => $claim->getImportance(),
              )
           )?>
        </td>
    </tr>
    <tr>
        <td class='option'><?php echo __('Closedatetime')?></td>
        <td class='value'>&nbsp;<?php  echo $claim->getClosedatetimeGood()?></td>
        <td class='option'><?php echo __('Status')?></td>
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
        <td class='value'><div id="showTotalIncomeString<?php echo $claim->getId();?>" ><?php echo $claim->showTotalIncomeString()?></div></td>
         <td class='option'><?php echo __('Smeta status')?></td>
        <td class='value'>
       <?php echo get_component('Fmodel','ajax_field',
       array(
          'id'=> $claim->getId(),
          'model' => 'claim',
          'field' => 'smeta_status_id',
          'toString' =>'getSmetaStatus',
          'default' => $claim->getSmetaStatus(),
       )
       )?>
        </td>
       

    </tr>
    <tr>
        <td class='option'><?php echo __('Our costs')?></td>
        <td class='value'><div id="showTotalCostsString<?php echo $claim->getId();?>" ><?php echo $claim->showTotalCostsString()?></div></td>
        <td class='option'><?php echo __('History')?></td>
        <td class='value'><?php echo get_component('dialog','dialogopen', array('url'=>url_for('history/show').'/claimid/'.$claim->getId(),'text'=>__('Show history')))?></td>
    </tr>
    <tr>
    <td class='option'><?php echo __('Work list')?></td>
        <td class='value'><?php echo htmlspecialchars_decode($claim->getWorkList());?></td>
        <td class='option'><?php echo __('MPK')?></td>
        <td class='value'>
        <?php echo get_component('Fmodel','ajax_field',
          array(
            'id'=> $claim->getId(),
            'model' => 'claim',
            'field' => 'mpk',
            'toString' =>'getMpk',
            'default' => $claim->getMpk(),
           )
         )?>
        </td>
    </tr>
    <tr>
      <td class='option'><?php echo __('Маштаб')?></td>
      <td class='value'>
        <?php echo get_component('Fmodel','ajax_field',
          array(
            'id'=> $claim->getId(),
            'model' => 'claim',
            'field' => 'organization_type_id',
            'toString' =>'getOrganizationType',
            'default' => $claim->getOrganizationType(),
           )
         )?>
      </td>
      <td class='value'></td>
      <td class='option'></td>
    </tr>
</table>