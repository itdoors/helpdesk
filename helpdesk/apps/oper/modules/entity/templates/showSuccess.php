<?php

  // General
  $urlAjaxEntityGeneral = url_for('ajax_entity_general', array(
    'department_id' => $department->getId(),
    'can_edit' => $can_edit
  ));

  // Technical params
  $urlAjaxEntityTechnicalParams = url_for('ajax_entity_technical_params', array(
    'department_id' => $department->getId(),
    'can_edit' => $can_edit
  ));

  // Documents
  $urlAjaxEntityDocuments = url_for('ajax_entity_documents', array(
    'department_id' => $department->getId(),
    'can_edit' => $can_edit
  ));

  // Grafik
  $urlAjaxEntityGrafik = url_for('ajax_entity_grafik', array(
    'department_id' => $department->getId(),
    'can_edit' => $can_edit
  ));

  // People
  $urlAjaxEntityPeople = url_for('ajax_entity_people', array(
    'department_id' => $department->getId(),
    'can_edit' => $can_edit
  ));

  // Department People
  $urlAjaxEntityDepartmentPeople = url_for('ajax_entity_department_people', array(
    'department_id' => $department->getId(),
    'can_edit' => $can_edit
  ));
?>

<div id="entitytabs">
   <ul>
      <li><a href="<?php echo $urlAjaxEntityGeneral?>"><span class="tab123"><?php echo __('General') ?></span></a></li>
      <li><a href="<?php echo $urlAjaxEntityTechnicalParams?>"><span><?php echo __('Technical params') ?></span></a></li>
      <li><a href="<?php echo $urlAjaxEntityDocuments?>" ><span><?php echo __('Documents') ?></span></a></li>
      <li><a href="<?php echo $urlAjaxEntityGrafik?>"><span><?php echo __('Grafik') ?></span></a></li>
      <li><a href="#tab5"><span><?php echo __('Аудит') ?></span></a></li>
      <li><a href="#tab6"><span><?php echo __('Охрана Труда') ?></span></a></li>
      <li><a href="#tab7"><span><?php echo __('Калькуляция') ?></span></a></li>
      <li><a href="#tab8"><span><?php echo __('Логистика') ?></span></a></li>
      <li><a href="#tab9"><span><?php echo __('Фин результат') ?></span></a></li>
     <li><a href="<?php echo $urlAjaxEntityPeople?>"><span><?php echo __('People') ?></span></a></li>
     <li><a href="<?php echo $urlAjaxEntityDepartmentPeople?>"><span><?php echo __('Department People') ?></span></a></li>
   </ul>
   <div id="tab1" data_index="1"></div>
   <div id="tab2" data_index="2"></div>
   <div id="tab3" data_index="3"></div>
   <div id="tab4" data_index="4" style="z-index: -1">
   </div>
  <div id="tab5" data_index="5"><?php echo __('Аудит')?></div>
  <div id="tab6" data_index="6"><?php echo __('Охрана Труда')?></div>
  <div id="tab7" data_index="7"><?php echo __('Калькуляция')?></div>
  <div id="tab8" data_index="8"><?php echo __('Логистика')?></div>
  <div id="tab9" data_index="9"><?php echo __('Фин результат')?></div>
  <div id="tab10" data_index="10"></div>
  <div id="tab11" data_index="11"></div>
</div>

<script type="text/javascript">
  
  $('#entitytabs').tabs();
  
  $('#entitytabs li a').bind('click', function (e){
    e.preventDefault();
    window.location.hash = $(this).attr('href');
  }); 
  
</script>

