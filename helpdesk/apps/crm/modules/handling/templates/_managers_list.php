<?php if (sizeof($managers)) : ?>
  <table id="example" class="gray">
    <tr>
      <td><?php echo __('FIO')?></td>
      <td><?php echo __('Email')?></td>
      <td><?php echo __('Phone')?></td>
      <td><?php echo __('Part')?></td>
      <td><?php echo __('Action')?></td>
    </tr>
    <tbody>
    <?php foreach($managers as $manager):?>
      <?php $user = $manager->getUser();?>
      <tr>
        <td><?php echo $user->getFirstName()?> <?php echo $user->getLastName()?></td>
        <td><?php echo $user->getEmailAddress()?></td>
        <td><?php echo $user->getStuff() ? $user->getStuff()->getMobilephone() : ''?></td>
        <td><?php echo $manager->getPart()?></td>
        <td>
          <?php
          if ($sf_user->hasCredential('crmadmin'))
            include_component('Fmodel', 'delete_record',
              array(
                'model'   => 'HandlingUser',
                'id'      => $manager->getId(),
                'ref_functions'=>
                array(
                  '#handling_managers'=>url_for('handling/refresh_managers').'/handling_id/'.$manager->getHandlingId()
                )
              ))?>
        </td>
      </tr>
    <?php endforeach;?>
    </tbody>
  </table>
<?php endif;?>