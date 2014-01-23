<h1>Clients List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Mpk</th>
      <th>Phone</th>
      <th>Mobilephone</th>
      <th>User</th>
      <th>Position</th>
      <th>Organization</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($clients as $client): ?>
    <tr>
      <td><a href="<?php echo url_for('cinfo/edit?id='.$client->getId()) ?>"><?php echo $client->getId() ?></a></td>
      <td><?php echo $client->getMpk() ?></td>
      <td><?php echo $client->getPhone() ?></td>
      <td><?php echo $client->getMobilephone() ?></td>
      <td><?php echo $client->getUserId() ?></td>
      <td><?php echo $client->getPosition() ?></td>
      <td><?php echo $client->getOrganizationId() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('cinfo/new') ?>">New</a>
