<h1>Lookups List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Lukey</th>
      <th>Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($lookups as $lookup): ?>
    <tr>
      <td><a href="<?php echo url_for('lookup_custom/edit?id='.$lookup->getId()) ?>"><?php echo $lookup->getId() ?></a></td>
      <td><?php echo $lookup->getLukey() ?></td>
      <td><?php echo $lookup->getName() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('lookup_custom/new') ?>">New</a>
