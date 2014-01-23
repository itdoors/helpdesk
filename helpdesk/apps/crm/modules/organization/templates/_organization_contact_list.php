<?php if (sizeof($contacts)) : ?>
<table id="example" class="gray">
<tr>
  <td><?php echo __('FIO')?></td>
  <td><?php echo __('Phone')?></td>
  <td><?php echo __('Phone2')?></td>
  <td><?php echo __('Position')?></td>
  <td><?php echo __('Email')?></td>
  <td><?php echo __('Birthday')?></td>
  <?php if ($withDelete):?>
    <td><?php echo __('Actions')?></td>
  <?php endif;?>
</tr>
<tbody>
<?php foreach($contacts as $contact):?>
<tr>
  <td><?php echo $contact->getLastName()?> <?php echo $contact->getFirstName()?> <?php echo $contact->getMiddleName()?></td>
  <td><?php echo $contact->getPhone1()?></td>
  <td><?php echo $contact->getPhone2()?></td>
  <td><?php echo $contact->getPosition()?></td>
  <td><?php echo $contact->getEmail()?></td>
  <td><?php echo format_date($contact->getBirthday(), 'dd.MM.yyyy', 'ru')?></td>
  <?php if ($withDelete):?>
    <td>
      <?php
      if ($sf_user->hasCredential('crmadmin') && $withDelete)
      include_component('Fmodel', 'delete_record',
        array(
          'model'   => 'ModelContact',
          'id'      => $contact->getId(),
          'ref_functions'=>
             array(
               '#organization_contacts'=>url_for('organization/refresh_contacts').'/organization_id/'.$contact->getModelId()
             )
        ))?>
    </td>
  <?php endif;?>
</tr>
<?php endforeach;?>
</tbody>
</table>
<?php endif;?>
