<div id="dopdogovor_list">
  <?php echo get_component('dogovor', 'dopdogovors', array('dogovor_id' => $dogovor->getId()))?>      
</div>
<?php $hasPermission = $sf_user->hasCredential('dogovoradmin');?>  
<?php if ($hasPermission):?>
       <?php
        echo get_component('Fmodel','form_add',
               array(
                  'model' => 'DopDogovor',
                  //'form_class' => 'finance_claimNew',
                  'target'=>'adddopdogovor'.$dogovor->getId(),
                  'button_text' => __('Add dop dogovor'),
                  'default' => 
                   array(
                      'dogovor_id'=>$dogovor->getId(),
                   ),
                   'ref_functions'=>
                   array(
                     '#dopdogovor_list'=>url_for('dogovor/dopdogovors').'/dogovor_id/'.$dogovor->getId(),
                   )
               )
               )
        ?>
<?php endif;?>


