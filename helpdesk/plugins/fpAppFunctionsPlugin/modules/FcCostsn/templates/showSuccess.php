<h1>Fc costsns List</h1>

<div class="fc_costsn_list">
  <?php echo get_component('FcCostsn', 'fc_costsn_list', array('fc_costsns'=>$fc_costsns))?>
</div>

<?php echo get_component('Fmodel','form_add',
       array(
          'model' => 'FcCostsn',
          'target'=>'addfc_costsn72',
          'ref_functions'=>
            array(
               '.fc_costsn_list'=>url_for('FcCostsn/refresh_costsn_list'),
               
           )
       )
     )?>
