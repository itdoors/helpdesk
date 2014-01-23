<?php

/**
 * Class PHPExcelHelpdesk
 *
 * custom methods for work with PHPExcel
 */
class PHPExcelHelpdesk
{
  public static $excelRows = array(
    '1' => 'A',
    '2' => 'B',
    '3' => 'C',
    '4' => 'D',
    '5' => 'E',
    '6' => 'F',
    '7' => 'G',
    '8' => 'H',
    '9' => 'I',
    '10' => 'J',
    '11' => 'K',
    '12' => 'L',
    '13' => 'M',
    '14' => 'N',
    '15' => 'O',
    '16' => 'P',
    '17' => 'Q',
    '18' => 'R',
    '19' => 'S',
    '20' => 'T',
    '21' => 'U',
    '22' => 'V',
    '23' => 'W',
    '24' => 'X',
    '25' => 'Y',
    '26' => 'Z',
    '27' => 'AA',
    '28' => 'AB',
    '29' => 'AC',
    '30' => 'AD',
    '31' => 'AE',
    '32' => 'AF',
    '33' => 'AG',
    '34' => 'AH',
    '35' => 'AI',
    '36' => 'AJ',
    '37' => 'AK',
  );

  public static $excelFormats = array('xls', 'xlsx');

  const PROCESSED_PREFIX = 'processed';

  protected static $year;
  protected static $month;

  public static $batchExportDir = '/excel';
  public static $batchImportDir = '/excel/import';
  public static $batchImportResultDir = '/excel/import/result';
  public static $batchImportSalaryDir = '/excel/import/salary';
  public static $batchImportSalaryResultDir = '/excel/import/salary/result';

  private static $password = 'sdMOxc23qa';

  private static $printStartColIndex = 1;
  private static $printStartRowIndex = 9;
  private static $printStartMonthIndex = 7;

  protected static $printCurrentRowIndex;

  protected static $all_total = 0;
  protected static $all_total_days = 0;
  protected static $all_total_evening = 0;
  protected static $all_total_night = 0;
  protected static $all_total_holidays = 0;
  protected static $all_total_surcharge = 0;
  protected static $all_total_bonus = 0;
  protected static $all_total_fine = 0;
  protected static $all_total_oklad = 0;
  protected static $all_total_costs = 0;

  protected static $borderRows = array();

  // Upload vars
  protected static $uploadStartRow = 2;
  protected static $uploadMonthCell = 'C1';
  protected static $uploadYearCell = 'B1';

  protected static $uploadDepartmentPeopleNumberColIndex = 0;
  protected static $uploadDepartmentPeopleLastNameColIndex = 2;
  protected static $uploadDepartmentPeopleFirstNameColIndex = 3;
  protected static $uploadDepartmentPeopleMiddleNameColIndex = 4;
  protected static $uploadDepartmentPeopleCodeColIndex = 5;
  protected static $uploadDepartmentPeopleDRFOColIndex = 6;
  protected static $uploadDepartmentPeopleBirthdayColIndex = 7;


  protected static $uploadDepartmentMpkColIndex = 10;
  protected static $uploadDepartmentPeopleAddressColIndex = 11;
  protected static $uploadDepartmentPeoplePhoneColIndex = 12;
  protected static $uploadDepartmentPeopleWorkPhoneColIndex = 13;

  protected static $uploadSalaryStartRow = 4;
  protected static $uploadSalaryColIndex = 10;
  protected static $uploadSalaryRowIndex = 3;
  protected static $uploadSalaryMonthCell = 'D1';
  protected static $uploadSalaryYearCell = 'E1';
  protected static $uploadSalaryMpkColIndex = 3;
  protected static $uploadSalaryStaffColIndex = 3;
  protected static $uploadSalaryNumberColIndex = 4;
  protected static $uploadSalaryIdColIndex = 5;

  const COLOR_RED_INDEX = 'red';
  const COLOR_GREEN_INDEX = 'green';
  const COLOR_BLUE_INDEX = 'blue';
  const COLOR_EXTRA_RED_INDEX = 'extra_red';

  public static $cellColors = array(
    self::COLOR_RED_INDEX => array(
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array('rgb' => 'FA4182')
    ),
    self::COLOR_GREEN_INDEX => array(
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array('rgb' => '2BCC2B')
    ),
    self::COLOR_BLUE_INDEX => array(
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array('rgb' => '619DF2')
    ),
    self::COLOR_EXTRA_RED_INDEX => array(
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array('rgb' => 'FF0000')
    ),

  );

  /**
   * Get batchExportDir
   *
   * @return string
   */
  static public function getBatchExportDir()
  {
    return ProjectPath . self::$batchExportDir;
  }

  /**
   * Get batchImportDir
   *
   * @return string
   */
  static public function getBatchImportDir()
  {
    return ProjectPath . self::$batchImportDir;
  }

  /**
   * Get batchImportResultDir
   *
   * @return string
   */
  static public function getBatchImportResultDir()
  {
    return ProjectPath . self::$batchImportResultDir;
  }

  /**
   * Get batchImportSalaryDir
   *
   * @return string
   */
  static public function getBatchImportSalaryDir()
  {
    return ProjectPath . self::$batchImportSalaryDir;
  }

  /**
   * Get batchImportSalaryResultDir
   *
   * @return string
   */
  static public function getBatchImportSalaryResultDir()
  {
    return ProjectPath . self::$batchImportSalaryResultDir;
  }

  /**
   * Checks if current file is excel
   *
   * @param string $file
   * @return bool
   */
  public static function isExcelFile($file)
  {
    if (!$file)
    {
      return false;
    }

    if ($file[0] == '.')
    {
      return false;
    }

    $ext = pathinfo($file, PATHINFO_EXTENSION);

    if (!in_array($ext, self::$excelFormats))
    {
      return false;
    }

    return true;
  }

  /**
   * Checks if current file is processed
   *
   * @param string $file
   * @return bool
   */
  public static function isExcelFileProcessed($file)
  {
    if (strstr($file, self::PROCESSED_PREFIX))
    {
      return true;
    }

    return false;
  }

  /**
   * Generate PHPExcel object for 1c import
   *
   * @param int|int[] $departmentIds
   * @param int $year
   * @param int $month
   * @param string $id
   * @return PHPExcel $objPHPExcel
   */
  static public function getDepartmentExcelFor1c($departmentIds, $year, $month, $id = '')
  {
    require_once(PHPExcelPath.'/'.'PHPExcel.php');
    require_once(PHPExcelPath.'/'.'PHPExcel/Cell/AdvancedValueBinder.php');
    PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
    $i18n = sfContext::getInstance()->getI18N();

    /** @var Doctrine_Collection $departments */
    $departments = Doctrine::getTable('departments')
      ->createQuery('d')
      ->whereIn('d.id', $departmentIds)
      ->execute();

    $organizationIds = array();

    $daysCountIntheMonth = date('t', mktime(0, 0, 0, $month, 1, $year));;
    $daysCount = 31;

    $salaryInfo = Salary::getMonthInfo($year, $month);
    $holidays = $salaryInfo ? $salaryInfo->getAllWeekends() : array();

    $peoples = Grafik::getPeopleArrayByDepartmentIdKey($departmentIds, $year, $month);
    $grafik = Grafik::getFormattedData($year, $month, $departmentIds);

    date_default_timezone_set('Europe/Kiev');

    $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
    if (!PHPExcel_Settings::setCacheStorageMethod($cacheMethod)) {
      die($cacheMethod . " caching method is not available");
    }

    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Set document properties
    $objPHPExcel->getProperties()->setCreator("Helpdesk")
      ->setLastModifiedBy("Helpdesk")
      ->setTitle("Office 2007 XLSX Helpdesk Document")
      ->setSubject("Office 2007 XLSX Helpdesk1 Document")
      ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
      ->setKeywords("office 2007 openxml php")
      ->setCategory("Helpdesk result file");

    // Create a first sheet
    $objPHPExcel->setActiveSheetIndex(0);

    $objWorksheet = $objPHPExcel->getActiveSheet();

    /** @var sfGuardUser $manager */
    $managerFullName = GlobalFunctions::getUserFullName();

    $dayOfExport = date('j', time());

    $exportType = $dayOfExport < 10 ? 'А' : 'З';

    $id = $id ? $id : time() . "-{$year}-{$month}";

    $objWorksheet->setCellValue('A1', $id);
    $objWorksheet->setCellValue('B1', $year);
    $objWorksheet->setCellValue('C1', $month);
    $objWorksheet->setCellValue('D1', $managerFullName);
    $objWorksheet->setCellValue('E1', $exportType);

    $userId = null;

    $objWorksheet->getStyle('A1:F2')
      ->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

    $i = 10;
    $row = 3;

    $objWorksheet->setCellValue('A' . $row, "Номер строки");// 0
    $objWorksheet->setCellValue('B' . $row, "МПК");// 1
    $objWorksheet->setCellValue('C' . $row, "ДРФО");// 2
    $objWorksheet->setCellValue('D' . $row, "ФИО");// 3
    $objWorksheet->setCellValue('E' . $row, "Табельный номер");// 4
    $objWorksheet->setCellValue('F' . $row, "Код опер");// 5
    $objWorksheet->setCellValue('G' . $row, "Код 1С");// 6
    $objWorksheet->setCellValue('H' . $row, "ТТ");// 7
    $objWorksheet->setCellValue('I' . $row, "П/З");// 8
    $objWorksheet->setCellValue('J' . $row, "Итого");// 8

    $objWorksheet->getColumnDimension('B')->setAutoSize(true);
    $objWorksheet->getColumnDimension('C')->setAutoSize(true);
    $objWorksheet->getColumnDimension('D')->setAutoSize(true);
    $objWorksheet->getColumnDimension('E')->setAutoSize(true);
    $objWorksheet->getColumnDimension('F')->setAutoSize(true);
    $objWorksheet->getColumnDimension('G')->setAutoSize(true);
    $objWorksheet->getColumnDimension('H')->setAutoSize(true);
    $objWorksheet->getColumnDimension('I')->setAutoSize(true);

    for($day = 1; $day <= $daysCount; $day++)
    {
      $objWorksheet->setCellValueByColumnAndRow($i, $row, $day);
      $i++;
    }

    $row++;
    $count = 0;

    /**@var DEpartments[]|Doctrine_Collection $departments */
    foreach ($departments as $department)
    {
      $organizationId = $department->getOrganizationId();

      if (!isset($organizationIds[$organizationId]))
      {
        $organizationIds[$organizationId] = $organizationId;
      }

      if (!isset($peoples[$department->getId()]))
      {
        continue;
      }

      foreach ($peoples[$department->getId()] as $people) /** @var DepartmentPeople $people */
      {
        // DATA IN TABLE
        $count++;
        $total = '';
        $totalDay = 0;
        $totalEvening = 0;
        $totalNight = 0;
        $salaryDaysCount = 0;
        $totalAll = 0;
        $hospitalTill5 = 0;
        $hospitalAfter5 = 0;
        $vacation = 0;
        $hoursHolidays = 0;

        // Row height
        $objWorksheet->getRowDimension($row)->setRowHeight(-1);

        // 0
        $objWorksheet->setCellValueByColumnAndRow(0, $row, $count);
        // 1
        $objWorksheet->setCellValueExplicitByColumnAndRow(
          1, $row,
          $department->getMpk(),
          PHPExcel_Cell_DataType::TYPE_STRING
        );
        // 2
        $objWorksheet->setCellValueExplicitByColumnAndRow(
          2, $row,
          $people->getDrfo(),
          PHPExcel_Cell_DataType::TYPE_STRING
        );
        // 3
        $objWorksheet->setCellValueByColumnAndRow(
          3, $row,
          $people->getFullName()
        );
        // 4
        $objWorksheet->setCellValueExplicitByColumnAndRow(
          4, $row,
          $people->getNumber(),
          PHPExcel_Cell_DataType::TYPE_STRING
        );
        // 5
        $objWorksheet->setCellValueExplicitByColumnAndRow(
          5, $row,
          $people->getId(),
          PHPExcel_Cell_DataType::TYPE_STRING
        );
        // 6
        $objWorksheet->setCellValueExplicitByColumnAndRow(
          6, $row,
          $people->getPersonCode(),
          PHPExcel_Cell_DataType::TYPE_STRING
        );
        // 7
        $emplomentTypeChar = $people->getEmploymentTypeChar() ? $people->getEmploymentTypeChar() : $people->getBaseEmploymentTypeChar();
        $objWorksheet->setCellValueExplicitByColumnAndRow(
          7, $row,
          $emplomentTypeChar ,
          PHPExcel_Cell_DataType::TYPE_STRING
        );
        // 8
        $objWorksheet->setCellValueExplicitByColumnAndRow(
          8, $row,
          $people->getReplacementId() ? 'З' : 'П',
          PHPExcel_Cell_DataType::TYPE_STRING
        );

        $i = 10;

        $totalCellIndex = $i - 1;

        for($day = 1; $day <= $daysCountIntheMonth; $day++)
        {
          $isWeekend = false;

          if (in_array($day, $holidays))
          {
            $isWeekend = true;
          }

          $key = $year.'-'.$month.'-'.$day.'-'.$department->getId() .'-'.$people->getId().'-'.$people->getReplacementId();

          if (isset($grafik[$key]))
          {
            /* @var Grafik $grafikValue */
            $grafikValue = $grafik[$key];

            $result1C = $grafikValue->getResultFor1C();

            $result = $grafikValue->getTotal();

            $totalAll += floatval($result);

            if (floatval($result))
            {
              $salaryDaysCount++;
            }

            if (floatval($result) && $isWeekend)
            {
              $hoursHolidays += floatval($result);
            }
            else
            {
              $resultDay = $grafikValue->getTotalDay();
              $resultEvening = $grafikValue->getTotalEvening();
              $resultNight = $grafikValue->getTotalNight();

              $totalDay += floatval($resultDay);
              $totalEvening += floatval($resultEvening);
              $totalNight += floatval($resultNight);
            }

            //hospital$total
            if ($grafikValue->isHospital() && !$isWeekend)
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
            if ($grafikValue->isVacation())
            {
              $vacation++;
            }

            $objWorksheet->setCellValueByColumnAndRow($i, $row, $result1C);

            $objWorksheet->getStyleByColumnAndRow($i, $row)->getAlignment()->setWrapText(true);
          }

          if ($isWeekend)
          {
            self::setCellColor($objWorksheet, $i, $row, self::COLOR_RED_INDEX);
          }

          $i++;
        }

        if ($totalDay)
        {
          $total .= $i18n->__('1c day hours %hours%', array('%hours%' => $totalDay)) . "\n";
        }

        if ($totalEvening)
        {
          $total .= $i18n->__('1c evening hours %hours%', array('%hours%' => $totalEvening)) . "\n";
        }

        if ($totalNight)
        {
          $total .= $i18n->__('1c night hours %hours%', array('%hours%' => $totalNight));
        }

        $objWorksheet->setCellValueByColumnAndRow(self::$uploadSalaryColIndex + $daysCount, $row, $total);
        $objWorksheet->getStyleByColumnAndRow(self::$uploadSalaryColIndex + $daysCount, $row)->getAlignment()->setWrapText(true);

        // Surcharge
        $objWorksheet->setCellValueExplicitByColumnAndRow(
          self::$uploadSalaryColIndex + $daysCount + 1, $row,
          $people->getSurchargeString(),
          PHPExcel_Cell_DataType::TYPE_STRING
        );
        // Bonus
        $objWorksheet->setCellValueExplicitByColumnAndRow(
          self::$uploadSalaryColIndex + $daysCount + 2, $row,
          $people->getBonusString(),
          PHPExcel_Cell_DataType::TYPE_STRING
        );
        // Fine
        $objWorksheet->setCellValueExplicitByColumnAndRow(
          self::$uploadSalaryColIndex + $daysCount + 3, $row,
          $people->getFineString(),
          PHPExcel_Cell_DataType::TYPE_STRING
        );

        // Оклад
        $objWorksheet->setCellValueExplicitByColumnAndRow(
          self::$uploadSalaryColIndex + $daysCount + 4, $row,
          $people->getSalary(),
          PHPExcel_Cell_DataType::TYPE_STRING
        );


        $fullSalary = 0;

        if ($salaryDaysCount)
        {
          $fullSalary = $salaryInfo->summary($people->getEmploymentTypeLukey(), $salaryDaysCount, $hospitalTill5, $hospitalAfter5, $vacation, $people, $totalDay, $totalEvening, $totalNight, $hoursHolidays);
        }

        // Total costs
        $objWorksheet->setCellValueExplicitByColumnAndRow(
          self::$uploadSalaryColIndex + $daysCount + 5, $row,
          $fullSalary,
          PHPExcel_Cell_DataType::TYPE_STRING
        );

        $row++;
      }
    }

    $objWorksheet->setCellValueByColumnAndRow( self::$uploadSalaryColIndex + $daysCount, self::$uploadSalaryRowIndex, "Итого");
    $objWorksheet->setCellValueByColumnAndRow( self::$uploadSalaryColIndex + $daysCount + 1, self::$uploadSalaryRowIndex, "Доплата");
    $objWorksheet->setCellValueByColumnAndRow( self::$uploadSalaryColIndex + $daysCount + 2, self::$uploadSalaryRowIndex, "Премия");
    $objWorksheet->setCellValueByColumnAndRow( self::$uploadSalaryColIndex + $daysCount + 3, self::$uploadSalaryRowIndex, "Удержание");
    $objWorksheet->setCellValueByColumnAndRow( self::$uploadSalaryColIndex + $daysCount + 4, self::$uploadSalaryRowIndex, 'Оклад');
    $objWorksheet->setCellValueByColumnAndRow( self::$uploadSalaryColIndex + $daysCount + 5, self::$uploadSalaryRowIndex, 'Затраты');
    $objWorksheet->setCellValueByColumnAndRow( self::$uploadSalaryColIndex + $daysCount + 6, self::$uploadSalaryRowIndex, 'З/П');

    // set organizations string
    $organizationString = organization::getOrganizationString($organizationIds);
    $objWorksheet->setCellValue('A2', $organizationString);

    // Protection temporary disabled

    /*$objPHPExcel->setActiveSheetIndex(0);
    $objWorksheet->getProtection()->setPassword(self::$password);
    $objWorksheet->getProtection()->setSheet(true);
    $objPHPExcel->getSecurity()->setLockStructure(true);
    $objPHPExcel->getSecurity()->setLockWindows(true);

    $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
    $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'

    $objWorksheet->getStyle('A1:' . $highestColumn.$highestRow)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
    $objWorksheet->getStyle('A1:E1')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);*/

    return $objPHPExcel;
  }

  /**
   * Generate PHPExcel object for print import
   *
   * @param int|int[] $departmentIds
   * @param int $year
   * @param int $month
   * @param string $id
   * @return PHPExcel $objPHPExcel
   */
  static public function getDepartmentExcelForPrint($departmentIds, $year, $month, $id = '')
  {
    require_once(PHPExcelPath.'/'.'PHPExcel.php');
    require_once(PHPExcelPath.'/'.'PHPExcel/Cell/AdvancedValueBinder.php');
    PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
    sfContext::getInstance()->getConfiguration()->loadHelpers('Date');
    $culture = 'ru';

    $id = $id ? $id : "{$year}-{$month}-print-" . time();

    date_default_timezone_set('Europe/Kiev');

    $cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
    if (!PHPExcel_Settings::setCacheStorageMethod($cacheMethod)) {
      die($cacheMethod . " caching method is not available");
    }

    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Set document properties
    $objPHPExcel->getProperties()->setCreator("Helpdesk")
      ->setLastModifiedBy("Helpdesk")
      ->setTitle("Office 2007 XLSX Helpdesk Document")
      ->setSubject("Office 2007 XLSX Helpdesk1 Document")
      ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
      ->setKeywords("office 2007 openxml php")
      ->setCategory("Helpdesk result file");

    // Create a first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getDefaultStyle()->getFont()
      ->setName('Arial')
      ->setSize(10);

    /** @var PHPExcel_Worksheet $objWorksheet */
    $objWorksheet = $objPHPExcel->getActiveSheet();

    if (!is_array($departmentIds)) // if user exports file only for one department
    {
      $objWorksheet->setCellValue('B2', 'График работы сотрудников');

      $date = GlobalFunctions::$months[$month] . ' ' . $year;

      $objWorksheet->setCellValue('B3', $date);

      /** @var departments $department*/
      $department = Doctrine::getTable('departments')
        ->createQuery('d')
        ->leftJoin('d.Organization o')
        ->leftJoin('d.City city')
        ->where('d.id = ?', $departmentIds)
        ->fetchOne();

      /** @var organization $organization */
      $organization = $department->getOrganization();

      if ($organization)
      {
        $objWorksheet->setCellValue('B4', $organization->getName());
      }

      $objWorksheet->setCellValue('B5', $department->getAddressWithCity());

      $objWorksheet->setCellValue('B6', 'МПК : ' . $department->getMpk());

      $objWorksheet->setCellValue('B7', 'Менеджер : ' . GlobalFunctions::getUserFullName());

      $objWorksheet->getStyle('B2:B4')->getFont()->setBold(true);
    }

    $daysCount = date('t', mktime(0, 0, 0, $month, 1, $year));

    self::$printCurrentRowIndex =  self::$printStartRowIndex;

    self::generatePrintHeader($objPHPExcel, $daysCount);

    self::$printCurrentRowIndex =  self::$printStartRowIndex + 1;

    /** @var Doctrine_Collection $departments */
    $departments = Doctrine::getTable('departments')
       ->createQuery('d')
       ->whereIn('d.id', $departmentIds)
       ->execute();

    $salaryInfo = Salary::getMonthInfo($year, $month);
    $holidays = $salaryInfo ? $salaryInfo->getAllWeekends() : array();

    foreach ($departments as $department)
    {
      self::generateDepartmentPrintInfo($objPHPExcel, $department->getId(), $year, $month, $salaryInfo, $holidays);
    }

    // Total

    $allTotalColIndex = self::$printStartMonthIndex + $daysCount;

    $objWorksheet->setCellValueByColumnAndRow($allTotalColIndex, self::$printCurrentRowIndex, 'Итого');
    $allTotalColIndex++;

    $objWorksheet->setCellValueByColumnAndRow($allTotalColIndex, self::$printCurrentRowIndex, self::$all_total);
    $objWorksheet->setCellValueByColumnAndRow($allTotalColIndex+1, self::$printCurrentRowIndex, self::$all_total_surcharge);
    $objWorksheet->setCellValueByColumnAndRow($allTotalColIndex+2, self::$printCurrentRowIndex, self::$all_total_bonus);
    $objWorksheet->setCellValueByColumnAndRow($allTotalColIndex+3, self::$printCurrentRowIndex, self::$all_total_fine);
    $objWorksheet->setCellValueByColumnAndRow($allTotalColIndex+4, self::$printCurrentRowIndex, '');
    $objWorksheet->setCellValueByColumnAndRow($allTotalColIndex+5, self::$printCurrentRowIndex, self::$all_total_costs);
    self::$printCurrentRowIndex++;


    $allTotalString = '('.self::$all_total_days.'/'.self::$all_total_evening.'/'.self::$all_total_night.'/'.self::$all_total_holidays.')';
    $objWorksheet->setCellValueByColumnAndRow($allTotalColIndex, self::$printCurrentRowIndex, $allTotalString);

    $hiColumnName = $objWorksheet->getHighestColumn();
    $hiRow = $objWorksheet->getHighestRow();

    $startAlignCell = PHPExcel_Cell::stringFromColumnIndex(self::$printStartColIndex) . self::$printStartRowIndex;
    $endAlignCell = $hiColumnName . $hiRow;

    $objWorksheet->getStyle($startAlignCell . ':' . $endAlignCell)
      ->getAlignment()
      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
      ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    $endAlignCellWithoutTotal = $hiColumnName . ($hiRow - 2);

    $objWorksheet->getStyle($startAlignCell . ':' . $endAlignCellWithoutTotal)
      ->getBorders()
        ->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


    $endBorderHeaderRow = $hiColumnName . self::$printStartRowIndex;
    $objWorksheet->getStyle($startAlignCell . ':' . $endBorderHeaderRow)
      ->getBorders()
        ->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

    $objWorksheet->getStyle($startAlignCell . ':' . $endBorderHeaderRow)
      ->getFont()->setBold(true);

    foreach(self::$borderRows as $borderRow)
    {
      $endBorderRow = $hiColumnName . $borderRow;
      $objWorksheet->getStyle($startAlignCell . ':' . $endBorderRow)
        ->getBorders()
          ->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
    }

    return $objPHPExcel;
  }

  /**
   * Generates print header (months etc)
   *
   * @param PHPExcel $objPHPExcel
   * @param int $daysCount
   * @return int void
   */
  static public function generatePrintHeader(PHPExcel $objPHPExcel, $daysCount)
  {
    $i = self::$printStartColIndex;

    /** @var PHPExcel_Worksheet $objWorksheet */
    $objWorksheet = $objPHPExcel->getActiveSheet();

    $headersBeforeMonths = array
    (
      '#пп',
      'т/н',
      array('ФИО', '18'),
      array('Должность', '18'),
      '',
      '',
    );

    $headersAfterMonths = array
    (
      '',
      array('Часы', '12'),
      array('Доплата', '12'),
      array('Премия', '12'),
      array('Удержание', '12'),
      array('Оклад', '12'),
      array('Затраты', '12'),
      array('З/П', '12'),
    );

    foreach ($headersBeforeMonths as $header)
    {
      $headerName = is_array($header) ? $header[0] : $header;
      $headerWidth = is_array($header) ? $header[1] : '';

      $objWorksheet->setCellValueByColumnAndRow($i, self::$printCurrentRowIndex, $headerName);

      if ($headerWidth)
      {
        $objWorksheet->getColumnDimensionByColumn($i)->setWidth($headerWidth);
      }

      $i++;
    }

    for($day = 1; $day <= $daysCount; $day++)
    {
      $objWorksheet->setCellValueByColumnAndRow($i, self::$printCurrentRowIndex, $day);
      $objWorksheet->getColumnDimensionByColumn($i)->setWidth(12);
      $i++;
    }

    foreach ($headersAfterMonths as $header)
    {
      $headerName = is_array($header) ? $header[0] : $header;
      $headerWidth = is_array($header) ? $header[1] : '';

      $objWorksheet->setCellValueByColumnAndRow($i, self::$printCurrentRowIndex, $headerName);

      if ($headerWidth)
      {
        $objWorksheet->getColumnDimensionByColumn($i)->setWidth($headerWidth);
      }

      $i++;
    }
  }

  /**
   * Generates Department Print Info
   *
   * @param PHPExcel $objPHPExcel
   * @param int $departmentId
   * @param int $year
   * @param int $month
   * @param Salary $salaryInfo
   * @param mixed[] $holidays
   */
  static public function generateDepartmentPrintInfo(PHPExcel $objPHPExcel, $departmentId, $year, $month, $salaryInfo, $holidays)
  {
    /** @var PHPExcel_Worksheet $objWorksheet */
    $objWorksheet = $objPHPExcel->getActiveSheet();

    $peoples = Grafik::getPeople($departmentId, $year, $month);
    $grafik = Grafik::getFormattedData($year, $month, $departmentId);

    $count = 1;

    foreach ($peoples as $people) /** @var DepartmentPeople $people */
    {
      $max = self::generatePeoplePrintInfo($objPHPExcel, $departmentId, $people, $year, $month, $grafik, $salaryInfo, $holidays);
      $mergeRowIndex = self::$printCurrentRowIndex + $max;

      $i = self::$printStartColIndex;

      $objWorksheet->setCellValueByColumnAndRow($i, self::$printCurrentRowIndex, $count);
      $objWorksheet->mergeCellsByColumnAndRow($i, self::$printCurrentRowIndex, $i, $mergeRowIndex);
      $i++;

      $objWorksheet->setCellValueByColumnAndRow($i, self::$printCurrentRowIndex, $people->getNumber());
      $objWorksheet->mergeCellsByColumnAndRow($i, self::$printCurrentRowIndex, $i, $mergeRowIndex);
      $i++;

      $objWorksheet->setCellValueByColumnAndRow($i, self::$printCurrentRowIndex, $people->getName());
      $objWorksheet->mergeCellsByColumnAndRow($i, self::$printCurrentRowIndex, $i, $mergeRowIndex);
      $i++;

      $position = $people->getPosition() ? $people->getPosition()->getName() : '';
      $objWorksheet->setCellValueByColumnAndRow($i, self::$printCurrentRowIndex, $position);
      $objWorksheet->mergeCellsByColumnAndRow($i, self::$printCurrentRowIndex, $i, $mergeRowIndex);
      $i++;

      $objWorksheet->setCellValueByColumnAndRow($i, self::$printCurrentRowIndex, $people->getTypeChar());
      $objWorksheet->mergeCellsByColumnAndRow($i, self::$printCurrentRowIndex, $i, $mergeRowIndex);
      $i++;

      $objWorksheet->setCellValueByColumnAndRow($i, self::$printCurrentRowIndex, $people->getEmploymentTypeChar());
      $objWorksheet->mergeCellsByColumnAndRow($i, self::$printCurrentRowIndex, $i, $mergeRowIndex);
      $i++;

      $count++;

      self::$borderRows[] = self::$printCurrentRowIndex + $max;

      self::$printCurrentRowIndex = self::$printCurrentRowIndex + $max + 1;
    }
  }

  /**
   * Generates Department Print Info
   *
   * @param PHPExcel $objPHPExcel
   * @param int $departmentId
   * @param DepartmentPeople $people
   * @param int $year
   * @param int $month
   * @param mixed[] $grafik
   * @param Salary $salaryInfo
   * @param mixed[] $holidays
   * @return int $max Max Grafik Time Data count
   */
  static public function generatePeoplePrintInfo(PHPExcel $objPHPExcel, $departmentId, $people, $year, $month, $grafik, $salaryInfo, $holidays)
  {
    $max = 0;
    $total = 0;
    $day_hours = 0;
    $evening_hours = 0;
    $night_hours = 0;
    $salaryDaysCount = 0;
    $hospitalTill5 = 0;
    $hospitalAfter5 = 0;
    $vacation = 0;
    $fullSalary = 0;
    $hoursHolidays = 0;

    $departmentPeopleId = $people->getId();

    $daysCount = date('t', mktime(0, 0, 0, $month, 1, $year));

    $grafikData = Grafik::getGrafikTimeData($departmentId, $departmentPeopleId, $year, $month, $max);

    $totalRowIndex = self::$printCurrentRowIndex + $max;
    $totalColIndex = self::$printStartMonthIndex + $daysCount + 1;


    /** @var PHPExcel_Worksheet $objWorksheet */
    $objWorksheet = $objPHPExcel->getActiveSheet();

    $i = self::$printStartMonthIndex;

    for($day = 1; $day <= $daysCount; $day++)
    {
      $j = self::$printCurrentRowIndex;

      $is_weekend = false;

      if (in_array($day, $holidays))
      {
        $is_weekend = true;
      }

      $dayGrafikData = isset($grafikData[$day]) ? $grafikData[$day] : array();

      foreach ($dayGrafikData as $timeIntervalHolder)
      {
        $fromTime = date('H:i',strtotime($timeIntervalHolder['from_time']));
        $toTime = date('H:i',strtotime($timeIntervalHolder['to_time']));

        $timeInterval = $fromTime . ' - ' . $toTime;
        $objWorksheet->setCellValueByColumnAndRow($i, $j, $timeInterval);
        $j++;
      }

      $key = $year.'-'.$month.'-'.$day.'-'.$departmentId .'-'.$people->getId().'-'.$people->getReplacementId();

      if (isset($grafik[$key]))
      {
        $result = $grafik[$key]->getResult();

        $total += floatval($result);

        if (floatval($result))
        {
          $salaryDaysCount++;
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

        $objWorksheet->setCellValueByColumnAndRow($i, $totalRowIndex, $result);
      }

      $i++;
    }

    if ($total)
    {
      $objWorksheet->setCellValueByColumnAndRow($totalColIndex, self::$printCurrentRowIndex, $total);
      $objWorksheet->mergeCellsByColumnAndRow($totalColIndex, self::$printCurrentRowIndex, $totalColIndex, $totalRowIndex - 1);

      $objWorksheet->setCellValueByColumnAndRow($totalColIndex, $totalRowIndex, '('.$day_hours.'/'.$evening_hours.'/'.$night_hours.'/'.$hoursHolidays.')');
    }

    // Set bonus fine salary
    $objWorksheet->setCellValueByColumnAndRow($totalColIndex + 1, self::$printCurrentRowIndex, $people->getSurchargeString());
    $objWorksheet->setCellValueByColumnAndRow($totalColIndex + 2, self::$printCurrentRowIndex, $people->getBonusString());
    $objWorksheet->setCellValueByColumnAndRow($totalColIndex + 3, self::$printCurrentRowIndex, $people->getFineString());
    $objWorksheet->setCellValueByColumnAndRow($totalColIndex + 4, self::$printCurrentRowIndex, $people->getSalary());

    if ($salaryDaysCount)
    {
      $fullSalary = $salaryInfo->summary($people->getEmploymentTypeLukey(), $salaryDaysCount, $hospitalTill5, $hospitalAfter5, $vacation, $people, $day_hours, $evening_hours, $night_hours, $hoursHolidays);
      $objWorksheet->setCellValueByColumnAndRow($totalColIndex + 5, self::$printCurrentRowIndex, $fullSalary);
    }

    // Merge bonus fin costs salary
    $objWorksheet->mergeCellsByColumnAndRow($totalColIndex + 1, self::$printCurrentRowIndex, $totalColIndex + 1, $totalRowIndex);
    $objWorksheet->mergeCellsByColumnAndRow($totalColIndex + 2, self::$printCurrentRowIndex, $totalColIndex + 2, $totalRowIndex);
    $objWorksheet->mergeCellsByColumnAndRow($totalColIndex + 3, self::$printCurrentRowIndex, $totalColIndex + 3, $totalRowIndex);
    $objWorksheet->mergeCellsByColumnAndRow($totalColIndex + 4, self::$printCurrentRowIndex, $totalColIndex + 4, $totalRowIndex);
    $objWorksheet->mergeCellsByColumnAndRow($totalColIndex + 5, self::$printCurrentRowIndex, $totalColIndex + 5, $totalRowIndex);
    $objWorksheet->mergeCellsByColumnAndRow($totalColIndex + 6, self::$printCurrentRowIndex, $totalColIndex + 6, $totalRowIndex);

    self::$all_total += $total;
    self::$all_total_days += $day_hours;
    self::$all_total_evening += $evening_hours;
    self::$all_total_night += $night_hours;
    self::$all_total_holidays += $hoursHolidays;

    self::$all_total_surcharge += floatval($people->getSurcharge());
    self::$all_total_bonus += floatval($people->getBonus());
    self::$all_total_fine += floatval($people->getFine());
    self::$all_total_costs += floatval($fullSalary);
    self::$all_total_oklad = $people->getSalary();

    return $max;
  }

  /**
   * Uploads excel File. import all data to orep grafik
   *
   * @param string $file
   * @param sfBaseTask $task
   * @return PHPExcel
   */
  public static function uploadExcel($file, $task = null)
  {
    /** @var PHPExcel $objPHPExcel */
    $objPHPExcel = PHPExcel_IOFactory::load($file);

    /** @var PHPExcel_Worksheet $objWorksheet */
    $objWorksheet = $objPHPExcel->getActiveSheet();

    $mpks = array();

    $highestRow = $objWorksheet->getHighestRow();

    if ($task)
    {
      $task->logSection('Highest Row : ', $highestRow);
    }

    for($j = self::$uploadStartRow; $j <= $highestRow; $j++)
    {
      self::uploadExcelProcessPeople($objWorksheet, $j, $task);
    }

    return $objPHPExcel;
  }

  /**
   * Sets color to sell
   *
   * @param PHPExcel_Worksheet $objWorksheet
   * @param int $cellIndex
   * @param int $rowIndex
   * @param string $colorIndex
   */
  public static function setCellColor(PHPExcel_Worksheet $objWorksheet, $cellIndex, $rowIndex, $colorIndex)
  {
    $objWorksheet
      ->getStyleByColumnAndRow($cellIndex, $rowIndex)
      ->getFill()
      ->applyFromArray(self::$cellColors[$colorIndex]);
  }

  /**
   * Process people data. if people doesn't have tabel number -> add number
   *
   * @param PHPExcel_Worksheet $objWorksheet
   * @param int $currentRow
   * @param sfBaseTask $task
   * @return void
   */
  static public function uploadExcelProcessPeople(PHPExcel_Worksheet $objWorksheet, $currentRow, $task = null)
  {
    $peopleMpk = $objWorksheet->getCellByColumnAndRow(self::$uploadDepartmentMpkColIndex, $currentRow)->getValue();

    $peopleNumberValue = $objWorksheet->getCellByColumnAndRow(self::$uploadDepartmentPeopleNumberColIndex, $currentRow)->getFormattedValue();
    $peopleCodeValue = $objWorksheet->getCellByColumnAndRow(self::$uploadDepartmentPeopleCodeColIndex, $currentRow)->getFormattedValue();

    $DRFOValue = $objWorksheet->getCellByColumnAndRow(self::$uploadDepartmentPeopleDRFOColIndex, $currentRow)->getFormattedValue();
    $birthdayValue = $objWorksheet->getCellByColumnAndRow(self::$uploadDepartmentPeopleBirthdayColIndex, $currentRow)->getValue();
    $phoneValue = $objWorksheet->getCellByColumnAndRow(self::$uploadDepartmentPeoplePhoneColIndex, $currentRow)->getFormattedValue();
    $workPhoneValue = $objWorksheet->getCellByColumnAndRow(self::$uploadDepartmentPeopleWorkPhoneColIndex, $currentRow)->getFormattedValue();
    $addressValue = $objWorksheet->getCellByColumnAndRow(self::$uploadDepartmentPeopleAddressColIndex, $currentRow)->getFormattedValue();

    $phoneValue = $phoneValue ? $phoneValue : $workPhoneValue;

    if (!$peopleNumberValue)
    {
      return;
    }

    if (!$peopleMpk)
    {
      if ($task)
      {
        self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleFirstNameColIndex, $currentRow, self::COLOR_RED_INDEX);
        self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleLastNameColIndex, $currentRow, self::COLOR_RED_INDEX);
        self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleMiddleNameColIndex, $currentRow, self::COLOR_RED_INDEX);
        self::setCellColor($objWorksheet, self::$uploadDepartmentMpkColIndex, $currentRow, self::COLOR_RED_INDEX);

        $task->logSection('Department not found : ', $peopleMpk);
      }

      return;
    }

    $peopleLastNameValue = $objWorksheet->getCellByColumnAndRow(self::$uploadDepartmentPeopleLastNameColIndex, $currentRow)->getValue();
    $peopleFirstNameValue = $objWorksheet->getCellByColumnAndRow(self::$uploadDepartmentPeopleFirstNameColIndex, $currentRow)->getValue();
    $peopleMiddleNameValue = $objWorksheet->getCellByColumnAndRow(self::$uploadDepartmentPeopleMiddleNameColIndex, $currentRow)->getValue();

    $fioString = $peopleLastNameValue . ' ' . $peopleFirstNameValue . ' ' . $peopleMiddleNameValue;

    /*if ($task)
    {
      $task->logSection('Try to fetch : ',$peopleMpk . ' with intval = ' .  intval($peopleMpk));
    }*/

    $query= Doctrine::getTable('departments')
      ->createQuery('d')
      ->where('d.mpk LIKE ?', '' . intval($peopleMpk) . '%');

    $department = $query->fetchOne();

    if (!$department)
    {
      if ($task)
      {
        self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleFirstNameColIndex, $currentRow, self::COLOR_RED_INDEX);
        self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleLastNameColIndex, $currentRow, self::COLOR_RED_INDEX);
        self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleMiddleNameColIndex, $currentRow, self::COLOR_RED_INDEX);
        self::setCellColor($objWorksheet, self::$uploadDepartmentMpkColIndex, $currentRow, self::COLOR_RED_INDEX);

        $task->logSection('Department not found : ', $peopleMpk);
      }

      return;
    }

    $departmentId = $department->getId();

    /** @var DepartmentPeople $people */
    $people = Doctrine::getTable('DepartmentPeople')
      ->createQuery('dp')
      ->addWhere('dp.department_id = ? ', $departmentId)
      ->andWhere('dp.last_name = ?', $peopleLastNameValue)
      ->andWhere('dp.first_name = ?', $peopleFirstNameValue)
      ->andWhere('dp.middle_name = ?', $peopleMiddleNameValue)
      ->fetchOne();

    if (!$people && $DRFOValue)
    {
      $people = Doctrine::getTable('DepartmentPeople')
        ->createQuery('dp')
        ->addWhere('dp.department_id = ? ', $departmentId)
        ->andWhere('dp.drfo = ?', $DRFOValue)
        ->fetchOne();
    }

    if (!$people)
    {
      if ($task)
      {
        $task->logSection('  ADDING: ',  $fioString);
      }

      self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleFirstNameColIndex, $currentRow, self::COLOR_BLUE_INDEX);
      self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleLastNameColIndex, $currentRow, self::COLOR_BLUE_INDEX);
      self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleMiddleNameColIndex, $currentRow, self::COLOR_BLUE_INDEX);

      /** @var DepartmentPeople $departmentPeople */
      $departmentPeople = new DepartmentPeople();
      $departmentPeople->setFirstName($peopleFirstNameValue);
      $departmentPeople->setLastName($peopleLastNameValue);
      $departmentPeople->setMiddleName($peopleMiddleNameValue);
      $departmentPeople->setName($fioString);
      $departmentPeople->setDepartmentId($departmentId);
      $departmentPeople->setNumber($peopleNumberValue);
      $departmentPeople->setDrfo($DRFOValue);

      $departmentPeople->setPersonCode($peopleCodeValue);
      $departmentPeople->setAddress($addressValue);

      // birthday
      if ($birthdayValue)
      {
        $birthdayValue = str_replace('.', '-', $birthdayValue);
        $departmentPeople->setBirthday(date('Y-m-d', strtotime($birthdayValue)));
      }

      // phone
      if ($phoneValue)
      {
        $departmentPeople->setPhone($phoneValue);
      }

      $departmentPeople->setIsFromOneC(true);
      $departmentPeople->save();

      return;
    }

    if (!$people->getIsFromOneC())
    {
      if ($task)
      {
        self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleFirstNameColIndex, $currentRow, self::COLOR_GREEN_INDEX);
        self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleLastNameColIndex, $currentRow, self::COLOR_GREEN_INDEX);
        self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleMiddleNameColIndex, $currentRow, self::COLOR_GREEN_INDEX);

        $task->logSection('  APPROVING: ',  $fioString);
      }

      $people->setIsApproved(true);
      $people->setIsFromOneC(false);
    }

    // birthday
    if ($birthdayValue)
    {
      $birthdayValue = str_replace('.', '-', $birthdayValue);
      $people->setBirthday(date('Y-m-d', strtotime($birthdayValue)));
    }

    // phone
    if ($phoneValue)
    {
      $people->setPhone($phoneValue);
    }

    $people->setPersonCode($peopleCodeValue);
    $people->setAddress($addressValue);
    $people->setNumber($peopleNumberValue);
    $people->setDrfo($DRFOValue);
    $people->save();

    if ($task && $people->getIsFromOneC())
    {
      self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleFirstNameColIndex, $currentRow, self::COLOR_BLUE_INDEX);
      self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleLastNameColIndex, $currentRow, self::COLOR_BLUE_INDEX);
      self::setCellColor($objWorksheet, self::$uploadDepartmentPeopleMiddleNameColIndex, $currentRow, self::COLOR_BLUE_INDEX);

      $task->logSection('  NOTHING WITH: ',  $fioString);
    }
  }

  /**
   * Uploads excel File. import all data to orep grafik
   *
   * @param string $file
   * @param sfBaseTask $task
   * @return PHPExcel
   */
  public static function uploadExcelSalary($file, $task = null)
  {
    /** @var PHPExcel $objPHPExcel */
    $objPHPExcel = PHPExcel_IOFactory::load($file);

    /** @var PHPExcel_Worksheet $objWorksheet */
    $objWorksheet = $objPHPExcel->getActiveSheet();

    $year = $objWorksheet->getCell(self::$uploadYearCell)->getValue();
    $month = $objWorksheet->getCell(self::$uploadMonthCell)->getValue();

    if (!$year || !$month)
    {
      return;
    }

    self::$year = $year;
    self::$month = $month;

    $mpks = array();

    $highestColIndex = PHPExcel_Cell::columnIndexFromString($objWorksheet->getHighestColumn());
    $highestRow = $objWorksheet->getHighestRow();

    if ($task)
    {
      $task->logSection(' Highest col:', $highestColIndex);
      $task->logSection(' Highest row:', $highestRow);
    }

    for($j = self::$uploadSalaryStartRow; $j <= $highestRow; $j++)
    {
      //self::uploadExcelProcessPeople($objWorksheet, $j, $departmentIds, $task);
      if ($task)
      {
        $str = $objWorksheet->getCellByColumnAndRow(self::$uploadSalaryStaffColIndex, $j)->getValue();

        $task->logSection(' Prepering PROCESS person salary: ', $str);

        self::processPersonRealSalary($objWorksheet, $j, $highestColIndex, $task);
      }
    }

    return $objPHPExcel;
  }

  /**
   * Process person real salary
   *
   * @param PHPExcel_Worksheet $objWorksheet
   * @param int $currentRow
   * @param int $highestColIndex
   * @param sfBaseTask $task
   * @return void
   */
  public static function processPersonRealSalary($objWorksheet, $currentRow, $highestColIndex, $task)
  {
    $salaryColIndex = $highestColIndex - 1;

    $personIdValue = $objWorksheet->getCellByColumnAndRow(self::$uploadSalaryIdColIndex, $currentRow)->getValue();
    $peopleNumberValue = $objWorksheet->getCellByColumnAndRow(self::$uploadSalaryNumberColIndex, $currentRow)->getValue();
    // $peopleMpkValue = $objWorksheet->getCellByColumnAndRow(self::$uploadSalaryMpkColIndex, $currentRow)->getValue();
    $peopleRealSalaryValue = $objWorksheet->getCellByColumnAndRow($salaryColIndex, $currentRow)->getValue();

    if (!$peopleNumberValue)
    {
      if ($task)
      {
        self::setCellColor($objWorksheet, self::$uploadSalaryNumberColIndex, $currentRow, self::COLOR_EXTRA_RED_INDEX);

        $task->logSection('   Person number is empty: ', '');
      }
      //return;
    }

    if (!$peopleRealSalaryValue)
    {
      if ($task)
      {
        self::setCellColor($objWorksheet, $salaryColIndex, $currentRow, self::COLOR_EXTRA_RED_INDEX);

        $task->logSection('   Person real salary is empty: ', '');
      }
      return;
    }

    if ($task)
    {
      $task->logSection('  Real salary value: ', $peopleRealSalaryValue);
    }

    /** @var DepartmentPeople $person */
    $person = Doctrine::getTable('DepartmentPeople')
      ->createQuery('dp')
      ->where('dp.id = ?', $personIdValue)
      ->fetchOne();

    if (!$person)
    {
      if ($task)
      {
        self::setCellColor($objWorksheet, self::$uploadSalaryStaffColIndex, $currentRow, self::COLOR_EXTRA_RED_INDEX);
        $task->logSection('   Person not found: ', '');
      }
      return;
    }

    $person->setYearMonth(self::$year, self::$month);

    /** @var DepartmentPeopleMonthInfo $monthInfo */
    $monthInfo = $person->getMonthInfo();

    if (!$monthInfo)
    {
      if ($task)
      {
        $task->logSection('   Person month info not found: ', '');
      }
      return;
    }

    if ($task)
    {
      $task->logSection('   Processing real salary for: ', $person->getFullName());
    }

    $monthInfo->setRealSalary($peopleRealSalaryValue);
    $monthInfo->save();

    if ($task)
    {
      $task->logSection('   Processing real salary for: ', $person->getFullName() . ' SUCCESS');
    }
  }
}