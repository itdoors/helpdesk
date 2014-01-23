<li ><a href="<?php echo url_for('organization')?>"><?php echo __('Organization list') ?> </a></li>
<li ><a href="<?php echo url_for('organization_new')?>"><?php echo __('Create Organization') ?> </a></li>
<li ><a href="<?php echo url_for('handling')?>"><?php echo __('Handling List') ?> </a></li>
<li ><a href="<?php echo url_for('tender')?>"><?php echo __('Tenders List') ?> </a></li>
<?php if ($sf_user->hasCredential('crmadmin')) : ?>
<li ><a href="<?php echo url_for('scope')?>"><?php echo __('Scope List') ?> </a></li>
<?php endif;?>
<?php if ($sf_user->hasCredential('crmadmin')) : ?>
  <li ><a href="<?php echo url_for('managers_activity')?>"><?php echo __('Managers activity') ?> </a></li>
<?php endif;?>
<?php if ($sf_user->hasCredential('crmadmin')) : ?>
  <li ><a href="<?php echo url_for('soled_handlings')?>"><?php echo __('Soled handlings') ?></a></li>
<?php endif;?>
<?php if ($sf_user->hasCredential('crmadmin')) : ?>
  <li ><a href="<?php echo url_for('handling_more_info_table')?>"><?php echo __('Handling more info') ?></a></li>
<?php endif;?>
