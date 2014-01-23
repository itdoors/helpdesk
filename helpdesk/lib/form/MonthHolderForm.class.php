<?php

class MonthHolderForm extends sfForm
{
  public function configure()
  {
    $departmentId = $this->getOption('department_id');

    $year = $this->getOption('year') ? $this->getOption('year') : date('Y');
    $month = $this->getOption('month') ? $this->getOption('month') : date('n');
    $day = 1;

    $yearSession = GlobalFunctions::getSessionVariable('year', GlobalFunctions::SESSION_NAMESACE__GRAFIK_ENTITY . $departmentId);
    $monthSession = GlobalFunctions::getSessionVariable('month', GlobalFunctions::SESSION_NAMESACE__GRAFIK_ENTITY . $departmentId);

    $year = $yearSession ? $yearSession : $year;
    $month = $monthSession ? $monthSession : $month;

    $date = new DateTime();
    $date->setDate($year, $month, $day);
    
    $years = $this->getYears();
    $months = $this->getMonths();
    
    //$this->addOption('years', array_combine($years, $years));
    
    $this->setWidget('date', new sfWidgetFormI18nDate(
        array(
          'culture' => 'ru',
          'format' => '%year% %month%',
          'years' => array_combine($years, $years),
          'months' => $months,
          'can_be_empty' => false
        )
      )
    );
    
    $this->setDefault('date', $date->getTimestamp());
    
    $this->widgetSchema->setNameFormat('grafik[%s]');
  }
  
  protected function getYears()
  {
    $departmentId = $this->getOption('department_id') ? $this->getOption('department_id') :0;
    
    if (!$departmentId)
    {
      return range(date('Y') - 5, date('Y'));
    }
    
    /*$years = Doctrine::getTable('DepartmentPeopleMonthInfo')
      ->createQuery('dpmi')
      ->select('DISTINCT dpmi.year as year')
      ->leftJoin('dpmi.DepartmentPeople dp')
      ->where('dp.department_id =?', $department_id)
      ->fetchArray();*/

    $conn = Doctrine_Manager::getInstance()->connection();

    // @todo people ids must count from DepartmentPeopleMonthInfo
    $query = "
      SELECT
        DISTINCT(dpmi.year) AS year
      FROM
        department_people_month_info dpmi
     LEFT JOIN department_people dp ON dpmi.department_people_id = dp.id
     WHERE
       dp.department_id =:department_id";

    $stmt = $conn->prepare($query);

    $params = array(
      ':department_id' => $departmentId
    );

    $stmt->execute($params);

    $years = $stmt->fetchAll();
      
    $return = array();
    
    if (sizeof($years))
    {
      foreach($years as $year) 
      {
        $return[] = $year['year'];
      }
    }
    
    $return[] = date('Y');
    
    return $return;  
  }
  
  protected function getMonths()
  {
    $culture = isset($options['culture']) ? $options['culture'] : 'ru';
    
    $department_id = $this->getOption('department_id') ? $this->getOption('department_id') :0;
    
    $worked_month = Grafik::getWorkedMonthsIndex($department_id);
    
    /*foreach ($worked_month as $key => $wm)
    {
      if ($wm > date('n')+1)
      {
        unset($worked_month[$key]);
      }
    }*/
    
    $months = array_combine(range(1, 12), sfDateTimeFormatInfo::getInstance($culture)->getMonthNames());
    
    foreach($months as $key => $value)
    {
      if (!in_array($key, $worked_month))
      {
        unset($months[$key]);
      }
    }
    return $months;
  }
}
