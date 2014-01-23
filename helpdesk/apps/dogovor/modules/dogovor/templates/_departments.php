<div id="departments_list">
  <?php echo get_component('dogovor', 'departments_list', array('dogovor_id' => $dogovor->getId()))?>      
</div>
<?php $hasPermission = $sf_user->hasCredential('dogovoradmin');?>  
<?php if ($hasPermission):?>
       <?php
        echo get_component('Fmodel','form_add',
               array(
                  'model' => 'DogovorDepartmentCollection',
                  //'form_class' => 'finance_claimNew',
                  'target'=>'adddogovordepartment'.$dogovor->getId(),
                  'button_text' => __('Add department'),
                  'default' => 
                   array(
                      'dogovor_id'=>$dogovor->getId(),
                      'organization_id'=>$dogovor->getOrganizationId(),
                   ),
                   'ref_functions'=>
                   array(
                     '#departments_list'=>url_for('dogovor/departments_list').'/dogovor_id/'.$dogovor->getId(),
                     '#dopdogovor_list'=>url_for('dogovor/dopdogovors').'/dogovor_id/'.$dogovor->getId(),
                   )
                 )
               )
        ?>
<?php endif;?>