<table  cellspacing="0" width="100%" class="gray">
  <tbody>
    <tr>
      <td>Title:</td>
      <td>
        <?php echo $global_message->getTitle() ?> <br />
        <?php echo $global_message->getCreatedatetimeGood() ?>
      </td>
    </tr>
    <tr>
      <td>User:</td>
      <td><?php echo $global_message->getUser() ?></td>
    </tr>
    <tr>
      <td>Description:</td>
      <td><?php echo html_entity_decode($global_message->getDescription()) ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('global_messages/edit?id='.$global_message->getId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('global_messages/index') ?>">List</a>
