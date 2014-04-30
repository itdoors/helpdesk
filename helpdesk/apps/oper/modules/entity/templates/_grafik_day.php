<div id="grafik_day_list_outer" style="float: left; width: 600px; display: table">
  <?php echo __('Current date')?>:
  <?php
    $date = new DateTime();
    $date->setDate($params['year'], $params['month'], $params['day']);
    echo format_date($date->format('Y-m-d'), 'dd.MM.yyyy', 'ru');
  ?>

  <div id="grafik_day_list">
    <?php include_component('entity', 'grafik_day_list',
      array(
        'params' => $params
      ))?>
  </div>
  <div id="grafik_form_holder" style="display: none;"></div>
  <?php
  include_component('Fmodel','form_add',
    array(
      'model' => 'GrafikTime',
      'form_class' => 'GrafikTime',
      'target'=>'grafik_form_day_list',
      'button_text' => __('Add grafik data'),
      'default' =>
      array(
        'department_id'=>$params['department_id'],
        'department_people_id'=>$params['department_people_id'],
        'department_people_replacement_id'=>$params['department_people_replacement_id'],
        'replacement_type'=>$params['replacement_type'],
        'year' => $params['year'],
        'month' => $params['month'],
        'day' => $params['day']
      ),
      'ref_functions'=>
      array(
        '#grafik_day_list'=>url_for('entity/refresh_grafik_day_list').'?grafik[department_people_id]='.$params['department_people_id'].'&grafik[department_people_replacement_id]='.$params['department_people_replacement_id'].'&grafik[department_id]='.$params['department_id'].'&grafik[year]='.$params['year'].'&grafik[month]='.$params['month'].'&grafik[day]='.$params['day'].'&grafik[replacement_type]='.$params['replacement_type'].'&'
      )
    )
  );?>
</div>

<div id="grafik_general_form" style="float: right; width: 300px; display: table">
  <?php include_component('entity', 'grafik_form', array('params' => $params))?>
</div>