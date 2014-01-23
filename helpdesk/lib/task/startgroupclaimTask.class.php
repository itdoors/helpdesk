<?php

class startgroupclaimTask extends sfBaseTask
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
    $this->name             = 'startgroupclaim';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [startgroupclaim|INFO] task does things.
Call it with:

  [php symfony startgroupclaim|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    sfContext::createInstance($this->configuration);
    //$configuration = ProjectConfiguration::getApplicationConfiguration('dispatcher', 'prod', false);
    //$databaseManager->loadConfiguration();
    //$configuration = ProjectConfiguration::getApplicationConfiguration ('dispatcher', 'prod', false);
    //sfContext::createInstance($this->configuration);

    // add your code here
    $message = Groupclaim::StartGroupclaim();
    
    
    $this->logSection('startgroupclaim', '- success');
    
  }
}
