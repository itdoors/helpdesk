<div id="dpmitabs">
  <ul>
    <li><a href="#dpmi1"><span><?php echo __('Department people') ?></span></a></li>
    <li><a href="#dpmi2"><span><?php echo __('Planned accrual') ?></span></a></li>
    <li><a href="#dpmi3"><span><?php echo __('Work information') ?></span></a></li>
  </ul>
  <div id="dpmi1">
    <?php include_partial('entity/peopleMonthInfoForm', array('peopleMonthInfoForm' => $peopleMonthInfoForm))?>
  </div>
  <div id="dpmi2">
    <?php if ($peopleMonthInfoForm->isNew()): ?>
      <?php echo __('Choose staff'); ?>
    <?php else : ?>
      <?php include_component('entity', 'plannedAccrual', array(
        'departmentPeopleMonthInfo' => $peopleMonthInfoForm->getObject()
      )) ?>
    <?php endif; ?>
  </div>
  <div id="dpmi3">
    <?php if ($peopleMonthInfoForm->isNew()): ?>
      <?php echo __('Choose staff'); ?>
    <?php else : ?>
      <?php include_component('entity', 'workInformation', array(
        'departmentPeopleMonthInfo' => $peopleMonthInfoForm->getObject()
      )) ?>
    <?php endif; ?>
  </div>
</div>

<script type="text/javascript">

  $('#dpmitabs').tabs();

  /*$('#dpmitabs li a').bind('click', function (e){
    e.preventDefault();
    window.location.hash = $(this).attr('href');
  });*/

</script>