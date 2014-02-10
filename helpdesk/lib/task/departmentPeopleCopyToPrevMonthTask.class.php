<?php

class departmentCopyToPrevMonth extends sfBaseTask
{
  protected function configure()
  {
    // add your own arguments here
    $this->addArguments(array(
      new sfCommandArgument('department_id', sfCommandArgument::REQUIRED, 'DepartmentId'),
      new sfCommandArgument('year', sfCommandArgument::REQUIRED, 'Year'),
      new sfCommandArgument('month', sfCommandArgument::REQUIRED, 'Month'),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'dispatcher'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'departmentPeople';
    $this->name             = 'copyToPrevMonth';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [departmentPeople:copyToPrevMonth|INFO] task does things.
Call it with:

  [php symfony departmentPeople:copyToPrevMonth|INFO]
EOF;
  }

  protected $percent;
  protected $force;

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

    $this->logSection('Start: ','copyToPreviousMonth');

    $department_id = $arguments['department_id'];
    $year = $arguments['year'];
    $month = $arguments['month'];

    Grafik::copyToPrevMonth($department_id, $year, $month);

    $this->logSection('End: ','copyToPreviousMonth end');
  }
}