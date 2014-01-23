<a href="<?php echo url_for('managers_activity')?>">
  <?php echo __('New request')?>
</a>
<br />

<table class="gray">
  <tr>
    <td></td>
    <?php foreach ($types as $type) : ?>
      <td><?php echo $type?></td>
    <?php endforeach;?>
  </tr>
<?php foreach ($results as $result):?>
  <tr>
    <td><?php echo $result['user']?></td>
    <?php foreach ($types as $type) : ?>
      <td><?php echo isset($result[$type->getId()]) ? $result[$type->getId()] : ''?></td>
    <?php endforeach; ?>
  </tr>
<?php endforeach; ?>
</table>