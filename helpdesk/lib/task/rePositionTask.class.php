<?php

class rePositionTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    /*$this->addArguments(array(
      new sfCommandArgument('offset', sfCommandArgument::OPTIONAL, 'Offset', 0),
    ));*/

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'rePosition';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [rePosition|INFO] task does things.
Call it with:

  [php symfony rePosition|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $dbManager = new sfDatabaseManager($this->configuration);
    $connection = Doctrine_Manager::connection();

    set_time_limit(0);

    ini_set('memory_limit', '768M');

    $departmentPeople = Doctrine::getTable('DepartmentPeople')
      ->createQuery('dp')
      ->where('dp.position_string IS NOT NULL')
      ->execute();

    $this->logSection('Start with total: ', sizeof($departmentPeople));

    $positionList = DepartmentPeoplePosition::getList();

    $i = 0;

    foreach ($departmentPeople as $people)
    {
      $rePositionList = DepartmentPeoplePosition::$rePositionList;

      $positionString = $people->getPositionString();

      if (isset($rePositionList[$positionString]) && $rePositionList[$positionString])
      {
        $positionId = $rePositionList[$positionString];

        $people->rePosition();

        $i++;

        $logString = $i . '. ' . $people->getName() . ': ' . $people->getPositionString() . ' --->>> ' . $positionList[$positionId];

        $this->log($logString);


      }
    }

    $this->log('Finish! with '. $i .' results');
  }
}
