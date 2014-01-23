<?php use_helper('I18N', 'Date') ?>
<?php include_partial('departmentsorganization/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Departmentsorganization List', array(), 'messages') ?></h1>

  <?php include_partial('departmentsorganization/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('departmentsorganization/list_header', array('pager' => $pager)) ?>
  </div>

  <div id="sf_admin_bar">
    <?php include_partial('departmentsorganization/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <form action="<?php echo url_for('departments_collection', array('action' => 'batch')) ?>" method="post">
      <ul class="sf_admin_actions" style="margin-right: 550px;">
        <?php include_partial('departmentsorganization/list_batch_actions', array('helper' => $helper)) ?>
        <?php include_partial('departmentsorganization/list_actions', array('helper' => $helper)) ?>
      </ul>

      <?php include_partial('departmentsorganization/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('departmentsorganization/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
