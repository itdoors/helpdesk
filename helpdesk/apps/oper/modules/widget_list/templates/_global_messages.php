<div class="groupbox"><?php echo __('Global messages')?></div>

<a href="<?php echo url_for('global_messages/new')?>"><?php echo __('New')?></a>

<?php if (sizeof($global_messages)):?>
<table cellspacing="0" width="100%" class="gray">
<?php foreach ($global_messages as $message):?>
<tr>
  <td>
    <a href="<?php echo url_for('global_messages/show').'/id/'.$message->getId()?>">
      <?php echo $message->getTitle()?>
    </a>
  </td>
  <td><?php echo $message->getUser()?></td>
  <td><?php echo $message->getCreatedatetimeGood()?> </td>
</tr>
<?php endforeach;?>
</table>
<?php endif;?>
