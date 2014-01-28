<?php if (!$isRowRefresh): ?>
  <?php if ($canCopyToNetxtMonth):?>
    <div class="copy_permanent_staff_holder">
      <?php if (!$queue): ?>
      <a href="javascript:;" class="copy_permanent_staff"><?php echo __("Copy permanent staff to next month")?></a>
      <?php else:?>
        <?php
          $params = array('%percent%' => $queue->getPercent());
          echo __('This task added to queue. Already proceeded %percent%% percents', $params);
        ?>
      <?php endif;?>
    </div>
  <?php endif;?>
  <?php if ($salaryInfo):?>
  <br />
    <?php echo __('Days count')?>: <?php echo $salaryInfo->getDaysCount()?>
    <?php echo __('Day salary')?>: <?php echo $salaryInfo->getDaySalary()?>
    <?php echo __('Weekends')?>: <?php echo $salaryInfo->getWeekends()?>
     | <a href="<?php echo url_for('entity_excel_1c', array('department_id'=>$department_id, 'year' => $year, 'month' => $month) )?>">
         <?php echo  __('excel export salary')?>
       </a>
     | <a href="<?php echo url_for('entity_excel_print', array('department_id'=>$department_id, 'year' => $year, 'month' => $month) )?>"
          class="entity_excel_print1" target="_blank"
          data-text="<?php echo __('Wait for a minute data is loading')?>"
        >
         <?php echo  __('excel export salary print')?>
       </a>
  <?php endif;?>

  <?php if (sizeof($peoples) > 10) : ?>
  <script type="text/javascript">
    $(document).ready(function(){
      var oTableGrafik = $('#grafik_table').dataTable({
        sDom: 't',
        bSort: false,
        iDisplayLength: -1
      });
      new FixedHeader( oTableGrafik );
    });
  </script>
  <?php endif;?>

  <table cellspacing="0" width="100%" class="gray" id="grafik_table">
    <thead>
      <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <?php for($day = 1; $day <= $days_count; $day++):?>
          <th><?php echo $day?></th>
        <?php endfor;?>
        <th><?php echo __('Surcharge')?></th>
        <th><?php echo __('Bonus')?></th>
        <th><?php echo __('Fine')?></th>
        <th><?php echo __('Total')?></th>
        <th><?php echo __('Salary')?></th>
        <th><?php echo __('Company costs')?></th>
        <th><?php echo __('З/П')?></th>
      </tr>
    </thead>
    <tbody>
<?php endif; // !isRowRefresh?>
    <?php
      //todo temporary hack
      /** @var Salary $salaryInfo */
      $holidays = $salaryInfo ? $salaryInfo->getAllWeekends() : array();
      $holidays = sizeof($holidays) ? $holidays->getRawValue() : array();
      $all_total = 0;
      $all_total_days = 0;
      $all_total_evening = 0;
      $all_total_night = 0;
      $all_total_holidays = 0;
      $count = 0;

      foreach ($peoples as $people): /** @var DepartmentPeople $people */
      $total = 0;
      $day_hours = 0;
      $evening_hours = 0;
      $night_hours = 0;
      $count++;
      $salary_days_count = 0;
      $hospitalTill5 = 0;
      $hospitalAfter5 = 0;
      $vacation = 0;
      $hoursHolidays = 0;
      $keyRow = $year.'-'.$month.'-'.$department_id.'-'.$people->getId().'-'.$people->getReplacementId();
    ?>
    <tr id="<?php echo $keyRow?>"
        data-department_people_replacement_id = "<?php echo $people->getReplacementId()?>"
        data-department_people_id = "<?php echo $people->getId()?>"
      >
      <td>#<?php echo $count?></td>
      <td>
        <a href="#" class="people_href" data-id="<?php echo $people->getId()?>"
         data-replacement_id = "<?php echo $people->getReplacementId()?>"
         data-key-row = "#<?php echo $keyRow?>"
         <?php if ($people->getParentId()) : ?>style="background-color: red"<?php endif;?>
        >
          <?php echo $people?>
        </a>
      </td>
      <td><?php echo $people->getEmploymentTypeChar()?></td>
      <td> <?php echo $people->getTypeChar()?> </td>
       <?php for($day = 1; $day <= $days_count; $day++):
       $date = new DateTime();
       $date->setDate($year, $month, $day);
       $date->format('U');
       $is_weekend = false;

       if (in_array($day, $holidays))
       {
         $is_weekend = true;
       }

       ?>
        <td <?php if ($is_weekend) : ?>style="background-color: red"<?php endif;?>>
          <?php //if ( $canEdit && $year == date('Y') && $month >= intval(date('n')-1)):?>
          <?php if ( $canEdit ):?>
          <?php //if ( $canEdit && Grafik::canCopyToNextMonth($year, $month) ):?>
          <a href="#" class="grafik_day_href"
             data-day="<?php echo $day?>"
             data-people_id="<?php echo $people->getId()?>"
             data-replacement_id="<?php echo $people->getReplacementId()?>"
            >
          <?php endif;?>
            <?php
              $key = $year.'-'.$month.'-'.$day.'-'.$department_id.'-'.$people->getId().'-'.$people->getReplacementId();
            if (isset($grafik[$key])) : ?>
              <?php  /*$result = Grafik::getTotalResultByGrafikArray($grafik[$key]);
                     $day_hours = Grafik::getTotalDayHoursByGrafikArray($grafik[$key]);
                     $evening_hours = Grafik::getTotalEveningHoursByGrafikArray($grafik[$key]);
                     $night_hours = Grafik::getTotalNightHoursByGrafikArray($grafik[$key]);*/

              //todo delete before production
              $result = $grafik[$key]->getResult() ? $grafik[$key]->getResult() : '-';

              $total += floatval($result);
              if (floatval($result))
              {
                $salary_days_count++;
              }

              if (floatval($result) && $is_weekend)
              {
                $hoursHolidays += floatval($result);
              }
              else
              {
                $day_hours += $grafik[$key]->getTotalDay();
                $evening_hours += $grafik[$key]->getTotalEvening();
                $night_hours += $grafik[$key]->getTotalNight();
              }

              //hospital
              if ($grafik[$key]->isHospital() && !$is_weekend)
              {
                if ($hospitalTill5 < 5)
                {
                  $hospitalTill5++;
                }
                else
                {
                  $hospitalAfter5++;
                }
              }
              //vacation
              if ($grafik[$key]->isVacation())
              {
                $vacation++;
              }
              ?>
              <?php echo floatval($result) ? sprintf("%0.2f", $result) : $result?>
            <?php else : ?>
              <?php echo '-'?>
            <?php endif;?>
          <?php //if ( $year == date('Y') && $month >= intval(date('n')) ):?>
          <?php if ( $canEdit ):?>
          </a>
          <?php endif;?>
        </td>
      <?php endfor;?>
      <td>
        <?php
        echo
        !$canEdit ? $people->getSurchargeString() :
          get_component('Fmodel','ajax_field_change',
            array(
              'where'=> array(
                'department_people_id'=> $people->getId(),
                'year' => $year,
                'month' => $month,
                'department_people_replacement_id' => $people->getReplacementId()
              ),
              'model' => 'DepartmentPeopleMonthInfo',
              'field' => 'surcharge,surcharge_type_id,surcharge_type_key',
              'withLabel' => 1,
              'toString' =>'getSurchargeString',
              'default' => $people->getSurchargeString(),
              'shortEdit' => true,
              'ref_functions_names' => array(
                'updateGrafik' => '#' . $keyRow
              )
            )
          )?>
      </td>
      <td><?php
        echo
        !$canEdit ? $people->getBonusString() :
        get_component('Fmodel','ajax_field_change',
          array(
          'where'=> array(
            'department_people_id'=> $people->getId(),
            'year' => $year,
            'month' => $month,
            'department_people_replacement_id' => $people->getReplacementId()
          ),
          'model' => 'DepartmentPeopleMonthInfo',
          'field' => 'bonus,bonus_type_id,bonus_type_key',
          'withLabel' => 1,
          'toString' =>'getBonusString',
          'default' => $people->getBonusString(),
          'shortEdit' => true,
          'ref_functions_names' => array(
            'updateGrafik' => '#' . $keyRow
          )
          )
        )?></td>
      <td>
        <?php
        echo
        !$canEdit ? $people->getFineString() :
          get_component('Fmodel','ajax_field_change',
            array(
              'where'=> array(
                'department_people_id'=> $people->getId(),
                'year' => $year,
                'month' => $month,
                'department_people_replacement_id' => $people->getReplacementId()
              ),
              'model' => 'DepartmentPeopleMonthInfo',
              'field' => 'fine,fine_type_id,fine_type_key',
              'withLabel' => 1,
              'toString' =>'getFineString',
              'default' => $people->getFineString(),
              'shortEdit' => true,
              'ref_functions_names' => array(
                'updateGrafik' => '#' . $keyRow
              )
            )
          )?>
      </td>
      <td class="total-hours-info"
        data-total = "<?php echo $total?>"
        data-total-days = "<?php echo $day_hours?>"
        data-total-evening = "<?php echo $evening_hours?>"
        data-total-night = "<?php echo $night_hours?>"
        data-total-holidays = "<?php echo $hoursHolidays?>"
      ><?php
        $all_total += $total;
        $all_total_days += $day_hours;
        $all_total_evening += $evening_hours;
        $all_total_night += $night_hours;
        $all_total_holidays += $hoursHolidays;
        echo $total ? sprintf("%0.2f", $total) : '-';
        echo $total ? '('.$day_hours.'/'.$evening_hours.'/'.$night_hours . '/' . $hoursHolidays .')' : '';
        ?>
      </td>
      <td><?php echo $people->getSalary()?></td>
      <td><?php
        if ($salary_days_count)
        {
          $fullSalary = $salaryInfo->summary($people->getEmploymentTypeLukey(), $salary_days_count, $hospitalTill5, $hospitalAfter5, $vacation, $people, $day_hours, $evening_hours, $night_hours, $hoursHolidays);

          /*$isCleanSlary = $people->getIsCleanSalary();

          if ($isCleanSlary && $people->getSalary() < $fullSalary)
          {
            $fullSalary = $people->getSalary();
          }*/

          echo $fullSalary;
        }
        ?>
      </td>
      <td><?php echo $people->getRealSalary() ? sprintf("%0.2f", $people->getRealSalary()) : '';?></td>
    </tr>
    <?php endforeach;?>
<?php if (!$isRowRefresh): ?>
    </tbody>
    <tfoot>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td colspan="<?php echo $days_count-2?>"></td>
      <td></td>
      <td></td>
      <td colspan="8" data-text="<?php echo __('Total by month')?>" id="grafik-table-total-info">
        <?php echo __('Total by month')?>:
          <?php
            echo $all_total ? sprintf("%0.2f", $all_total) : '-';
            echo $all_total ? '('.$all_total_days.'/'.$all_total_evening.'/'.$all_total_night.'/'.$all_total_holidays.')' : '-'
          ?>
      </td>
      <td></td>
    </tr>
  </tfoot>
</table>

<div class="Fmodel_dialog">
  <a class="people_href"
     data-department_id="<?php echo $department_id?>"
     data-year="<?php echo $year?>"
     data-month="<?php echo $month?>"
     href="#">
    <?php echo __('Add people')?>
  </a>
</div>
<?php endif; // !isRowRefresh?>
