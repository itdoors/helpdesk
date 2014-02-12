<div id="grafik_holder" 
  data-department_id="<?php echo $department->getId()?>" 
  data-last_day_of_the_month="<?php echo $last_day_of_the_month?>" 
  data-grafik_day_url="<?php echo url_for('entity/grafik_day')?>"
  data-refresh_grafik_day_list_url="<?php echo url_for('entity/refresh_grafik_day_list')?>"
  data-grafik_form_url="<?php echo url_for('entity/grafik_form')?>"
  data-grafik_time_form_url="<?php echo url_for('entity/grafik_time_form')?>"
  data-people_form_url="<?php echo url_for('entity/people_form')?>"
  data-people_month_info_form_url="<?php echo url_for('entity/people_month_info_form')?>"
  data-get_months_url="<?php echo url_for('entity/get_months')?>"
  data-copy_permanent_staff_url="<?php echo url_for('entity/copy_permanent_staff')?>"
  data-refresh_grafik_row_url="<?php echo url_for('ajax_entity_refresh_grafik_row')?>"
  data-people_list_more="<?php echo url_for('ajax_entity_grafik', array(
    'department_id' => $department->getId(),
    'can_edit' => 1
  ))?>"
  style="display:none"></div>

<div id="month_holder" data-year="<?php echo $year?>" data-month="<?php echo $month?>">
  <?php include_component('entity', 'month_holder', 
    array(
      'year' => $year, 
      'month' => $month,
      'department_id' => $department->getId()
    ))?>
</div>                                                                            
<div id="people_list">
  <?php include_component('entity', 'people_list', array(
    'department_id' => $department->getId(),
    'year' => $year, 
    'month' => $month,
    'offset' => 0
  ))?>
</div>

<div id="grafik_day_holder" style="display: table">
</div>
<script type="text/javascript">
  var month = $('#grafik_date_month').val();
  var year = $('#grafik_date_year').val();
  ChangePeopleFormDefaults(month, year);
  
  var system_month = <?php echo $month?>;
  var system_year = <?php echo $year?>;
  
  if (system_month != month || system_year != year)
  {
    $('#grafik_date_change_form').submit();
  }

  $('table#grafik_table tr.show-more-people').appear();

  $('table#grafik_table tr.show-more-people').live('appear', function(event, $all_appeared_elements) {
    $('table#grafik_table tr.show-more-people').trigger('click');
  })

  var isPeopleListLoading = false;

  $('table#grafik_table tr.show-more-people').live('click', function(e){
    e.preventDefault();

    if (isPeopleListLoading)
    {
      return false;
    }

    var target = $(this);

    var parentTable = $('table#grafik_table');

    var offset = parentTable.data('offset');
    var limit = <?php echo sfConfig::get('app_grafik_people_limit')?>;

    var newOffset = offset + limit;

    parentTable.data('offset', newOffset);

    $.ajax({
      type: 'POST',
      url: '<?php echo url_for('ajax_entity_grafik_post')?>',
      data: {
        department_id: '<?php echo $department->getId()?>',
        offset: newOffset,
        canEdit: '1'
      },
      beforeSend: function(){
        isPeopleListLoading = true;
      },
      success: function(response){
        isPeopleListLoading = false;
        target.replaceWith(response);
        updateTotalHours();
      }
    })
  });
</script>
<div id="people_form_holder" style="display: none;"></div>
