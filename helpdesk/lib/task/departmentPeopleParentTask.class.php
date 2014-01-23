<?php

class departmentPeopleParentTask extends sfBaseTask
{
  protected function configure()
  {
    // add your own arguments here
    $this->addArguments(array(
      new sfCommandArgument('offset', sfCommandArgument::OPTIONAL, 'Offset', 0),
      new sfCommandArgument('limit', sfCommandArgument::OPTIONAL, 'Limit', 10),
      new sfCommandArgument('percent', sfCommandArgument::OPTIONAL, 'Similar percent', 89),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'dispatcher'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'departmentPeople';
    $this->name             = 'parent';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [departmentPeople:parent|INFO] task does things.
Call it with:

  [php symfony queue|INFO]
EOF;
  }

  protected $percent;

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

    $this->logSection('Start: ','parent');

    $offset = $arguments['offset'];
    $limit = $arguments['limit'];

    $this->percent = $arguments['percent'];

    $departmentIds = $this->getDistinctDepartmentIds($offset, $limit);

    foreach ($departmentIds as $departmentIdHolder)
    {
      $departmentId = $departmentIdHolder['did'];

      $this->logSection('Fetching data for DepartmentId: ', $departmentId);

      /** @var Doctrine_Collection $peoples */
      $peoples = $this->getAllPeopleByDepartmentId($departmentId);

      $this->logSection('  People data for DepartmentId: ','-----------------' . $departmentId . '-----------------');

      //$this->logSection('   : ', var_export($peoples));

      foreach ($peoples as $key => $people) /** @var DepartmentPeople $people */
      {
        if ($people->getParentId())
        {
          continue;
        }

        $peoples->remove($key);

        $this->processDuplicates($people, $peoples);
      }

      $this->logSection('  EOF People data for DepartmentId: ','-----------------' . $departmentId . '-----------------');
    }

    $this->logSection('End: ','parent end');
  }

  /**
   * Get distinct department ids from department_people
   *
   * @param int $offset
   * @param int $limit
   * @return int[]
   */
  public function getDistinctDepartmentIds($offset, $limit)
  {
    $query = Doctrine::getTable('DepartmentPeople')
      ->createQuery('dp')
      ->select('DISTINCT(dp.department_id) AS did')
      ->offset($offset)
      ->limit($limit);

    // @todo remove before production
    //$query->andWhere('dp.department_id = 2242');

    return $query->fetchArray();
  }

  /**
   * All people for all year & month for current department
   *
   * @param int $departmentId
   * @return mixed[]
   */
  public function getAllPeopleByDepartmentId($departmentId)
  {
    $people = Doctrine::getTable('DepartmentPeople')
      ->createQuery('dp')
      ->where('dp.department_id = ?', $departmentId)
      ->addWhere('dp.parent_id is null')
      ->orderBy('dp.id')
      ->execute();

    return $people;
  }

  /**
   * Processes duplicates people. Set parent_id for duplicates
   *
   * @param DepartmentPeople $currentPeople
   * @param Doctrine_Collection $peoples
   */
  public function processDuplicates($currentPeople, &$peoples)
  {
    foreach ($peoples as $key => $value) /** @var DepartmentPeople $value*/
    {
      similar_text(mb_convert_case($currentPeople->getName(), MB_CASE_LOWER, "UTF-8"), mb_convert_case($value->getName(), MB_CASE_LOWER, "UTF-8"), $percent);
      if ($percent > $this->percent)
      {
        $this->logSection('   Find duplicate:', $currentPeople->getName() . ' -> ' .$value->getName());

        $value->setParentId($currentPeople->getId());
        $value->save();
        $peoples->remove($key);
      }
    }
  }
}