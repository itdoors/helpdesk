<div class="groupbox">
  <?php echo $handling->getOrganization()?> - <?php echo $handling->getTypeName()?>
</div>
<div id="claimtabs">
  <ul>
    <li><a href="#tab1"><span class="tab123"><?php echo __('General') ?></span></a></li>
    <li><a href="#tab2"><span class="tab123"><?php echo __('Managers') ?></span></a></li>
    <li><a href="#tab3"><span class="tab123"><?php echo __('Client contacts') ?></span></a></li>
  </ul>
  <div id="tab1" data_index="1">
    <?php include_component('handling', 'general', array('handling' => $handling))?>
  </div>
  <div id="tab2" data_index="2">
    <?php include_component('handling', 'managers', array('handling' => $handling))?>
  </div>
  <div id="tab3" data_index="3">
    <?php include_component('handling', 'client_contacts', array('handling' => $handling))?>
  </div>
</div>

<?php include_component('handling', 'messages', array('handling' => $handling))?>

<script type="text/javascript">

  $('#claimtabs').tabs();

  $('#claimtabs li a').bind('click', function (e){
    e.preventDefault();
    window.location.hash = $(this).attr('href');
  });

</script>