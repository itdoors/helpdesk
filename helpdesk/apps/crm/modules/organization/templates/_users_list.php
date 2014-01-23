<?php if (sizeof($organizationUsers)) : ?>
  <table id="example" class="gray">
    <tr>
      <td><?php echo __('FIO')?></td>
      <td><?php echo __('Email')?></td>
      <td><?php echo __('Phone')?></td>
      <td><?php echo __('Birthday')?></td>
      <td><?php echo __('Actions')?></td>
    </tr>
    <tbody>
    <?php foreach($organizationUsers as $organizationUsers):?>
      <?php $user = $organizationUsers->getUser();?>
      <tr>
        <td><?php echo $user->getFirstName()?> <?php echo $user->getLastName()?></td>
        <td><?php echo $user->getEmailAddress()?></td>
        <td><?php echo $user->getStuff() ? $user->getStuff()->getMobilephone() : ''?></td>
        <td><?php echo format_date($user->getBirthday(), 'dd.MM.yyyy', 'ru')?></td>
        <td>
          <?php
          if (1)
            include_component('Fmodel', 'delete_record_advanced',
              array(
                'model'   => 'OrganizationUser',
                'parents_tag'   => 'td',
                'where'      => array(
                  'organization_id' => $organizationUsers->getOrganizationId(),
                  'user_id' => $organizationUsers->getUserId(),
                ),
                //'ref_functions_names' => array('updateGrafik')
              ))?>
        </td>
      </tr>
    <?php endforeach;?>
    </tbody>
  </table>
<?php endif;?>