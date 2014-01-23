<?php if (sizeof($contacts)) :?>
<table id="example">
  <tr>
    <td><?php echo __('Id')?></td>
    <td><?php echo __('Organization')?></td>
    <td><?php echo __('Companystructure')?></td>
    <td><?php echo __('City')?></td>
    <td><?php echo __('Region')?></td>
    <td><?php echo __('Department')?></td>
    <td><?php echo __('Status')?></td>
    <td><?php echo __('FIO')?></td>
    <td><?php echo __('Phone1')?></td>
    <td><?php echo __('Mob')?></td>
    <td><?php echo __('Position')?></td>
    <td><?php echo __('Email')?></td>
    <td><?php echo __('Birthday')?></td>
  </tr>
<tbody>
<?php foreach($contacts as $contact):?>
  <tr>
    <td><?php echo $contact['id']?></td>
    <td><?php echo $contact['organization']?></td>
    <td><?php echo $contact['companystructure']?></td>
    <td><?php echo $contact['city']?></td>
    <td><?php echo $contact['region']?></td>
    <td><?php echo $contact['department']?></td>
    <td><?php echo $contact['status']?></td>
    <td><?php echo $contact['first_name']?> <?php echo $contact['last_name']?></td>
    <td><?php echo $contact['phone1']?></td>
    <td><?php echo $contact['phone2']?></td>
    <td><?php echo $contact['position']?></td>
    <td><?php echo $contact['email']?></td>
    <td><?php echo $contact['birthday']?></td>
  </tr>
<?php endforeach;?>
</tbody>
<?php endif;?>
</table>