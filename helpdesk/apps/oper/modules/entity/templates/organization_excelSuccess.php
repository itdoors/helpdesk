<?php use_helper('Text', 'Date') ?>
<?php $positionList = DepartmentPeoplePosition::getList()?>

  <table cellspacing="0" width="100%" class="gray" id="example">
    <thead>
    <tr>
    <th></th>
    <th><?php echo __('Id')?></th>
    <th>
      <?php echo __('Name')?>
    </th>
    <th>
      <?php echo  __('City')?>
    </th>
    <th>
      <?php echo __('Region')?>
    </th>
    <th>
      <?php echo __('Address')?>
    </th>
    <th><?php echo __('Dogovor #')?></th>
    <th><?php echo __('Dogovor date start')?></th>
    <th><?php echo __('Dogovor date end')?></th>
    <th><?php echo __('Dogovor service')?></th>
    <th><?php echo __('Contact fio')?></th>
    <th><?php echo __('Contact position')?></th>
    <th><?php echo __('Contact phone')?></th>
    <th><?php echo __('Contact email')?></th>
    <th><?php echo __('Contact birthday')?></th>
    <th><?php echo __('Manager fio')?></th>
    <th><?php echo __('Manager phone')?></th>
    <th><?php echo __('Stuff fio')?></th>
    <th><?php echo __('Stuff phone')?></th>
    <th><?php echo __('Stuff position')?></th>
    <th><?php echo __('Stuff birthday')?></th>
    </thead>
    <tbody>
    <?php $i = 0; foreach ($organizations as $organization) : ?>
      <tr>
        <td><?php echo ++$i?></td>
        <td>
            <?php echo $organization['id']?>
        </td>
        <td>
          <?php echo $organization['name']?>
        </td>
        <td>
          <?php echo $organization['city']?>
        </td>
        <td>
          <?php echo $organization['region']?>
        </td>
        <td><?php echo $organization['address']?></td>
        <td><?php echo $organization['dogovor_number']?></td>
        <td><?php echo format_date($organization['dogovor_startdatetime'], 'dd.MM.yyyy', 'ru');?></td>
        <td><?php echo format_date($organization['dogovor_stopdatetime'], 'dd.MM.yyyy', 'ru')?></td>
        <td><?php echo $organization['dogovor_subject']?></td>
        <td><?php echo $organization['contact_fio']?></td>
        <td><?php echo $organization['contact_position']?></td>
        <td><?php echo $organization['contact_phone']?></td>
        <td><?php echo $organization['contact_email']?></td>
        <td><?php echo format_date($organization['contact_birthday'], 'dd.MM.yyyy', 'ru')?></td>
        <td><?php echo $organization['manager_fio']?></td>
        <td><?php echo $organization['manager_phone']?></td>
        <td><?php echo $organization['stuff_fio']?></td>
        <td><?php echo $organization['stuff_phone']?></td>
        <td><?php echo isset($positionList[$organization['stuff_position']]) ? $positionList[$organization['stuff_position']] : ''?></td>
        <td><?php echo format_date($organization['stuff_birthday'], 'dd.MM.yyyy', 'ru')?></td>
      </tr>
    <?php endforeach;?>
    </tbody>
  </table>