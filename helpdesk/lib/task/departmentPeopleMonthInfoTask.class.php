<?php

class departmentPeopleMonthInfoTask extends sfBaseTask
{
  protected function configure()
  {
    // add your own arguments here
    $this->addArguments(array(
      new sfCommandArgument('offset', sfCommandArgument::OPTIONAL, 'Offset', 0),
      new sfCommandArgument('limit', sfCommandArgument::OPTIONAL, 'Limit', 10),
      new sfCommandArgument('forceReinsert', sfCommandArgument::OPTIONAL, 'Force Reinsert', 0),
      new sfCommandArgument('step', sfCommandArgument::OPTIONAL, 'Step', 10),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'dispatcher'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'departmentPeople';
    $this->name             = 'month-info';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [departmentPeople:month-info|INFO] task does things.
Call it with:

  [php symfony departmentPeople:month-info [offset] [limit] [forceReinsert] [step]|INFO]
EOF;
  }

  protected $forceReinsert;
  protected $step;

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

    $offset = $arguments['offset'];
    $limit = $arguments['limit'];
    $this->forceReinsert = $arguments['forceReinsert'];
    $this->step = $arguments['step'];
    $forceReinsertString = $this->forceReinsert ? '1' : '0';

    if (!$limit)
    {
      $limit = $this->countAllPeople();
    }

    $this->logSection('Start: ',"month-info with Offset: {$offset} Limit: {$limit} ForceReinsert: {$forceReinsertString} Step: {$this->step}");

    for($i = $offset; $i < $limit + $offset; $i += $this->step)
    {
      /** @var Doctrine_Collection $people */
      $people = $this->getAllPeople($i, $this->step);

      $to = $i + $this->step;

      $this->logSection('Start processing :', "from: {$i} to {$to}");

      foreach ($people as $person) /** @var DepartmentPeople $person */
      {
        DepartmentPeople::processPersonMonthInfo($person, $this->forceReinsert, $this);
        // $this->processPerson($person $this);
      }
    }

    $this->logSection('End: ','month-info end');
  }

  /**
   * Returns base query
   *
   * @param int $offset
   * @param int $limit
   * @return Doctrine_Query $query
   */
  public function getBaseQuery($offset, $limit)
  {
    $query = Doctrine::getTable('DepartmentPeople')
      ->createQuery('dp')
      ->orderBy('dp.id')
      ->offset($offset);

    // @todo remove before production also in countAllPeople
    /*$query->addWhere('dp.department_id = 2242');
    $query->addWhere('dp.year = 2013');
    $query->addWhere('dp.month = 9');*/

    if ($limit)
    {
      $query->limit($limit);
    }

    return $query;
  }

  /**
   * All people for all year & month
   *
   * @param int $offset
   * @param int $limit
   * @return Doctrine_Collection
   */
  public function getAllPeople($offset, $limit)
  {
    $query = $this->getBaseQuery($offset, $limit);

    return $query->execute();
  }

  /**
   * Count people for all year & month
   *
   * @return int
   */
  public function countAllPeople()
  {
    $query = $this->getBaseQuery(0, 0);

    return $query->count();
  }
}