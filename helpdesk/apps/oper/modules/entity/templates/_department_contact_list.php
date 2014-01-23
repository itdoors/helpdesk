<?php if (sizeof($contacts)) : ?>
<table id="example">
<tr>
  <td><?php echo __('FIO')?></td>
  <td><?php echo __('Phone')?></td>
  <td><?php echo __('Position')?></td>
  <td><?php echo __('Birthday')?></td>
  <td><?php echo __('Actions')?></td>
</tr>
<tbody>
<?php foreach($contacts as $contact):?>
<tr>
  <td><?php echo $contact->getFirstName()?> <?php echo $contact->getLastName()?></td>
  <td><?php echo $contact->getPhone1()?></td>
  <td><?php echo $contact->getPosition()?></td>
  <td><?php echo $contact->getBirthday()?></td>
  <td>
    <?php 
    if ($can_edit) 
    include_component('Fmodel', 'delete_record',
      array(
        'model'   => 'ModelContact',
        'id'      => $contact->getId(),
        'ref_functions'=>
           array(
             '#department_contacts'=>url_for('entity/refresh_contacts').'/department_id/'.$contact->getModelId()
           )
      ))?>
   </td>
</tr>
<?php endforeach;?>
</tbody>
</table>
<?php endif;?>
