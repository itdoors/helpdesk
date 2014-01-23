<?php

class queueTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'dispatcher'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = '';
    $this->name             = 'queue';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [queue|INFO] task does things.
Call it with:

  [php symfony queue|INFO]
EOF;
  }
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

    $this->logSection('Start: ','queue');

    $queues = Doctrine::getTable('queue')
      ->createQuery('q')
      ->where('q.status = ? ', Queue::STATUS__NEW)
      ->execute();

    $this->logSection('Total: ',sizeof($queues));

    foreach($queues as $queue) /** @var Queue $queue*/
    {
      $queue->proceed($this);
    }

    $this->logSection('End: ','queue');
  }
}