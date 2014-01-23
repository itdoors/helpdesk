<?php

class clientOrganizationTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'client';
    $this->name             = 'organization';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [client:organization|INFO] task does things.
Call it with:

  [php symfony client:organization|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $dbManager = new sfDatabaseManager($this->configuration);
    $connection = Doctrine_Manager::connection();

    set_time_limit(0);

    ini_set('memory_limit', '768M');

    $this->logSection('Start: ', 'copy organization ids');

    $clients = Doctrine::getTable('client')
      ->createQuery('c')
      ->where('c.organization_id IS NOT NULL')
      ->execute();

    $this->logSection('Total clients: ', sizeof($clients));

    foreach ($clients as $client)
    {
      $this->copyClientOrganization($client);
    }

    $this->logSection('End: ', 'data copied');
  }

  public function copyClientOrganization(client $client)
  {
    $organizationId = $client->getOrganizationId();

    $clientOrganizationRecord = Doctrine::getTable('ClientOrganization')
      ->createQuery('co')
      ->where('co.client_id = ?', $client->getId())
      ->addWhere('co.organization_id = ?', $organizationId)
      ->fetchOne();

    if (!$clientOrganizationRecord)
    {
      $this->logSection('Coping data for: ', $client->getId() . ' and organizationId = '. $organizationId);

      $clientOrganization = new ClientOrganization();
      $clientOrganization->setClientId($client->getId());
      $clientOrganization->setOrganizationId($organizationId);
      $clientOrganization->save();
    }
  }
}