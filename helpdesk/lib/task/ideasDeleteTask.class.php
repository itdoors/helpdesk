<?php

class ideaDeleteTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    $this->addArguments(array(
      new sfCommandArgument('id', sfCommandArgument::REQUIRED, 'Idea Id(s)'),
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'idea';
    $this->name             = 'delete';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [idea:delete|INFO] task does things.
Call it with:

  [php symfony idea:delete|INFO]
EOF;
  }
  protected function execute($arguments = array(), $options = array())
  {
    $dbManager = new sfDatabaseManager($this->configuration);
    $connection = Doctrine_Manager::connection();

    set_time_limit(0);

    ini_set('memory_limit', '768M');

    $this->logSection('Start from ','idea:delete');

    $ideaIds = explode(',', $arguments['id']);

    $ideas = Doctrine::getTable('Idea')
      ->createQuery('i')
      ->whereIn('i.id', $ideaIds)
      ->execute();

    $this->logSection('Total Ideas ',sizeof($ideas));

    foreach ($ideas as $idea)
    {
      $this->deleteIdea($idea);
    }

    $this->logSection('End for ','idea:delete');
  }

  public function deleteIdea(Idea $idea)
  {
    if (!$idea)
    {
      $this->logSection('Error with ','no idea found');
      $this->logSection('End for ','idea:delete');
      return;
    }

    $this->logSection('--Deleting idea: ','#'.$idea->getId());

    $ideaGoals = $idea->getIdeaIdeaGoal();

    $this->logSection('-- --Total goals: ',sizeof($ideaGoals));

    if (sizeof($ideaGoals))
    {
      $this->logSection('-- -- --Deleting goals: ','...');
      $ideaGoals->delete();
      $this->logSection('-- -- -- Deleting goals complete: ','!!!');
    }


    if (0)
    {
      //history
      $this->logSection(' -- Deleting history: ','...');
      //$ideaGoals->delete();
      $this->logSection(' -- Deleting history complete: ','!!!');
    }

    $idea->delete();
    $this->logSection('Deleting idea complete: ','!!!');
  }
}