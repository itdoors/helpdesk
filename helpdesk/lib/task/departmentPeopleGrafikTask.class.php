<?php

class departmentPeopleGrafikTask extends sfBaseTask
{
  protected function configure()
  {
    // add your own arguments here
    $this->addArguments(array(
      new sfCommandArgument('offset', sfCommandArgument::OPTIONAL, 'Offset', 0),
      new sfCommandArgument('limit', sfCommandArgument::OPTIONAL, 'Limit', 10),
      new sfCommandArgument('step', sfCommandArgument::OPTIONAL, 'Step', 10),
      new sfCommandArgument('model', sfCommandArgument::OPTIONAL, 'Model', 'Grafik'),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'dispatcher'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'departmentPeople';
    $this->name             = 'grafik';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [departmentPeople:grafik|INFO] task does things.
Call it with:

  [php symfony departmentPeople:grafik [offset] [limit] [step] [model]|INFO]
EOF;
  }

  protected $forceReinsert;
  protected $step;
  protected $model;
  protected $filename = 'dulicate_grafik.txt';

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
    $this->model = $arguments['model'];
    $this->step = $arguments['step'];

    if (!$limit)
    {
      $limit = $this->countAllGrafikDataWithParentPeople();
    }

    $this->logSection('Start: ',"grafik with Offset: {$offset} Limit: {$limit}  Step: {$this->step} Model: {$this->model}");

    for($i = $offset; $i < $limit + $offset; $i += $this->step)
    {
      /** @var Doctrine_Collection $people */
      $grafiks = $this->getAllGrafikDataWithParentPeople($i, $this->step);

      $parentPeopleArray = $this->getParentPeopleArray($grafiks);

      $to = $i + $this->step;

      $this->logSection('Start processing :', "from: {$i} to {$to} ");

      foreach ($grafiks as $grafik) /** @var Grafik $grafik */
      {
        $this->processGrafik($grafik, $parentPeopleArray);
      }
    }

    $this->logSection('End: ','grafik end');
  }

  /**
   * All people for all year & month
   *
   * @param int $offset
   * @param int $limit
   * @return Doctrine_Collection
   */
  public function getAllGrafikDataWithParentPeople($offset, $limit)
  {
    $query = Doctrine::getTable($this->model)
      ->createQuery('g')
      ->leftJoin('g.DepartmentPeople dp')
      ->where('dp.parent_id is not null')
      ->offset($offset);

    // !!!!!!!!!!!! also in countAllGrafikDataWithParentPeople
    // @todo remove before production
    /*$query->addWhere('g.department_id = 2242');
    $query->addWhere('g.year = 2013');
    $query->addWhere('g.month = 9');*/

    if ($limit)
    {
      $query->limit($limit);
    }

    return $query->execute();
  }

  /**
   * Count people for all year & month
   *
   * @return int
   */
  public function countAllGrafikDataWithParentPeople()
  {
    $query = Doctrine::getTable($this->model)
      ->createQuery('g')
      ->leftJoin('g.DepartmentPeople dp')
      ->where('dp.parent_id is not null');

    // !!!!!!!!!!!! also in getAllGrafikDataWithParentPeople
    // @todo remove before production
    /*$query->addWhere('g.department_id = 2242');
    $query->addWhere('g.year = 2013');
    $query->addWhere('g.month = 9');*/

    return $query->count();
  }

  /**
   * Get parent People array. $res[parent_id] = id
   *
   * @param Doctrine_Collection $grafiks
   * @return int[]
   */
  public function getParentPeopleArray($grafiks)
  {
    if (!sizeof($grafiks))
    {
      return array();
    }

    $parentPeopleIds = $grafiks->toKeyValueArray('department_people_id', 'department_people_id');

    /** @var Doctrine_Collection $parentPeople */
    $parentPeople = Doctrine::getTable('DepartmentPeople')
      ->createQuery('dp')
      ->whereIn('dp.id', $parentPeopleIds)
      ->execute();

    if (!sizeof($parentPeople))
    {
      return array();
    }

    return $parentPeople->toKeyValueArray('id', 'parent_id');
  }

  /**
   * Processes grafik data. set department_people_id(parent_id) to real people id
   *
   * @param Grafik $grafik
   * @param int[] $parentPeopleArray
   */
  public function processGrafik($grafik, $parentPeopleArray)
  {
    $realPeopleId = isset($parentPeopleArray[$grafik->getDepartmentPeopleId()]) ? $parentPeopleArray[$grafik->getDepartmentPeopleId()] : null;

    if ($realPeopleId)
    {
      $this->logSection('    Processing :', $grafik->getDepartmentPeopleId() . ' -> ' . $realPeopleId);

      $grafik->setDepartmentPeopleId($realPeopleId);

      try {
        $grafik->save();
      }
      catch (Exception $e)
      {
        $f = fopen($this->filename, 'a+');
        $year = $grafik->getYear();
        $month = $grafik->getMonth();
        $day = $grafik->getDay();
        $departmentId = $grafik->getDepartmentId();
        $departmentPeopleId = $grafik->getDepartmentPeopleId();
        $departmentPeople = Doctrine::getTable('DepartmentPeople')->find($departmentPeopleId);
        $departmentPeopleName = $departmentPeople ? $departmentPeople->getName() : '';
        $string = "$departmentId, $year, $month, $day, $departmentPeopleName({$departmentPeopleId})\n";
        fwrite($f, $string);
        fclose($f);
      }
    }
  }
}