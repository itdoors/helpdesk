<table>
  <tbody>
    <?php foreach ($commentss as $comments): ?>
    <tr>
      <td><a href="<?php echo url_for('messages/edit?id='.$comments->getId()) ?>"><?php echo $comments->getId() ?></a></td>
      <td><?php echo $comments->getClaim() ?></td>
      <td><?php echo $comments->getUserId() ?></td>
      <td><?php echo $comments->getDescription() ?></td>
      <td><?php echo $comments->getCreatedatetime() ?></td>
      <td><?php echo $comments->getIsvisible() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('messages/new') ?>">New</a>
