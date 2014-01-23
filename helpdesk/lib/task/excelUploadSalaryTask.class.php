<?php

class excelUploadSalaryTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'dispatcher'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'excel';
    $this->name             = 'upload-salary';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [excel:upload-salary|INFO] task does things.
Call it with:

  [php symfony excel:upload-salary|INFO]
EOF;
  }
  protected function execute($arguments = array(), $options = array())
  {
    // configure
    require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');
    $configuration = ProjectConfiguration::getApplicationConfiguration($options['application'], $options['env'], $options['env'] == 'dev');
    sfContext::createInstance($configuration);

    $dbManager = new sfDatabaseManager($this->configuration);
    $connection = Doctrine_Manager::connection();

    set_time_limit(0);

    ini_set('memory_limit', '768M');

    $this->logSection('Start: ','excel upload salary');

    $batchImportSalaryDir = PHPExcelHelpdesk::getBatchImportSalaryDir();

    $batchImportSalaryResultDir = PHPExcelHelpdesk::getBatchImportSalaryResultDir();

    $files = scandir($batchImportSalaryDir);

    $this->logSection('All files: ', var_export($files));

    foreach ($files as $file)
    {
      if (PHPExcelHelpdesk::isExcelFile($file) && !PHPExcelHelpdesk::isExcelFileProcessed($file))
      {
        $this->logSection('  Importing file: ',$file);

        /** @var PHPExcel $objUploaded */
        $objUploaded = PHPExcelHelpdesk::uploadExcelSalary($batchImportSalaryDir . DIRECTORY_SEPARATOR . $file, $this);

        $resultFileName = $batchImportSalaryDir . DIRECTORY_SEPARATOR . PHPExcelHelpdesk::PROCESSED_PREFIX . '-' . $file ;
        $objWriter = new PHPExcel_Writer_Excel5($objUploaded);
        $objWriter->save($resultFileName);

        unlink($batchImportSalaryDir . DIRECTORY_SEPARATOR . $file);
      }
    }

    $this->logSection('End: ','files uploaded');
  }
}