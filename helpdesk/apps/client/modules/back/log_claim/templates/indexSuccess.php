<h1>Log claims List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Claim</th>
      <th>Action</th>
      <th>Createdatetime</th>
      <th>User</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($log_claims as $log_claim): ?>
    <tr>
      <td><a href="<?php echo url_for('log_claim/edit?id='.$log_claim->getId()) ?>"><?php echo $log_claim->getId() ?></a></td>
      <td><?php echo $log_claim->getClaim() ?></td>
      <td><?php echo $log_claim->getAction() ?></td>
      <td><?php echo $log_claim->getCreatedatetime() ?></td>
      <td><?php echo $log_claim->getUser() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('log_claim/new') ?>">New</a>
