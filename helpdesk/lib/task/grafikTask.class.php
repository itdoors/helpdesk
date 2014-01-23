<?php

class grafikTask extends sfBaseTask
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
    $this->name             = 'grafik';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [grafik|INFO] task does things.
Call it with:

  [php symfony grafik|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $dbManager = new sfDatabaseManager($this->configuration);
    $connection = Doctrine_Manager::connection();

    set_time_limit(0);

    ini_set('memory_limit', '768M');

    $offsetStart = $arguments['offset'];
    $offset = $arguments['offset'];
    $limit = 50;

    $this->logSection('Start from ', $offsetStart);

    //for ($offset = $offsetStart; $offset <= 90000; $offset += $limit)

    while ($offset < 20000)
    {
      $startTime = time();
      $startMemory = memory_get_usage();

      $offset = $this->recount($offset, $limit);

      $endTime = time();
      $endMemory = memory_get_usage();

      $totalTime = ($endTime - $startTime)/60;
      $totalMemory = $endMemory - $startMemory;

      $str = '- '.$offset . ' time = '.$totalTime . ' memory = '.$totalMemory;

      $this->logSection('grafik', $str);
    }

    $this->logSection('grafik', '- success');
  }

  public function recount($offset, $limit)
  {
    $grafiks = Doctrine::getTable('Grafik')
      ->createQuery('gt')
      ->where('gt.is_sick = ? ', false)
      ->addWhere('gt.is_skip = ? ', false)
      ->addWhere('gt.is_vacation = ? ', false)
      ->addWhere('gt.is_fired = ? ', false)
      //->addWhere('gt.total is null')
      ->addWhere('gt.total = ?', 0)
      ->offset($offset)
      ->limit($limit)
      ->execute();

    foreach ($grafiks as $grafik )
    {
      //$this->logSection('grafik info ', $grafik->getDepartmentId()." - ". $grafik->getYear() ." ". $grafik->getMonth(). ' '. $grafik->getDay());
      $grafik->recount();
    }

    //sleep(1);

    if (!sizeof($grafiks))
    {
      $offset += $limit;
    }

    return $offset;
  }
}
