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

  <?php if (!$isRowRefresh) : ?>
  <script type="text/javascript">

    $('#grafik_table').fixedtableheader();

  </script>
  <?php endif;?>

  <div class="Fmodel_dialog">
    <a class="people_href"
       data-department_id="<?php echo $department_id?>"
       data-year="<?php echo $year?>"
       data-month="<?php echo $month?>"
       href="#">
      <?php echo __('Add people')?>
    </a>
  </div>

  <table cellspacing="0" width="100%" class="gray entries" id="grafik_table" data-offset="<?php echo isset($offset) ? $offset : 0 ?>">
    <thead >
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

      // Not Officially
      $all_total_not_officially = 0;
      $all_total_days_not_officially = 0;
      $all_total_evening_not_officially = 0;
      $all_total_night_not_officially = 0;

      $count = isset($offset) ? $offset : 0;

      /** @var DepartmentPeople[] $peoples */
      foreach ($peoples as $people):
        $total = 0;
        $day_hours = 0;
        $evening_hours = 0;
        $night_hours = 0;

        $total_not_officially = 0;
        $day_hours_not_officially = 0;
        $evening_hours_not_officially = 0;
        $night_hours_not_officially = 0;

        $count++;
        $salary_days_count = 0;
        $hospitalTill5 = 0;
        $hospitalAfter5 = 0;
        $vacation = 0;
        $hoursHolidays = 0;
        $keyRow = $year.'-'.$month.'-'.$department_id.'-'.$people->getId().'-'.$people->getReplacementId().'-'.$people->getReplacementType();
    ?>
    <tr id="<?php echo $keyRow?>"
        data-department_people_replacement_id = "<?php echo $people->getReplacementId()?>"
        data-department_people_id = "<?php echo $people->getId()?>"
        data-replacement_type = "<?php echo $people->getReplacementType()?>"
        title="<?php echo $people?>"
      >
      <td>#<?php echo $count?></td>
      <td>
        <a href="#" class="people_href" data-id="<?php echo $people->getId()?>"
         data-replacement_id = "<?php echo $people->getReplacementId()?>"
         data-replacement_type = "<?php echo $people->getReplacementType()?>"
         data-key-row = "#<?php echo $keyRow?>"
         <?php if ($people->getParentId()) : ?>style="background-color: #dda6a6"<?php endif;?>
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
        <td <?php if ($is_weekend) : ?>style="background-color: #dda6a6"<?php endif;?>>
          <?php //if ( $canEdit && $year == date('Y') && $month >= intval(date('n')-1)):?>
          <?php if ( $canEdit ):?>
          <?php //if ( $canEdit && Grafik::canCopyToNextMonth($year, $month) ):?>
          <a href="#" class="grafik_day_href"
             data-day="<?php echo $day?>"
             data-people_id="<?php echo $people->getId()?>"
             data-replacement_id="<?php echo $people->getReplacementId()?>"
             data-replacement_type="<?php echo $people->getReplacementType()?>"
            >
          <?php endif;?>
            <?php
              $key =  $year . '-' .
                      $month . '-' .
                      $day . '-' .
                      $department_id . '-' .
                      $people->getId() . '-' .
                      $people->getReplacementId() . '-' .
                      $people->getReplacementType();
            if (isset($grafik[$key])) : ?>
              <?php

              /** @var Grafik $grafikKey */
              $grafikKey = $grafik[$key];
              //todo delete before production
              $result = $grafikKey->getResult() ? $grafikKey->getResult() : '-';
              $resultNotOfficially = $grafikKey->getTotalNotOfficially() ? $grafikKey->getTotalNotOfficially() : '-';

              $total += floatval($result);
              $total_not_officially += floatval($grafikKey->getTotalNotOfficially());
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
                $day_hours += $grafikKey->getTotalDay();
                $evening_hours += $grafikKey->getTotalEvening();
                $night_hours += $grafikKey->getTotalNight();

                $day_hours_not_officially += $grafikKey->getTotalDayNotOfficially();
                $evening_hours_not_officially += $grafikKey->getTotalEveningNotOfficially();
                $night_hours_not_officially += $grafikKey->getTotalNightNotOfficially();
              }

              //hospital
              if ($grafikKey->isHospital() && !$is_weekend)
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
              if ($grafikKey->isVacation())
              {
                $vacation++;
              }
              ?>
              <span style="color:#008200">
                <?php echo floatval($result) ? sprintf("%0.2f", $result) : $result?>
              </span>
              <span style="color: #3366FF">
              <?php
                // Not Officially
                echo floatval($resultNotOfficially) && $resultNotOfficially != 0 ?
                    sprintf("%0.2f", $resultNotOfficially) : '' ?>
              </span>
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
              'field' => 'surcharge,surcharge_type_id,surcharge_type_key,surcharge_description',
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
          'field' => 'bonus,bonus_type_id,bonus_type_key,bonus_description',
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
              'field' => 'fine,fine_type_id,fine_type_key,fine_description',
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
        data-total_not_officially = "<?php echo $total_not_officially?>"
        data-total-days_not_officially = "<?php echo $day_hours_not_officially?>"
        data-total-evening_not_officially = "<?php echo $evening_hours_not_officially?>"
        data-total-night_not_officially = "<?php echo $night_hours_not_officially?>"
        data-total-holidays = "<?php echo $hoursHolidays?>"
      ><?php
        $all_total += $total;
        $all_total_days += $day_hours;
        $all_total_evening += $evening_hours;
        $all_total_night += $night_hours;

        // Not Officially
        $all_total_not_officially += $total_not_officially;
        $all_total_days_not_officially += $day_hours_not_officially;
        $all_total_evening_not_officially += $evening_hours_not_officially;
        $all_total_night_not_officially += $night_hours_not_officially;

        $all_total_holidays += $hoursHolidays;?>
        <span style="color:#008200">
        <?php
          echo $total ? sprintf("%0.2f", $total) : '-';
          echo $total ? '('.$day_hours.'/'.$evening_hours.'/'.$night_hours . '/' . $hoursHolidays .')' : '';
        ?></span>
        <span style="color: #3366FF">
        <?php
          // Not Officially
          echo $total_not_officially ? sprintf("%0.2f", $total_not_officially) : '';
          echo $total_not_officially ? '('.$day_hours_not_officially.'/'.$evening_hours_not_officially.'/'.$night_hours_not_officially.')' : '';
        ?></span>
        <span>
        <?php
        // Not Officially
        $monthTotal = $total_not_officially + $total;
        $monthTotalDay = $day_hours_not_officially + $day_hours;
        $monthTotalEvening = $evening_hours_not_officially + $evening_hours;
        $monthTotalNight = $night_hours_not_officially + $night_hours;
        echo $monthTotal ? sprintf("%0.2f", $monthTotal) : '';
        echo  $monthTotal ?
              '('. $monthTotalDay .'/'.$monthTotalEvening.'/'. $monthTotalNight . '/'. $hoursHolidays .')' :
              '';
        ?></span>
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
    <?php if (sizeof($peoples) && !$isOneRowRefresh) : ?>
      <tr class="show-more-people">
        <td colspan="<?php echo $days_count + 11?>">
            <a href="#" style="display: block"><?php echo __('show more')?></a>
        </td>
      </tr>
    <?php endif?>
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
        <span style="color:#008200">
        <?php
            echo $all_total ? sprintf("%0.2f", $all_total) : '-';
            echo $all_total ? '('.$all_total_days.'/'.$all_total_evening.'/'.$all_total_night.'/'.$all_total_holidays.')' : '-';
          ?>
        </span>
        /<span style="color: #3366FF">
        <?php
            // Not officially
            echo $all_total_not_officially ? sprintf("%0.2f", $all_total_not_officially) : '-';
            echo $all_total_not_officially ? '('.$all_total_days_not_officially.'/'.$all_total_evening_not_officially.'/'.$all_total_night_not_officially.')' : '-'
        ?></span>
        /<span>
        <?php
        $allMonthTotal = $all_total_not_officially + $all_total;
        $allMonthTotalDay = $all_total_days_not_officially + $all_total_days;
        $allMonthTotalEvening = $all_total_evening_not_officially + $all_total_evening;
        $allMonthTotalNight = $all_total_night_not_officially + $all_total_night;
        echo $allMonthTotal ? sprintf("%0.2f", $allMonthTotal) : '-';
        echo $allMonthTotal ? '('.$allMonthTotalDay.'/'.$allMonthTotalEvening.'/'.$allMonthTotalNight.'/'.$all_total_holidays.')' : '-'
        ?></span>
      </td>
      <td></td>
    </tr>
  </tfoot>
</table>
<?php endif; // !isRowRefresh?>
<?php unset($peoples)?>