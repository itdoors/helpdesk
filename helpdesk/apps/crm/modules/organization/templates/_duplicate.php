<?php if (sizeof($organizations)) : ?>
  <?php echo __('Organization that already exists')?>
  <table class="gray duplicate">
    <tr>
      <td><?php echo __('Id')?></td>
      <td><?php echo __('Name')?></td>
      <td><?php echo __('Short description')?></td>
      <td><?php echo __('Managers')?></td>
    </tr>
  <?php foreach($organizations as $organization): ?>
    <tr>
      <td>
        <a href="<?php echo url_for('organization_show', array('organization_id' => $organization->getId()))?>" target="_blank">
          <?php echo $organization->getId()?>
        </a>
      </td>
      <td>
        <a href="<?php echo url_for('organization_show', array('organization_id' => $organization->getId()))?>" target="_blank">
          <?php echo $organization->getName()?>
        </a>
      </td>
      <td><?php echo $organization->getShortDescription()?></td>
      <td>
        <?php foreach ($organization->getOrganizationUser() as $organizationUser) : ?>
        <?php
          $manager = $organizationUser->getUser();
          $email = $manager->getEmailAddress();
          $phone = $manager->getStuff() ? $manager->getStuff()->getMobilephone() : '';
          $info = $email . ' | ' . $phone?>
        <a href="javascript:;" title="<?php echo $info?>" class="tooltip">
          <?php echo $manager->getLastName()?> <?php echo $manager->getFirstName()?>
        </a>,
        <?php endforeach;?>
      </td>
    </tr>
  <?php endforeach;?>
  </table>
<?php endif;?>