<table cellspacing="0" width="100%" class="gray" id="example">
  <thead>
    <tr>
      <th>Id</th>
      <th><?php echo __('Createdatetime')?></th>
      <th><?php echo __('Dogovor')?></th>
      <th><?php echo __('Dop dogovor')?></th>
      <th><?php echo __('Creator')?></th>
      <th><?php echo __('Department')?></th>
      <th><?php echo __('Comment')?></th>
      <th><?php echo __('Actions')?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($departments_list as $object): ?>
    <tr>
      <td><?php echo $object->getId() ?></td>
      <td><?php echo format_date($object->getCreatedatetime(), 'dd.MM.yyyy', 'ru'); ?></td>
      <td><?php echo $object->getDogovor() ?></td>
      <td><?php echo $object->getDopDogovor() ?></td>
      <td><?php echo $object->getUser() ?></td>
      <td><?php echo $object->getDepartment() ?></td>
      <td><?php echo $object->getComment() ?></td>
      <td><?php include_component('Fmodel', 'delete_record',
        array(
          'model'   => 'DogovorDepartment',
          'id'      => $object->getId(),
          'ref_functions'=>
             array(
               '#dopdogovor_list'=>url_for('dogovor/dopdogovors').'/dogovor_id/'.$object->getDogovorId(),
             )
        ))?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>