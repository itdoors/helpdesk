<?php if (sizeof($types)) : ?>
<table class="gray">
  <?php foreach($types as $type):?>
    <tr>
      <td><?php echo $type->getName()?></td>
      <td><?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'handling_id' => $handlingId,
              'handling_more_info_type_id' => $type->getId()
            ),
            'model' => 'HandlingMoreInfo',
            'field' => 'value',
            'toString' => 'getValue',
            'default'  =>  isset($moreInfo[$type->getId()]) ? $moreInfo[$type->getId()]->getValue() : ''
          )
        );
        ?></td>
    </tr>
  <?php endforeach;?>
</table>
<?php else:?>
  <?php echo __('No addition information for this type of handling result')?>
<?php endif;?>