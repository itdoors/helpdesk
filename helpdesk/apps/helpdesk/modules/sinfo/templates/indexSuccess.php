<h1>Stuffs List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Position</th>
      <th>Griffinstructure</th>
      <th>Mobilephone</th>
      <th>Description</th>
      <th>User</th>
      <th>Stuffclass</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($stuffs as $stuff): ?>
    <tr>
      <td><a href="<?php echo url_for('sinfo/edit?id='.$stuff->getId()) ?>"><?php echo $stuff->getId() ?></a></td>
      <td><?php echo $stuff->getPositionId() ?></td>
      <td><?php echo $stuff->getGriffinstructureId() ?></td>
      <td><?php echo $stuff->getMobilephone() ?></td>
      <td><?php echo $stuff->getDescription() ?></td>
      <td><?php echo $stuff->getUserId() ?></td>
      <td><?php echo $stuff->getStuffclass() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('sinfo/new') ?>">New</a>
