<h1>Doc document group sf userss List</h1>

<table cellpadding="5" cellspacing="5" width="500">
  <thead>
    <tr>
      <th>Sf guard user</th>
      <th>Doc document group</th>
      <th>Actionkey</th>
    </tr>
    <?php foreach ($doc_document_group_sf_userss as $record):?>
    <tr>
      <td><?php echo $record->getSfUsers()?></td>
      <td><?php echo $record->getDocGroups()?></td>
      <td><?php echo $record->getActionkey()?></td>
    </tr>
    <?php endforeach;?>
  </thead>
  <tbody>

  </tbody>
</table>

  <a href="<?php echo url_for('groupuser/new') ?>">New</a>
