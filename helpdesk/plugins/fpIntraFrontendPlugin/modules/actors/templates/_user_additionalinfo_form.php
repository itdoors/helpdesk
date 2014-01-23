<?php if (count($additionalinfos)): ?>
<table>
<?php endif;?> 
<?php  foreach($additionalinfos as $additionalinfo):?>
<tr>
  <td><?php echo $additionalinfo->getContactinfo()->getName()?> : </td>   
  <td>
   <?php
      echo get_component('Fmodel','ajax_field',
       array(
          'id'=> $additionalinfo->getId(),
          'model' => 'UserContactinfo',
          'field' => 'value',
          'toString' =>'getValue',
          'default' => $additionalinfo->getValue(),
          'with_delete'=>true,
          'ref_functions'=>
           array(
               '#user_additionalinfo_form'=>url_for('actors/refresh_additionalimfo')
           )
          )
       )?>
    </td>   
</tr>
<?php endforeach;?>
<?php if (count($additionalinfos)): ?>
</table>
<?php endif;?>