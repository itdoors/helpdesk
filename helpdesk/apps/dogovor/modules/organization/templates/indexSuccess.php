<?php use_helper('I18N', 'Date') ?>
<?php include_partial('organization/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Organization List', array(), 'messages') ?></h1>

  <?php include_partial('organization/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('organization/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('organization/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('organization_collection', array('action' => 'batch')) ?>" method="post">
    <ul class="sf_admin_actions" style="margin-right: 550px;">
      <?php include_partial('organization/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('organization/list_actions', array('helper' => $helper)) ?>
    </ul>
    
    <?php include_partial('organization/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('organization/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
