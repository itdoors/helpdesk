<?php

class lastHandlingDateTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    $this->addArguments(array(
      new sfCommandArgument('offset', sfCommandArgument::OPTIONAL, 'Offset', 0),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'last_handling_date';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [last_handling_date|INFO] task does things.
Call it with:

  [php symfony last_handling_date|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $dbManager = new sfDatabaseManager($this->configuration);
    $connection = Doctrine_Manager::connection();

    set_time_limit(0);

    ini_set('memory_limit', '768M');

    $this->logSection('handling', '- start');

    $handlings  = Doctrine::getTable('Handling')
      ->createQuery('h')
      ->execute();

    $i = 0;

    foreach ($handlings as $handling)
    {
      $result = $handling->recountLastHandlingDate();

      if ($result)
      {
        $this->logSection('set ', $handling->getId() .' - set : '.$result);
        $i++;
      }
    }

    $this->logSection('handling', 'Success : ' . $i);
  }
}
