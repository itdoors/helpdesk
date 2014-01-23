<?php

class departmentPeopleFioTask extends sfBaseTask
{
  protected function configure()
  {
    // add your own arguments here
    $this->addArguments(array(
      new sfCommandArgument('offset', sfCommandArgument::OPTIONAL, 'Offset', 0),
      new sfCommandArgument('limit', sfCommandArgument::OPTIONAL, 'Limit', 0),
      new sfCommandArgument('force', sfCommandArgument::OPTIONAL, 'Force insert', 0),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'dispatcher'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'departmentPeople';
    $this->name             = 'fio';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [departmentPeople:fio|INFO] task does things.
Call it with:

  [php symfony departmentPeople:fio|INFO]
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

    $this->logSection('Start: ','fio');

    $offset = $arguments['offset'];
    $limit = $arguments['limit'];
    $this->force = $arguments['force'];

    /** @var Doctrine_Collection $peoples */
    $peoples = $this->getAllUniquePeople($offset, $limit);

    foreach($peoples as $people)
    {
      $this->processPeople($people);
    }

    $this->logSection('Total unique people: ', sizeof($peoples));


    $this->logSection('End: ','fio end');
  }
  /**
   * All unique people for all year & month
   *
   * @param int $offset
   * @param int $limit
   * @return Doctrine_Collection
   */
  public function getAllUniquePeople($offset, $limit)
  {
    $query = Doctrine::getTable('DepartmentPeople')
      ->createQuery('dp')
      ->where('dp.parent_id is null')
      ->offset($offset);

    if ($limit)
    {
      $query->limit($limit);
    }

    return $query->execute();
  }

  /**
   * Process people fio to first middle last names
   *
   * @param DepartmentPeople $people
   * @return int [0|1]
   */
  public function processPeople($people)
  {
    $fioHolder = explode(' ', $people->getName());

    $fioSize = sizeof($fioHolder);

    if ($fioSize < 2)
    {
      $this->logSection(' Cant process -- : ', '#' . $people->getId() . ' : ' . $people->getName(), null, 'ERROR');
      return 0;
    }

    $firstNameIndex = 1;
    $middleNameIndex = 2;
    $lastNameIndex = 0;

    $firstName = isset($fioHolder[$firstNameIndex]) ? $fioHolder[$firstNameIndex] : '';
    $middleName = isset($fioHolder[$middleNameIndex]) ? $fioHolder[$middleNameIndex] : '';
    $lastName = isset($fioHolder[$lastNameIndex]) ? $fioHolder[$lastNameIndex] : '';

    $string = '#' . $people->getId() . ' : ' . $people->getName() . " -> LastName: {$lastName} FirstName: {$firstName} MiddleName: {$middleName}";

    if ($this->force)
    {
      $people->setFirstName($firstName);
      $people->setLastName($lastName);
      $people->setMiddleName($middleName);

      $people->save();
    }

    $this->logSection(' Process: ', $string);

    return 1;
  }
}