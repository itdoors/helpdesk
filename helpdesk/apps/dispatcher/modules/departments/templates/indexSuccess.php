<h1>Departmentss List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Mpk</th>
      <th>Name</th>
      <th>Fullname</th>
      <th>City</th>
      <th>Address</th>
      <th>Contract</th>
      <th>Square</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($departmentss as $departments): ?>
    <tr>
      <td><a href="<?php echo url_for('departments/edit?id='.$departments->getId()) ?>"><?php echo $departments->getId() ?></a></td>
      <td><?php echo $departments->getMpk() ?></td>
      <td><?php echo $departments->getName() ?></td>
      <td><?php echo $departments->getFullname() ?></td>
      <td><?php echo $departments->getCityId() ?></td>
      <td><?php echo $departments->getAddress() ?></td>
      <td><?php echo $departments->getContractId() ?></td>
      <td><?php echo $departments->getSquare() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('departments/new') ?>">New</a>
