<div class="groupbox"><?php echo __('Unread messages')?></div>
<?php foreach ($messages as $message) : ?>
  Заявка <?php echo $message['claim_id']?> - <?php echo $users[$message['user_id']]?> - <?php echo $message['createdatetime']?><br />
<?php endforeach;?>
