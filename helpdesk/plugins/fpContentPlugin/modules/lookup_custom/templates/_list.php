<?php if (sizeof($lookups)) : ?>
<table style="width: 200px" id="example" class="gray">
  <thead>
  <tr>
    <th><?php echo __('Id')?></th>
    <th><?php echo __('Name')?></th>
    <th><?php echo __('Actions')?></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($lookups as $lookup): ?>
    <tr>
      <td><?php echo $lookup->getId() ?></td>
      <td>
        <?php
        include_component('Fmodel', 'ajax_field_change',
          array(
            'where' => array(
              'id' => $lookup->getId(),
            ),
            'model' => 'lookup',
            'field' => 'name',
            'toString' => 'getName',
            'default'  =>  $lookup->getName()
          )
        );
        ?></td>
      <td>
        <?php
          include_component('Fmodel', 'delete_record',
            array(
              'model'   => 'lookup',
              'id'      => $lookup->getId(),
              'ref_functions'=>
              array(
                '#lookup_list'=>url_for('lookup_custom/refresh_list').'/lukey/'.$lookup->getLukey()
              )
            ))?>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php endif;?>