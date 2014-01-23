<table>
  <thead>
    <tr>

      <th><?php echo __('Fc costsn types')?>|</th>
      <th>&nbsp;&nbsp;</th>
      <th><?php echo __('Value')?>|</th>
      <th>&nbsp;&nbsp;</th>
      <th><?php echo __('Action')?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($fc_costsns as $fc_costsn): ?>
    <tr>
      <td><?php echo $fc_costsn->getFcCostsntypes() ?></td>
      <td width="5">&nbsp;</td>
      <td><?php echo get_component('Fmodel','ajax_field',
       array(
          'id'=> $fc_costsn->getId(),
          'model' => 'FcCostsn',
          'field' => 'value',
          'toString' =>'getValue',
          'default' =>  $fc_costsn->getValue(),
          'ref_functions'=>
           array(
               '#local_total_costsn_'.$finance_claim_id=>url_for('F_finance_claim/refresh_costsn').'/finance_claim_id/'.$finance_claim_id,
               
              
           )
       )
       )?></td>
       <td width="5">&nbsp;</td>
       <td>
       <?php if (!$fc_costsn->isNew()): ?>
            <form action="<?php echo url_for('FcCostsn/delete')?>" method="post" class="delete_costs">
            <input type="hidden" name="id" value="<?php echo $fc_costsn->getId()?>">
            <input type="submit" value="<?php echo __('Delete')?>">
            </form>
            
          <?php endif; ?>
       </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
  <?php if (count($fc_costsns)):?>
  <tfoot> 
    <tr>
      <td colspan="5" style="font-weight: bold;">Всего :<div id="local_total_costsn_<?php echo $finance_claim_id?>"><?php echo finance_claim::getTotalCostsnStatic($finance_claim_id)?></div></td>
    </tr>
  </tfoot>
  <?php endif;?>
  

</table>
<script>
   $('.delete_costs').die('submit');
   $('.delete_costs').live('submit', function (){
      confirm("<?php echo __('Are you sure')?>");
      var target = $('.fc_costsn_list');
      target.addClass('loading');
      $(this).ajaxSubmit({
      success: function (responseText, statusText)
            {
               target.load('<?php echo url_for('FcCostsn/refresh_costsn_list').'/finance_claim_id/'.$finance_claim_id?>', function() {
                  target.removeClass('loading');
               }); 
            }, 
      beforeSubmit: function ()
            {
                
            }
      });
       return false;
   })
</script>