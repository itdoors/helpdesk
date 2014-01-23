<?php

/**
 * DepartmentPeopleMonthInfo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    helpdesk
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class DepartmentPeopleMonthInfo extends BaseDepartmentPeopleMonthInfo
{
  static public $lookup;

  public function getItself()
  {
    return $this;
  }

  public function getSurchargeFloat()
  {
    $surcharge = $this->getSurcharge();

    return $surcharge ? sprintf("%0.2f", $surcharge) : '';
  }

  public function getFineFloat()
  {
    $fine = $this->getFine();

    return $fine ? sprintf("%0.2f", $fine) : '';
  }

  public function getBonusFloat()
  {
    $bonus = $this->getBonus();

    return $bonus ? sprintf("%0.2f", $bonus) : '';
  }

  public function getEmploymentTypeChar()
  {
    $employment_type_lukey = $this->getEmploymentTypeLukey();

    $char = '';

    switch ($employment_type_lukey)
    {
      case lookup::EMPLOYMENT_TYPE_A:
        $char = 'A';
        break;
      case lookup::EMPLOYMENT_TYPE_B:
        $char = 'B';
        break;
      case lookup::EMPLOYMENT_TYPE_C:
        $char = 'C';
        break;
      case lookup::EMPLOYMENT_TYPE_D:
        $char = 'D';
        break;
      case lookup::EMPLOYMENT_TYPE_E:
        $char = 'E';
        break;
    }

    return $char;
  }

  public function getEmploymentTypeLukey()
  {
    $lookup = lookup::getDataLukey();

    $employment_type_lukey = isset($lookup[$this->getEmploymentTypeId()]) ? $lookup[$this->getEmploymentTypeId()] : '';

    return $employment_type_lukey;
  }

  public function getTypeLukey()
  {
    $lookup = lookup::getDataLukey();

    $type_lukey = isset($lookup[$this->getTypeId()]) ? $lookup[$this->getTypeId()] : '';

    return $type_lukey;
  }

  public function getTypeChar()
  {
    $type_lukey = $this->getTypeLukey();

    $char = '';

    switch ($type_lukey)
    {
      case lookup::DEPARTMENT_PEOPLE_TYPE:
        $char = 'З';
        break;
      case lookup::DEPARTMENT_PEOPLE_TYPE_PERMANENT:
        $char = 'П';
        break;
    }

    return $char;
  }

  public function copyGrafikFromPreviousMonth($personId, $departmentId, $previous_year, $previous_month, $year, $month)
  {
    $paramsPrev = array(
      'year' => $previous_year,
      'month' => $previous_month,
      'department_id' => $departmentId,
      'department_people_id' => $personId
    );

    $paramsNext = $paramsPrev;
    $paramsNext['month'] = $month;
    $paramsNext['year'] = $year;
    $paramsNext['department_people_id'] = $personId;

    $prWorkingDays = Grafik::getWorkingDaysArray($paramsPrev);
    $nextWorkingDays = Grafik::getWorkingDaysArray($paramsNext);
    $mergeWorkingDays = Grafik::mergeWorkingDays($prWorkingDays, $nextWorkingDays);

    foreach ($mergeWorkingDays as $prevDay => $nextDay)
    {
      $fromParams = $paramsPrev;
      $fromParams['day'] = $prevDay;

      $toParams = $paramsNext;
      $toParams['day'] = $nextDay;

      Grafik::copyWorkingDay($fromParams , $toParams);
    }
  }

  public function delete(Doctrine_Connection $conn = null)
  {
    //Grafik::deletePeopleInfo($this->getYear(), $this->getMonth(), $this->getDepartmentId(), $this->getDepartmentPeopleId());

    // Delete grafik time info
    $conn = Doctrine_Manager::getInstance()->connection();

    $params = array(
      ':year' => $this->getYear(),
      ':month' => $this->getMonth(),
      ':department_people_id' => $this->getDepartmentPeopleId(),
      ':department_people_replacement_id' => $this->getDepartmentPeopleReplacementId(),
      ':department_id' => $this->getDepartmentId(),
    );

    // @todo people ids must count from DepartmentPeopleMonthInfo
    $query = "
    delete
      from
        grafik_time
      where
        year = :year and
        month = :month and
        department_people_id = :department_people_id and
        department_people_replacement_id = :department_people_replacement_id and
        department_id = :department_id";

    $stmt = $conn->prepare($query);

    $stmt->execute($params);

    $query = "
    delete
      from
        grafik
      where
        year = :year and
        month = :month and
        department_people_id = :department_people_id and
        department_people_replacement_id = :department_people_replacement_id and
        department_id = :department_id";

    $stmt = $conn->prepare($query);

    $params = array(
      ':year' => $this->getYear(),
      ':month' => $this->getMonth(),
      ':department_people_id' => $this->getDepartmentPeopleId(),
      ':department_people_replacement_id' => $this->getDepartmentPeopleReplacementId(),
      ':department_id' => $this->getDepartmentId(),
    );

    $stmt->execute($params);

    $query = "
    delete
      from
        department_people_month_info
      where
        year = :year and
        month = :month and
        department_people_id = :department_people_id and
        department_people_replacement_id = :department_people_replacement_id";

    $stmt = $conn->prepare($query);

    $params = array(
      ':year' => $this->getYear(),
      ':month' => $this->getMonth(),
      ':department_people_id' => $this->getDepartmentPeopleId(),
      ':department_people_replacement_id' => $this->getDepartmentPeopleReplacementId(),
    );

    $stmt->execute($params);

    // parent::delete($conn);
  }

  public function getDepartmentId()
  {
    $person = $this->getDepartmentPeople();

    return $person ? $person->getDepartmentId() : null;
  }

  public function getEmploymentTypeCharById($id)
  {
    $emloyment_type_lukey = $this->getEmploymentTypeLukeyById($id);

    $char = '';

    switch ($emloyment_type_lukey)
    {
      case lookup::EMPLOYMENT_TYPE_A:
        $char = 'A';
        break;
      case lookup::EMPLOYMENT_TYPE_B:
        $char = 'B';
        break;
      case lookup::EMPLOYMENT_TYPE_C:
        $char = 'C';
        break;
      case lookup::EMPLOYMENT_TYPE_D:
        $char = 'D';
        break;
      case lookup::EMPLOYMENT_TYPE_E:
        $char = 'E';
        break;
    }

    return $char;
  }

  public function getEmploymentTypeLukeyById($id)
  {
    $lookup = lookup::getDataLukey();

    $emloyment_type_lukey = isset($lookup[$id]) ? $lookup[$id] : '';

    return $emloyment_type_lukey;
  }

  public function getSurchargeTypeChar()
  {
    return $this->getEmploymentTypeCharById($this->getSurchargeTypeId());
  }

  public function getBonusTypeChar()
  {
    return $this->getEmploymentTypeCharById($this->getBonusTypeId());
  }

  public function getFineTypeChar()
  {
    return $this->getEmploymentTypeCharById($this->getFineTypeId());
  }

  public function getSurchargeString()
  {
    return $this->getSurchargeFloat()  ? $this->getSurchargeFloat() . '(' . $this->getSurchargeTypeChar(). ')' : '';
  }

  public function getBonusString()
  {
    return $this->getBonusFloat() ? $this->getBonusFloat() . '(' . $this->getBonusTypeChar(). ')' : '';
  }

  public function getFineString()
  {
    return $this->getFineFloat() ? $this->getFineFloat() . '(' . $this->getFineTypeChar(). ')' : '';
  }
}
