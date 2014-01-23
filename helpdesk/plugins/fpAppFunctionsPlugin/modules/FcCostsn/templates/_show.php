<div class="fc_costsn_list">
  <?php echo get_component('FcCostsn', 'fc_costsn_list', array('fc_costsns'=>$fc_costsns,'finance_claim_id' => $finance_claim_id))?>
</div>

<?php echo get_component('Fmodel','form_add',
       array(
          'model' => 'FcCostsn',
          'target'=>'addfc_costsn'.$finance_claim_id,
          'button_text' => __('Add costs'),
          'default' => 
           array(
              'finance_claim_id'=>$finance_claim_id,
           ),
          'ref_functions'=>
           array(
               '.fc_costsn_list'=>url_for('FcCostsn/refresh_costsn_list').'/finance_claim_id/'.$finance_claim_id,
               
           )
       )
     )?>
