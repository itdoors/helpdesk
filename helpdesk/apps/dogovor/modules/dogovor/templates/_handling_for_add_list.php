<?php if (sizeof($handlings)):?>
<?php echo __('Handling for add list')?>
  <table class="gray">
    <tr>
      <td><?php echo __('Id')?></td>
      <td><?php echo __('Createdatetime')?></td>
      <td><?php echo __('Service offered')?></td>
      <td><?php echo __('Status')?></td>
      <td><?php echo __('Result')?></td>
      <td><?php echo __('Managers')?></td>
      <td><?php echo __('Action')?></td>
    </tr>
    <?php foreach ($handlings as $handling):?>
      <tr>
        <td><?php echo $handling->getId()?></td>
        <td><?php echo format_date($handling->getCreatedatetime(), 'dd.MM.yyyy', 'ru');?></td>
        <td><?php echo $handling->getServiceOffered()?></td>
        <td><?php echo $handling->getStatusWithDate()?></td>
        <td><?php echo $handling->getResultName()?></td>
        <td><?php foreach ($handling->getHandlingUser() as $handlingUser) : ?>
            <?php echo $handlingUser->getUser()->getLastName()?> <?php echo $handlingUser->getUser()->getFirstName()?>,
          <?php endforeach;?>
        </td>
        <td>
          <a href="<?php echo url_for('add_handling',
            array(
              'handling_id' => $handling->getId(),
              'dogovor_id' => $dogovorId,
              'organization_id' => $organizationId
            ))?>" class="add_handling">
            <?php echo __('Add handling')?>
          </a>
        </td>
      </tr>
    <?php endforeach;?>
  </table>
<?php endif;?>