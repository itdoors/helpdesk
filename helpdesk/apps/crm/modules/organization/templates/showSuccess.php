<div id="claimtabs">
  <ul>
    <li><a href="#tab1"><span class="tab123"><?php echo __('Contacts') ?></span></a></li>
    <?php if ($sf_user->hasCredential('crmadmin')) : ?>
      <li><a href="#tab2"><span><?php echo __('Managers') ?></span></a></li>
    <?php endif;?>
    <li><a href="#tab3"><span><?php echo __('Edit') ?></span></a></li>
  </ul>
  <div id="tab1" data_index="1">
    <?php include_component('organization', 'contacts', array('organization' => $organization))?>
  </div>
  <?php if ($sf_user->hasCredential('crmadmin')) : ?>
  <div id="tab2" data_index="2">
    <?php include_component('organization', 'users', array('organization' => $organization))?>
  </div>
  <?php endif;?>
  <div id="tab3" data_index="3">
    <?php include_component('organization', 'edit', array('organization' => $organization))?>
  </div>
</div>

<script type="text/javascript">
  
  $('#claimtabs').tabs();
  
  $('#claimtabs li a').bind('click', function (e){
    e.preventDefault();
    window.location.hash = $(this).attr('href');
  }); 
  
</script>

