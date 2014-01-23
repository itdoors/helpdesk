<?php

/**
 * Grafik
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Grafik extends BaseGrafik
{
  static public function getPeople($departmentIds, $year, $month, $departmentPeopleId = null, $departmentPeopleReplacementId = null)
  {
    return DepartmentPeopleTable::getPeople($departmentIds, $year, $month, $departmentPeopleId, $departmentPeopleReplacementId);
  }

  static public function getPeopleArrayByDepartmentIdKey($departmentIds, $year, $month)
  {
    return DepartmentPeopleTable::getPeopleArrayByDepartmentIdKey($departmentIds, $year, $month);
  }

  static public function getFormattedData($year, $month, $departmentIds, $departmentPeopleId = null, $departmentPeopleReplacementId = null)
  {
    $result = array();

    $query = Doctrine::getTable('Grafik')
      ->createQuery('g')
      ->where('g.year =? ', $year)
      ->addWhere('g.month =? ', $month)
      ->andWhereIn('g.department_id', $departmentIds);

    if ($departmentPeopleId)
    {
      $query
        ->addWhere('g.department_people_id = ?', $departmentPeopleId);
    }

    if (!is_null($departmentPeopleReplacementId))
    {
      $query
        ->addWhere('g.department_people_replacement_id = ?', $departmentPeopleReplacementId);
    }

    $grafiks = $query->execute();

    foreach($grafiks as $grafik) /** @var Grafik $grafik*/
    {
      // $key = $grafik->getYear() .'-'. $grafik->getMonth().'-'. $grafik->getDay() .'-'.$grafik->getDepartmentId().'-'.$grafik->getDepartmentPeopleId();
      $key = $grafik->getKey();

      $result[$key] = $grafik->getResult();
      $result[$key] = $grafik;
    }

    return $result;
  }
  
  public function getResult()
  {
    $res = $this->getTotal();

    if ($this->getIsSick())
    {
      $res = 'sick';
    }

    if ($this->getIsSkip())
    {
      $res = 'skip';
    }
    
    if ($this->getIsFired())
    {
      $res = 'fired';
    }
    
    if ($this->getIsVacation())
    {
      $res = 'vacation';
    }

    /*if (!sfContext::hasInstance())
    {
      return $res;
    }*/

    $i18n = sfContext::getInstance()->getI18N();

    return $i18n->__($res);
  }

  public function isHospital()
  {
    return $this->getResult() == 'sick';
  }

  public function isVacation()
  {
    return $this->getResult() == 'vacation';
  }
  
  static public function getWorkedMonthsIndex($departmentId, $year = null)
  {
    $year = $year ? $year : date('Y');
    
    $conn = Doctrine_Manager::getInstance()->connection();

    // @todo people ids must count from DepartmentPeopleMonthInfo
    $query = "
      SELECT
        DISTINCT(dpmi.month) AS month
      FROM
        department_people_month_info dpmi
     LEFT JOIN department_people dp ON dpmi.department_people_id = dp.id
     WHERE
       dpmi.year = :year AND
       dp.department_id =:department_id";

    $stmt = $conn->prepare($query);

    $params = array(
      ':year' => $year,
      ':department_id' => $departmentId
    );

    $stmt->execute($params);

    $months = $stmt->fetchAll();
      
    $return = array();
    
    if (sizeof($months))
    {
      foreach($months as $month) 
      {
        $return[] = $month['month'];
      }
    }
    
    if ($year == date('Y'))
    {
      if ((date('n')-1) >= 1)
      {
        $return[] =  date('n')-1;
      }
      $return[] = date('n');
      $return[] = date('n')+1;
      
      $return = array_unique($return);
    }
    
    return $return;
  }
  
  static public function getWorkedMonths($monthIds)
  {
    $culture = isset($options['culture']) ? $options['culture'] : 'ru';
    
    $months = array_combine(range(1, 12), sfDateTimeFormatInfo::getInstance($culture)->getMonthNames());
    
    foreach($months as $key => $value)
    {
      if (!in_array($key, $monthIds))
      {
        unset($months[$key]);
      }
    }
    
    return $months;
  }
  
  static public function deletePeopleInfo($year, $month, $department_id, $department_people_id)
  {
    $grafik = Doctrine::getTable('Grafik')
      ->createQuery('g')
      ->where('g.year = ?', $year)
      ->addWhere('g.month =?', $month)
      ->addWhere('g.department_id =?', $department_id)
      ->addWhere('g.department_people_id =?', $department_people_id)
      ->execute()
      ->delete();

    $grafikTime = Doctrine::getTable('GrafikTime')
      ->createQuery('g')
      ->where('g.year = ?', $year)
      ->addWhere('g.month =?', $month)
      ->addWhere('g.department_id =?', $department_id)
      ->addWhere('g.department_people_id =?', $department_people_id)
      ->execute()
      ->delete();
      
    return $grafik;
  }
  
  static public function canCopyToNextMonth($year, $month)
  {
    return true;

    if ($year == date('Y'))
    {
      //if we in this month
      if ($month == date('n') || ($month == date('n') - 1 && $month != 1 && date('j') < 25))
      {
        return true;
      }
    }
 
    if ($year == date('Y') - 1 && $month == 12 && date('j') < 15)
    {
      return true;
    } 
      
    return false;
  }
  
/*  static public function copyToNextMonth($department_id, $year, $month, Queue $queue = null)
  {
    if (!self::canCopyToNextMonth($year, $month))
    {
      return false;
    }
    
    $next_month = $month < 12 ? $month + 1 : 1;
    $next_year = $month < 12 ? $year : $year + 1;
    
    $type_id = DepartmentPeople::getPermanentStaffTypeId();
    
    $departmentPeopleMonthInfos = Doctrine::getTable('DepartmentPeopleMonthInfo')
      ->createQuery('dpmi')
      ->addWhere('dpmi.year = ?', $year)
      ->addWhere('dpmi.month = ?', $month)
      ->addWhere('dpmi.type_id = ?', $type_id)
      ->leftJoin('dpmi.DepartmentPeople dp')
      ->andWhere('dp.department_id = ? ', $department_id)
      ->andWhere('dp.parent_id is null')
      ->execute();

    $total = sizeof($departmentPeopleMonthInfos);
    $i = 0;
      
    foreach ($departmentPeopleMonthInfos as $monthInfo)
    {
      $i++;

      $newMonthInfo = $monthInfo->copy();

      $newMonthInfo->setYear($next_year);
      $newMonthInfo->setMonth($next_month);

      try
      {
        $newMonthInfo->trySave();

        $personId = $monthInfo->getDepartmentPeopleId();
        $person = Doctrine::getTable('DepartmentPeople')->find($personId);
        $personFullName = $person->getFullName();

        echo "$personId, $department_id, $year, $month, $next_year, $next_month";

        $newMonthInfo->copyGrafikFromPreviousMonth($personId, $department_id, $year, $month, $next_year, $next_month);

        if ($queue)
        {
          $percent = round($i/$total * 100);

          $queue->setPercent($percent);

          $queue->save();
        }
      }
      catch (Exception $e)
      {
        MailFunctions::sendMessageToUser('ppecheny@gmail.com', 'Duplicate copy to next month', "$department_id, $personId, $personFullName,  $monthInfo, $year, $month");
      }

    }
    
    return true;
  }*/

  static public function copyToNextMonth($departmentId, $year, $month, Queue $queue = null)
  {
    if (!self::canCopyToNextMonth($year, $month))
    {
      return false;
    }

    $nextMonth = $month < 12 ? $month + 1 : 1;
    $nextYear = $month < 12 ? $year : $year + 1;

    $type_id = DepartmentPeople::getPermanentStaffTypeId();

    /** @var Doctrine_Collection $departmentPeopleMonthInfos */
    $departmentPeopleMonthInfos = Doctrine::getTable('DepartmentPeopleMonthInfo')
      ->createQuery('dpmi')
      ->addWhere('dpmi.year = ?', $year)
      ->addWhere('dpmi.month = ?', $month)
      ->addWhere('dpmi.type_id = ?', $type_id)
      ->leftJoin('dpmi.DepartmentPeople dp')
      ->andWhere('dp.department_id = ? ', $departmentId)
      ->andWhere('dp.parent_id is null')
      ->execute();

    /** @var Salary $salaryInfo*/
    $salaryInfo = Salary::getMonthInfo($year, $month);
    $holidays = $salaryInfo ? $salaryInfo->getAllWeekends() : array();

    /** @var Salary $salaryInfo*/
    $salaryInfoNext = Salary::getMonthInfo($nextYear, $nextMonth);
    $holidaysNext = $salaryInfoNext ? $salaryInfoNext->getAllWeekends() : array();

    $firstWorkDayThisMonth = Grafik::getFirstWorkDay($year, $month, $holidays);
    $firstWorkDayNextMonth = Grafik::getFirstWorkDay($nextYear, $nextMonth, $holidaysNext);

    foreach ($departmentPeopleMonthInfos as $info) /**@var DepartmentPeopleMonthInfo $info*/
    {
      $personId = $info->getDepartmentPeopleId();
      $replacementId = $info->getDepartmentPeopleReplacementId();

      self::copyPersonToNextMonth($personId, $replacementId, $departmentId, $year, $month, $holidaysNext, $firstWorkDayThisMonth, $firstWorkDayNextMonth);
    }

    return true;
  }

  /**
   * Generate insert string for Grafik Model
   *
   * @param int $personId
   * @param int $replacementId
   * @param int $departmentId
   * @param int $year
   * @param int $month
   * @param int $nextYear
   * @param int $nextMonth
   *
   * @return string $return
   */
  public static function generateInsertStringGrafik($personId, $replacementId, $departmentId, $year, $month, $nextYear, $nextMonth)
  {
    $workDataPrevMonth = Grafik::getWorkDataArray('Grafik', $personId, $replacementId, $departmentId, $year, $month, true, true);
    $workDataNextMonth = Grafik::getWorkDataArray('Grafik', $personId, $replacementId, $departmentId, $nextYear, $nextMonth);

    $return = array();

    /*'VALUES (
          year,
          month,
          department_id,
          department_people_id,
          department_people_replacement_id,
          day,
          total,
          is_sick,
          is_skip,
          is_fired,
          is_vacation,
          total_day,
          total_evening,
          total_night)'*/

    $pattern = '(%d, %d, %d, %d, %d, %d, %d, %s, %s, %s, %s, %d, %d, %d)';

    $workDaysInNextMonth = self::getWorkDaysInTheMonth($nextYear, $nextMonth);

    foreach ($workDaysInNextMonth as $day)
    {
      /** @var Grafik $prevDayData */
      if (!sizeof($workDataPrevMonth))
      {
        break;
      }

      $prevDayData = array_shift($workDataPrevMonth);

      if (!$prevDayData)
      {
        continue;
      }

      if (isset($workDataNextMonth[$day]))
      {
        continue;
      }

      $dataTotal= $prevDayData->getTotal();
      $dataTotalDay = $prevDayData->getTotalDay();
      $dataTotalEvening = $prevDayData->getTotalEvening();
      $dataTotalNight = $prevDayData->getTotalNight();
      $dataIsSick = $prevDayData->getIsSick() ? 'true' : 'false';
      $dataIsSkip = $prevDayData->getIsSkip() ? 'true' : 'false';
      $dataIsFired = $prevDayData->getIsFired() ? 'true' : 'false';
      $dataIsVacation = $prevDayData->getIsVacation() ? 'true' : 'false';

      $return[] = sprintf($pattern,
        $nextYear,
        $nextMonth,
        $departmentId,
        $personId,
        $replacementId,
        $day,
        $dataTotal,
        $dataIsSick,
        $dataIsSkip,
        $dataIsFired,
        $dataIsVacation,
        $dataTotalDay,
        $dataTotalEvening,
        $dataTotalNight
      );
    }

    if (!sizeof($return))
    {
      return '';
    }

    return implode(', ', $return);
  }

  /**
   * Generate insert string for Grafik Model
   *
   * @param int $personId
   * @param int $replacementId
   * @param int $departmentId
   * @param int $year
   * @param int $month
   * @param int $nextYear
   * @param int $nextMonth
   *
   * @return string $return
   */
  public static function generateInsertStringGrafikTime($personId, $replacementId, $departmentId, $year, $month, $nextYear, $nextMonth)
  {
    $workDataPrevMonth = Grafik::getWorkDataArray('GrafikTime', $personId, $replacementId, $departmentId, $year, $month, true, true);
    $workDataNextMonth = Grafik::getWorkDataArray('GrafikTime', $personId, $replacementId, $departmentId, $nextYear, $nextMonth);

    $return = array();

    /*'VALUES (
          year,
          month,
          department_id,
          department_people_id,
          department_people_replacement_id,
          day,
          from_time,
          to_time,
          total,
          total_day,
          total_evening,
          total_night)'*/

    $pattern = "(%d, %d, %d, %d, %d, %d, '%s', '%s', %d, %d, %d, %d)";

    $workDaysInNextMonth = self::getWorkDaysInTheMonth($nextYear, $nextMonth);

    foreach ($workDaysInNextMonth as $day)
    {
      if (!sizeof($workDataPrevMonth))
      {
        break;
      }

      $prevDayDataArray = array_shift($workDataPrevMonth);

      if (!sizeof($prevDayDataArray))
      {
        continue;
      }

      if (isset($workDataNextMonth[$day]))
      {
        continue;
      }

      /** @var GrafikTime $prevDayData */
      foreach ($prevDayDataArray as $prevDayData)
      {
        $dataFromTime = $prevDayData->getFromTime();
        $dataToTime = $prevDayData->getToTime();

        $dataTotal= $prevDayData->getTotal();
        $dataTotalDay = $prevDayData->getTotalDay();
        $dataTotalEvening = $prevDayData->getTotalEvening();
        $dataTotalNight = $prevDayData->getTotalNight();

        $return[] = sprintf($pattern,
          $nextYear,
          $nextMonth,
          $departmentId,
          $personId,
          $replacementId,
          $day,
          $dataFromTime,
          $dataToTime,
          $dataTotal,
          $dataTotalDay,
          $dataTotalEvening,
          $dataTotalNight
        );
      }
    }

    if (!sizeof($return))
    {
      return '';
    }

    return implode(', ', $return);
  }


  /**
   * Copy one person to next month
   *
   * @param int $personId
   * @param int $replacementId
   * @param int $departmentId
   * @param int $year current year
   * @param int $month current month
   * @param string $holidays weekends of next month in 1,2,6,20 etc
   * @param int $firstWorkDayThisMonth
   * @param int $firstWorkDayNextMonth
   * @param string $daysToCopyString
   */
  public static function copyPersonToNextMonth($personId, $replacementId, $departmentId, $year, $month, $holidays = '', $firstWorkDayThisMonth = null, $firstWorkDayNextMonth = null, $daysToCopyString = '')
  {
    if ($month < 12)
    {
      $nextYear = $year;
      $nextMonth = $month + 1;

      $nextYearString = 'year';
      $nextMonthString = 'month + 1';
    }
    else
    {
      $nextYear = $year + 1;
      $nextMonth =  1;

      $nextYearString = 'year + 1';
      $nextMonthString = 'month - 11';
    }

    if (!$firstWorkDayThisMonth || !$firstWorkDayNextMonth)
    {
      $firstWorkDayThisMonth = Grafik::getFirstWorkDay($year, $month);
      $firstWorkDayNextMonth = Grafik::getFirstWorkDay($nextYear, $nextMonth);
    }

    // Department People Month Info Copy
    $conn = Doctrine_Manager::getInstance()->connection();

    // @todo people ids must count from DepartmentPeopleMonthInfo
    $query = "
     insert
       into department_people_month_info
       (
         year,
         month,
         department_people_id,
         surcharge,
         surcharge_type_id,
         bonus,
         bonus_type_id,
         fine,
         fine_type_id,
         salary,
         position_id,
         type_id,
         type_string,
         employment_type_id,
         salary_type_id,
         is_clean_salary,
         norma_days,
         department_people_replacement_id
       )
       (
         select
           dpmi.".$nextYearString." as year,
           dpmi.".$nextMonthString." as month,
           dpmi.department_people_id,
           dpmi.surcharge,
           dpmi.surcharge_type_id,
           dpmi.bonus,
           dpmi.bonus_type_id,
           dpmi.fine,
           dpmi.fine_type_id,
           dpmi.salary,
           dpmi.position_id,
           dpmi.type_id,
           dpmi.type_string,
           dpmi.employment_type_id,
           dpmi.salary_type_id,
           dpmi.is_clean_salary,
           dpmi.norma_days,
           dpmi.department_people_replacement_id
         from
           department_people_month_info dpmi
         where
           dpmi.year = :year and
           dpmi.month = :month and
           dpmi.department_people_id = :personId and
           dpmi.department_people_replacement_id = :replacementId and
           not exists
             (
               select
                 1
               from
                 department_people_month_info dpmi1
               where
                 dpmi1.year = :nextYear and
                 dpmi1.month = :nextMonth and
                 dpmi1.department_people_id = :personId and
                 dpmi1.department_people_replacement_id = :replacementId
             )
        )";

    $stmt = $conn->prepare($query);

    $params = array(
      ':year' => $year,
      ':month' => $month,
      ':nextYear' => $nextYear,
      ':nextMonth' => $nextMonth,
      ':personId' => $personId,
      ':replacementId' => $replacementId,
    );

    $stmt->execute($params);

    $insertGrafikString = self::generateInsertStringGrafik($personId, $replacementId, $departmentId, $year, $month, $nextYear, $nextMonth);

    if ($insertGrafikString)
    {
      // Copy grafik
      $conn = Doctrine_Manager::getInstance()->connection();

      // @todo people ids must count from DepartmentPeopleMonthInfo

      $query = "
      insert
        into grafik
        (
          year,
          month,
          department_id,
          department_people_id,
          department_people_replacement_id,
          day,
          total,
          is_sick,
          is_skip,
          is_fired,
          is_vacation,
          total_day,
          total_evening,
          total_night
        )
        VALUES ";

      $query .= $insertGrafikString;

      $stmt = $conn->prepare($query);

      $stmt->execute(array());
    }

    $insertGrafikTimeString = self::generateInsertStringGrafikTime($personId, $replacementId, $departmentId, $year, $month, $nextYear, $nextMonth);

    if ($insertGrafikTimeString)
    {
      // Copy grafik time

      // @todo people ids must count from DepartmentPeopleMonthInfo
      $query = "
      insert
        into grafik_time
        (
          year,
          month,
          department_id,
          department_people_id,
          department_people_replacement_id,
          day,
          from_time,
          to_time,
          total,
          total_day,
          total_evening,
          total_night
        )
        VALUES ";

      $query .= $insertGrafikTimeString;

      $stmt = $conn->prepare($query);

      $stmt->execute(array());
    }
  }

  /**
   * Get array of working data from grafik or Grafik time
   *
   * @param string $model
   * @param int $personId
   * @param int $replacementId
   * @param int $departmentId
   * @param int $year
   * @param int $month
   * @param bool $withoutWeekends
   * @param bool $withEmpty
   *
   * @return mixed[]
   */
  public static function getWorkDataArray($model = 'Grafik', $personId, $replacementId, $departmentId, $year, $month, $withoutWeekends = true, $withEmpty = false)
  {
    $workDays = array();

    if ($withoutWeekends)
    {
      $workDays = self::getWorkDaysInTheMonth($year, $month);
    }

    /** @var Doctrine_Query $query */
    $query = Doctrine::getTable(ucfirst($model))
      ->createQuery('q')
      ->where('q.department_people_id = ?', $personId)
      ->addWhere('q.department_people_replacement_id = ?', $replacementId)
      ->addWhere('q.department_id = ?', $departmentId)
      ->addWhere('q.year = ?', $year)
      ->addWhere('q.month = ?', $month);

    if ($withoutWeekends)
    {
      $query->andWhereIn('q.day', $workDays);
    }

    /** @var Grafik[]|Doctrine_Collection $data */
    $data = $query->execute();

    if (!sizeof($data))
    {
      return array();
    }

    $resultArray = array();

    switch (ucfirst($model))
    {
      case 'Grafik':
        $resultArray = $data->toKeyValueArray('day', 'itself');
        break;
      case 'GrafikTime':

        foreach ($data as $record)
        {
          $resultArray[$record->getDay()][] = $record;
        }

        break;
    }

    if ($withEmpty)
    {
      foreach ($workDays as $day)
      {
        if (!isset($resultArray[$day]))
        {
          $resultArray[$day] = array();
        }
      }

      if (sizeof($resultArray))
      {
        ksort($resultArray);
      }
    }

    return $resultArray;
  }
  
  public function toEndOfTheMonth($from_day = null, $to_day = null)
  {
    $year = $this->getYear();
    $month = $this->getMonth();
    $day = $from_day ? $from_day : $this->getDay();
    $department_id = $this->getDepartmentId();
    $department_people_id = $this->getDepartmentPeopleId();
    $department_people_replacement_id = $this->getDepartmentPeopleReplacementId();
    /*$from_time = $this->getFromTime();
    $to_time = $this->getToTime();*/
    $is_sick = $this->getIsSick();
    $is_skip = $this->getIsSkip();
    $is_fired = $this->getIsFired();
    $is_vacation = $this->getIsVacation();
    
    $days_count = $to_day ? $to_day : self::getDaysInMonth($year, $month);

    $grafikTimes = Grafik::getGrafikTimes($this->toArray());

    $salaryInfo = Salary::getMonthInfo($year, $month);
    $holidays = $salaryInfo ? $salaryInfo->getAllWeekends() : array();
      
    for($i = $day; $i <= $days_count; $i++)
    {
      if (Grafik::isWeekend($year, $month, $i, $holidays))
      {
        continue;
      }

      $this->setGrafikTimes($i, $grafikTimes);
      
      $grafik = Doctrine::getTable('Grafik')
        ->createQuery('g')
        ->where('g.year = ?', $year)
        ->addWhere('g.month =?', $month)
        ->addWhere('g.day =?', $i)
        ->addWhere('g.department_id =?', $department_id)
        ->addWhere('g.department_people_id =?', $department_people_id)
        ->addWhere('g.department_people_replacement_id =?', $department_people_replacement_id)
        ->fetchOne();
        
      if (!$grafik)
      {
        $grafik = new Grafik();
        $grafik->setYear($year);
        $grafik->setMonth($month);
        $grafik->setDay($i);
        $grafik->setDepartmentId($department_id);
        $grafik->setDepartmentPeopleId($department_people_id);
        $grafik->setDepartmentPeopleReplacementId($department_people_replacement_id);
      }
      
      /*$grafik->setFromTime($from_time);
      $grafik->setToTime($to_time);*/
      $grafik->setIsSick($is_sick);
      $grafik->setIsSkip($is_skip);
      $grafik->setIsFired($is_fired);
      $grafik->setIsVacation($is_vacation);
      
      //$diff = (strtotime($to_time) - strtotime($from_time))/3600;
    
      //$grafik->setTotal($diff);
      
      $grafik->save();

      $grafik->recount();
    }
  }

  /**
   * set grafik time for copy to end of the mont
   * @param int $day dat ti set
   * @param GrafikTimeCollection $grafikTimes
   */
  public function setGrafikTimes($day, $grafikTimes)
  {
    $params = $this->toArray();
    $params['day'] = $day;

    $grafikTimesToDelete = Grafik::getGrafikTimes($params);
    if (sizeof($grafikTimesToDelete))
    {
      $grafikTimesToDelete->delete();
    }

    foreach ($grafikTimes as $grafikTime)
    {
      $newGrafikTime = $grafikTime->copy();

      $newGrafikTime->setDay($day);

      $newGrafikTime->save();

      $newGrafikTime->recount();
    }
  }

  public function isPersonWorkedThisDay()
  {
    $year = $this->getYear();
    $month = $this->getMonth();
    $day = $this->getDay();
    
    $date = new DateTime();
    $date->setDate($year, $month, $day);
    $date->format('U');
    
    if (in_array($date->format('D'), array('Sun', 'Sat')))
    {
      return false;
    }
    
    if ($this->personDoesntWork())
    {
      return false;
    }
    
    return $day;
  }
  
  public function personDoesntWork()
  {
    $is_sick = $this->getIsSick();
    $is_skip = $this->getIsSkip();
    $is_fired = $this->getIsFired();
    $is_vacation = $this->getIsVacation();
    
    return $is_sick || $is_skip || $is_fired || $is_vacation;
  }
                                                      
  static public function isWeekend($year, $month, $day, $holidays = array())
  {
    $date = new DateTime();
    $date->setDate($year, $month, $day);
    $date->format('U');

    if (in_array($day, $holidays))
    {
      return true;
    }

    return false;
  }
  
  static public function getFirstWorkDay($year, $month, $holidays = array())
  {
    $days_count = self::getDaysInMonth($year, $month);

    if (sizeof($holidays))
    {
      /** @var Salary $salaryInfo*/
      $salaryInfo = Salary::getMonthInfo($year, $month);

      $holidays = $salaryInfo->getAllWeekends();
    }

    for($day = 1; $day <= $days_count; $day++)
    {
      if (!Grafik::isWeekend($year, $month, $day, $holidays))
      {
        return $day;
      }
    }
    
    return 1;
  }
  
  static public function getDaysInMonth($year, $month)
  {
    return GlobalFunctions::getDaysInTheMonth($year, $month);
  }

  /**
   * get total day hours
   * @param Grafik[] $grafiks
   * @return int
   */
  /*static public function ($grafiks)
  {
    $total = 0;

    foreach ($grafiks as $grafik)
    {
      $total += $grafik->getResult()
    }
  }*/


  static public function findOrCreateGrafik($params)
  {
    $grafik = self::findOne($params);

    if (!$grafik)
    {
      $grafik = new Grafik();
      $grafik->setYear($params['year']);
      $grafik->setMonth($params['month']);
      $grafik->setDay($params['day']);
      $grafik->setDepartmentId($params['department_id']);
      $grafik->setDepartmentPeopleId($params['department_people_id']);
      $grafik->setDepartmentPeopleReplacementId($params['department_people_replacement_id']);
      $grafik->save();
    }

    return $grafik;
  }

  static public function findOne($params)
  {
    $grafik = Doctrine::getTable('Grafik')
      ->createQuery('g')
      ->addWhere('year = ?', $params['year'])
      ->addWhere('month = ?', $params['month'])
      ->addWhere('day = ?', $params['day'])
      ->addWhere('department_id = ?', $params['department_id'])
      ->addWhere('department_people_id = ?', $params['department_people_id'])
      ->addWhere('department_people_replacement_id = ?', $params['department_people_replacement_id'])
      ->fetchOne();

    return $grafik;
  }

  public function recount()
  {
    $params = $this->toArray();

    $total = 0;
    $totalDay = 0;
    $totalEvening = 0;
    $totalNight = 0;

    $grafikTimes = Grafik::getGrafikTimes($params);

    foreach ($grafikTimes as $grafikTime)
    {
      $total += $grafikTime->getResult();
      $totalDay += $grafikTime->getTotalDay();
      $totalEvening += $grafikTime->getTotalEvening();
      $totalNight += $grafikTime->getTotalNight();

    }

    $this->setTotal($total);
    $this->setTotalDay($totalDay);
    $this->setTotalEvening($totalEvening);
    $this->setTotalNight($totalNight);
    $this->save();
  }

  static public function getGrafikTimes($params, $id = null)
  {
    $query = Doctrine::getTable('GrafikTime')
      ->createQuery('g')
      ->addWhere('year = ?', $params['year'])
      ->addWhere('month = ?', $params['month'])
      ->addWhere('day = ?', $params['day'])
      ->addWhere('department_id = ?', $params['department_id'])
      ->addWhere('department_people_id = ?', $params['department_people_id'])
      ->addWhere('department_people_replacement_id = ?', $params['department_people_replacement_id']);

    //if not new current record dont use to validate
    if ($id)
    {
      $query
        ->addWhere('id <> ? ', $id);
    }

    $grafikTimes = $query->execute();

    return $grafikTimes;
  }

  static public function copyWorkingDay($fromParams, $toParams)
  {
    //copy GragikInfo
    $grafikTimePrev = Grafik::getGrafikTimes($fromParams);

    //delete next grafikTimes

    $grafikTimeNext = Grafik::getGrafikTimes($toParams);

    if (sizeof($grafikTimeNext))
    {
      $grafikTimeNext->delete();
    }

    //copy to next month
    foreach ($grafikTimePrev as $grafikTime)
    {
      $grafikTimeNew = $grafikTime->copy();
      $grafikTimeNew->setMonth($toParams['month']);
      $grafikTimeNew->setDepartmentPeopleId($toParams['department_people_id']);
      $grafikTimeNew->setDay($toParams['day']);
      $grafikTimeNew->save();
      $grafikTimeNew->recount();
    }

    //copy Grafik
    $grafik = Grafik::findOne($fromParams);
    if (!$grafik)
    {
      return;
    }

    $is_sick = $grafik->getIsSick();
    $is_skip = $grafik->getIsSkip();
    $is_fired = $grafik->getIsFired();
    $is_vacation = $grafik->getIsVacation();

    $grafikNext = Grafik::findOrCreateGrafik($toParams);

    $grafikNext->setIsSick($is_sick);
    $grafikNext->setIsSkip($is_skip);
    $grafikNext->setIsFired($is_fired);
    $grafikNext->setIsVacation($is_vacation);

    $grafikNext->save();

    $grafikNext->recount();
  }

  /**
   * merge 2 arrays of working days of different month
   * for coping to next month Grafik & GrafikInfo data
   */
  static public function mergeWorkingDays($prWorkingDays, $nextWorkingDays)
  {
    $mergeWorkingDays = array();

    foreach ($prWorkingDays as $key => $day)
    {
      if (!isset($nextWorkingDays[$key]))
      {
        break;
      }

      $mergeWorkingDays[$day] = $nextWorkingDays[$key];
    }

    return $mergeWorkingDays;
  }

  static public function getWorkingDaysArray($params)
  {
    $workingDays = array();
    $salaryInfo = Salary::getMonthInfo($params['year'], $params['month']);
    $weekends = $salaryInfo ? explode(',', $salaryInfo->getWeekends()) : array();

    $daysCount = date('t', mktime(0, 0, 0, $params['month'], 1, $params['year']));

    for($day = 1; $day <= $daysCount; $day++)
    {
      $date = new DateTime();
      $date->setDate($params['year'], $params['month'], $day);
      $date->format('U');
      $isWeekend = false;

      if (in_array($day, $weekends) || in_array($date->format('D'), array('Sun', 'Sat')))
      {
        $isWeekend = true;
        continue;
      }

      //this is working day! id weekend => continue
      $workingDays[] = $day;
    }

    return $workingDays;
  }

  /**
   * Generate objectId for queue
   *
   * @param mixed[] $params
   * @return string
   */
  static public function QueueGenerateId($params)
  {
    return $params['departmentId'].$params['year'].$params['month'];
  }

  /**
   * Generate objectId for queue copyAll
   *
   * @param mixed[] $params
   * @return string
   */
  static public function QueueGenerateCopyAllId($params)
  {
    return $params['userId'].$params['year'].$params['month'];
  }

  /**
   * Generate objectId for queue ExportExcelAll
   *
   * @param mixed[] $params
   * @return string
   */
  static public function QueueGenerateExportExcelAllId($params)
  {
    return $params['userId'].$params['year'].$params['month'];
  }

  /**
   * Proceed queue
   *
   * @param mixed $params
   * @param Queue $queue
   * @param queueTask $queueTask
   */
  static public function QueueProceed($params = array(), Queue $queue = null, queueTask $queueTask)
  {
    $departmentId = $params->departmentId;
    $year = $params->year;
    $month = $params->month;

    Grafik::copyToNextMonth($departmentId, $year, $month, $queue);
  }

  /**
   * Proceed queue submodel
   *
   * @param mixed $params
   * @param Queue $queue
   * @param queueTask $queueTask
   */
  static public function QueueCopyAllProceed($params = array(), Queue $queue = null, queueTask $queueTask)
  {
    $userId = $params->userId;
    $year = $params->year;
    $month = $params->month;

    $departmentsQuery = departmentsTable::getMyDepartmentsQuery($userId);

    $departments = $departmentsQuery->execute();

    // check if queue exist
    $objectModel = Queue::MODEL__GRAFIK;
    $objectSubmodel = Queue::SUBMODEL__GRAFIK_COPY_ALL;
    $params = array(
      'userId' => $userId,
      'year' => $year,
      'month' => $month
    );

    foreach ($departments as $department)
    {
      $params['departmentId'] = $department->getId();

      // $queueTask->logSection(' - Checking department: ',  $params['departmentId']);

      $queue = Queue::getByModelAndId($objectModel, $params);

      // if already in queue
      if (!$queue)
      {
        // $queueTask->logSection('  --  Adding queue with params: ', json_encode($params));
        Queue::addItem($objectModel, $params);
      }
    }
  }

  /**
   * Proceed queue submodel ExportExcelAll
   *
   * @param mixed $params
   * @param Queue $queue
   * @param queueTask $queueTask
   */
  static public function QueueExportExcelAllProceed($params = array(), Queue $queue = null, queueTask $queueTask)
  {
    $userId = $params->userId;
    $year = $params->year;
    $month = $params->month;

    $departmentIds = departmentsTable::getStuffDepartmentIdsByUserId($userId);

    if (!sizeof($departmentIds))
    {
      return;
    }

    $id = "{$year}-{$month}-{$userId}-" . time();

    $queueTask->logSection('$id : ', $id);

    $objPHPExcel = PHPExcelHelpdesk::getDepartmentExcelFor1c($departmentIds, $year, $month, $id);
    $batchExportDir = PHPExcelHelpdesk::getBatchExportDir();

    $queueTask->logSection('$batchExportDir : ', $batchExportDir);

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save($batchExportDir . '/' . $id . '.xls');
  }

  /**
   * Get Formatter data of grafik day time
   *
   * @param int $departmentId
   * @param int $departmentPeopleId
   * @param int $year
   * @param int $month
   * @param int $max Max day interval for people
   * @return mixed[]
   */
  static public function getGrafikTimeData($departmentId, $departmentPeopleId, $year, $month, &$max)
  {
    $query = Doctrine::getTable('GrafikTime')
      ->createQuery('gt')
      ->where('gt.department_id = ? ', $departmentId)
      ->addWhere('gt.department_people_id = ?', $departmentPeopleId)
      ->addWhere('gt.year = ?', $year)
      ->addWhere('gt.month = ?', $month)
      ->orderBy('gt.from_time ASC')
      ->fetchArray();

    $result = array();

    foreach ($query as $gday)
    {
      if (!isset($result[$gday['day']]))
      {
        $result[$gday['day']] = array();
      }

      $result[$gday['day']][] = array(
        'from_time' => $gday['from_time'],
        'to_time' => $gday['to_time']
      );

      if ($max < sizeof($result[$gday['day']]))
      {
        $max = sizeof($result[$gday['day']]);
      }
    }

    return $result;
  }

  /**
   * Returns grafik key
   *
   * @return string
   */
  public function getKey()
  {
    return $this->getYear() .'-'. $this->getMonth().'-'. $this->getDay() .'-'.$this->getDepartmentId().'-'.$this->getDepartmentPeopleId().'-'.$this->getDepartmentPeopleReplacementId();
  }

  /**
   * Returns result in 1C format
   *
   * return string
   */
  public function getResultFor1C()
  {
    $i18n = sfContext::getInstance()->getI18N();

    $res = '';

    $dayHours = $this->getTotalDay();
    $eveningHours = $this->getTotalEvening();
    $nightHours = $this->getTotalNight();

    if ($dayHours)
    {
      $res .= $i18n->__('1c day hours %hours%', array('%hours%' => $dayHours)) . "\n";
    }

    if ($eveningHours)
    {
      $res .= $i18n->__('1c evening hours %hours%', array('%hours%' => $eveningHours)) . "\n";
    }

    if ($nightHours)
    {
      $res .= $i18n->__('1c night hours %hours%', array('%hours%' => $nightHours));
    }


    if ($this->getIsSick())
    {
      $res = 'sick1c';
    }

    if ($this->getIsSkip())
    {
      $res = 'skip1c';
    }

    if ($this->getIsFired())
    {
      $res = 'fired1c';
    }

    if ($this->getIsVacation())
    {
      $res = 'vacation1c';
    }

    return $i18n->__($res);
  }

  /**
   * Returns self instance
   *
   * @return Grafik
   */
  public function getItself()
  {
    return $this;
  }

  /**
   * Returns work days in the month
   *
   * @param int $year
   * @param int $month
   *
   * @return int[]
   */
  public static function getWorkDaysInTheMonth($year, $month)
  {
    $daysCount = GlobalFunctions::getDaysInTheMonth($year, $month);

    $salaryInfo = Salary::getMonthInfo($year, $month);

    $weekendsAll = $salaryInfo->getAllWeekends();

    $result = array();

    for ($i = 1; $i <= $daysCount; $i++)
    {
      if (in_array($i, $weekendsAll))
      {
        continue;
      }

      $result[] = $i;
    }

    return $result;
  }
}