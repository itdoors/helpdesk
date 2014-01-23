<?php

class recountCreateHandlingDateTask extends sfBaseTask
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
    $this->name             = 'recountCreateHandlingDate';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [recountCreateHandlingDate|INFO] task does things.
Call it with:

  [php symfony recountCreateHandlingDate|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $dbManager = new sfDatabaseManager($this->configuration);
    $connection = Doctrine_Manager::connection();

    set_time_limit(0);

    ini_set('memory_limit', '768M');

    $handlings = Doctrine::getTable('Handling')
      ->createQuery('h')
      ->execute();

    $this->logSection('Start with total: ', sizeof($handlings));

    $i = 0;

    foreach ($handlings as $handling)
    {
      if (!$handling->getCreatedate())
      {
        $i++;
        $handling->recountCreatedate();
        $this->log($handling->getId(). ' - ' . $handling->getCreatedate());
      }
    }

    $this->log('Finish! with '. $i .' results');
  }
}
