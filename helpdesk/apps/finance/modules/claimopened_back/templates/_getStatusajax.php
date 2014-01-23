<?php use_helper('Date') ?>
<?php echo $claim->getStatusLastDate()?><br />
<?php echo $claim->getStatus()?>
<a href="<?php echo url_for('claimopened/editstatusajax').'/id/'.$claim->id; ?>" id="dispatcher_change_status_button" class="sf_admin_action_edit"><?php echo __('Change')?></a>
