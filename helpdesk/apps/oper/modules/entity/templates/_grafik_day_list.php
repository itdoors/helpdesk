<?php
  $dayTotal = 0;
  $dayTotalDay = 0;
  $dayTotalEvening = 0;
  $dayTotalNight = 0;
?>

<table class="gray">
  <tr>
    <td><?php echo __('Time range')?></td>
    <td><?php echo __('Total')?></td>
    <td><?php echo __('Total day')?></td>
    <td><?php echo __('Total evening')?></td>
    <td><?php echo __('Total night')?></td>
    <td><?php echo __('Edit')?></td>
    <td><?php echo __('Delete')?></td>
  </tr>
  <?php
  /** @var GrafikTime[] $grafiks */
  foreach ($grafiks as $grafik):?>
  <?php
    $isOfficially = $grafik->isOfficially();

    if ($isOfficially)
    {
      $dayTotal += $grafik->getResult();
      $dayTotalDay += $grafik->getTotalDay();
      $dayTotalEvening += $grafik->getTotalEvening();
      $dayTotalNight += $grafik->getTotalNight();
    }
    else
    {
      $dayTotal += $grafik->getTotalNotOfficially();
      $dayTotalDay += $grafik->getTotalDayNotOfficially();
      $dayTotalEvening += $grafik->getTotalEveningNotOfficially();
      $dayTotalNight += $grafik->getTotalNightNotOfficially();
    }

    // Color
    $color = $isOfficially ? '#008200' : '#3366FF';
  ?>
  <tr style="color: <?php echo $color; ?>">
    <td>
      <?php echo $grafik->getFromTime();?> - <?php echo $grafik->getToTime();?>
    </td>
    <td>
      <?php echo $isOfficially ? $grafik->getResult() : $grafik->getTotalNotOfficially();?>
    </td>
    <td>
      <?php echo $isOfficially ? $grafik->getTotalDay() : $grafik->getTotalDayNotOfficially();?>
    </td>
    <td>
      <?php echo $isOfficially ? $grafik->getTotalEvening() : $grafik->getTotalEveningNotOfficially();?>
    </td>
    <td>
      <?php echo $isOfficially ?  $grafik->getTotalNight() : $grafik->getTotalNightNotOfficially();?>
    </td>
    <td>
      <a href="#" class="grafik_href"
         data-id="<?php echo $grafik->getId()?>"
         data-day="<?php echo $grafik->getDay()?>"
         data-people_id="<?php echo $grafik->getDepartmentPeopleId()?>"
         data-replacement_id="<?php echo $grafik->getDepartmentPeopleReplacementId()?>"
         data-replacement_type="<?php echo $grafik->getReplacementType()?>"
        >
        <?php echo __('Edit')?>
      </a>
    </td>
    <td>
      <?php
      include_component('Fmodel', 'delete_record_advanced',
        array(
          'model'   => 'GrafikTime',
          'parents_tag'   => 'td',
          'where'      => array(
            'id' => $grafik->getId(),
          ),
          'ref_functions' =>
            array(
              '#grafik_day_list'=>
                 url_for('entity/refresh_grafik_day_list').'?grafik[department_people_id]='.$params['department_people_id'].'&grafik[department_people_replacement_id]='.$params['department_people_replacement_id'].'&grafik[department_id]='.$params['department_id'].'&grafik[year]='.$params['year'].'&grafik[month]='.$params['month'].'&grafik[day]='.$params['day'].'&grafik[replacement_type]='.$params['replacement_type'].'&'
            )
        ))
      ?>
    </td>

  </tr>
  <?php endforeach;?>
  <?php if (sizeof($grafiks)) : ?>
    <tr>
      <td><?php echo __('Total')?></td>
      <td><?php echo $dayTotal?></td>
      <td><?php echo $dayTotalDay?></td>
      <td><?php echo $dayTotalEvening?></td>
      <td><?php echo $dayTotalNight?></td>
      <td></td>
      <td></td>
    </tr>
  <?php endif;?>
</table>