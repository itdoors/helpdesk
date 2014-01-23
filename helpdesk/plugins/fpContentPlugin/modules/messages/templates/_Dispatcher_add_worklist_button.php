      <?php
        echo get_component('Fmodel','form_add',
               array(
                  'model' => 'finance_claim',
                  'form_class' => 'finance_claimNew',
                  'target'=>'addclaim'.$claim->getId(),
                  'button_text' => __('Add work'),
                  'default' => 
                   array(
                      'claim_id'=>$claim->getId(),
                      'nds' =>  Doctrine::getTable('lookup')->getNds(),
                      'obnal'=> Doctrine::getTable('lookup')->getObnal()
                   ),
                   'ref_functions'=>
                   array(
                       '#claim_worklist_refresh'=>url_for('messages/refresh_worklist').'/claim_id/'.$claim->getId().'/app/'.$app,
                       '.totalincome'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalIncomeNds',
                       '#showTotalIncomeString'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalIncomeNds',
                       '#showTotalCostsString'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalCostsNds',
                       '.totalprofitability'.$claim->getId()=>url_for('F_finance_claim/refresh_total_finance').'/id/'.$claim->getId().'/total_function/TotalProfitabilityResponse'
                   )
               
               )
               )
        ?>