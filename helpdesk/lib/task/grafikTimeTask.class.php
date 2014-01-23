<?php

class grafikTimeTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'grafikTime';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [grafikTime|INFO] task does things.
Call it with:

  [php symfony grafikTime|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $dbManager = new sfDatabaseManager($this->configuration);
    $connection = Doctrine_Manager::connection();

    set_time_limit(0);

    ini_set('memory_limit', '512M');

    $offset = 0;
    $limit = 100;



    //for ($offset = 0; $offset <= 90000; $offset += $limit)
    while ($offset < 200)
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

    $this->logSection('grafikTime', '- success');
  }

  public function recount($offset, $limit)
  {
    $grafikTimes = Doctrine::getTable('GrafikTime')
      ->createQuery('gt')
      /*->where('gt.department_id = ? ', 1880)
      ->addWhere('gt.year = ?', 2013)
      ->addWhere('gt.month = ? ', 6)*/
      ->where('gt.from_time is not null')
      ->addWhere('gt.total is null')
      ->offset($offset)
      ->limit($limit)
      ->execute();

    foreach ($grafikTimes as $grafikTime )
    {
      if (!$grafikTime->getTotal())
      {
        $grafikTime->recount();
      }
    }

    if (!sizeof($grafikTimes))
    {
      $offset += $limit;
    }

    return $offset;
  }
}
