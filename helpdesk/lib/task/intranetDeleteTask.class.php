<?php

class intranetDeleteTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'intranet';
    $this->name             = 'delete';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [intranet:delete|INFO] task does things.
Call it with:

  [php symfony intranet:delete|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $dbManager = new sfDatabaseManager($this->configuration);
    $connection = Doctrine_Manager::connection();

    set_time_limit(0);

    ini_set('memory_limit', '768M');

    $this->logSection('Start from ','intranet:delete');

    //for ($offset = $offsetStart; $offset <= 90000; $offset += $limit)
    $docDocumentGroups = Doctrine::getTable('DocDocumentGroup')
      ->createQuery('ddg')
      ->where('ddg.isdeleted = ?', true)
      //->addWhere('ddg.parent_id is null')
      ->execute();

    foreach ($docDocumentGroups as $group)
    {
      $this->logSection('Group #'.$group->getId(), $group->getName());

      $this->deleteAllChildren($group->getId(), $group->getName());

      $this->deleteAllGroupInfo($group);

      $group->hardDelete();
    }

    $this->logSection('intranet:delete', '- success');
  }

  public function deleteAllChildren($groupId, $parentName)
  {
    $docDocumentGroups = Doctrine::getTable('DocDocumentGroup')
      ->createQuery('ddg')
      //->where('ddg.isdeleted = ?', true)
      ->addWhere('ddg.parent_id = ?', $groupId)
      ->execute();

    foreach ($docDocumentGroups as $group)
    {
      $this->logSection('Group # (parent #'.$groupId.'('.$parentName.')'.$group->getId(), $group->getName());

      $this->deleteAllChildren($group->getId(), $group->getName());

      $this->deleteAllGroupInfo($group);

      $group->hardDelete();
    }
  }

  public function deleteAllGroupInfo(DocDocumentGroup $group)
  {
    $this->showDocuments($group);
    $this->showSfGroups($group);

    $lofIntranets = Doctrine::getTable('LogIntranet')
      ->createQuery('li')
      ->where('li.logtype = ?', $group->getTable()->getOption('name'))
      ->addWhere('li.logtype =?', $group->getId())
      ->execute();

    foreach ($lofIntranets as $log)
    {
      $this->logSection(' -  - Log group #'.$log->getId(), $log->getLogtype() . ' ' . $log->getDescription);
    }
  }

  public function showDocuments(DocDocumentGroup $group)
  {
    $documents = Doctrine::getTable('DocDocument')
      ->createQuery('dd')
      ->where('dd.category_id = ?', $group->getId())
      ->execute();

    foreach ($documents as $document)
    {
      $this->logSection(' - Document #'.$document->getId(), $document->getName());

      $versions = $document->getDocDocumentVersion();

      foreach ($versions as $version)
      {
        $this->logSection(' -  - Version #'.$version->getId(), $version->getName());
        $version->hardDelete();
      }

      $lofIntranets = Doctrine::getTable('LogIntranet')
        ->createQuery('li')
        ->where('li.logtype = ?', $document->getTable()->getOption('name'))
        ->addWhere('li.logtype =?', $document->getId())
        ->execute();

      foreach ($lofIntranets as $log)
      {
        $this->logSection(' -  - Log #'.$log->getId(), $log->getLogtype() . ' ' . $log->getDescription);
        $log->delete();
      }

      $document->hardDelete();
    }
  }

  public function showSfGroups(DocDocumentGroup $group)
  {
    $sfGroups = $group->getSfGroups();
    $sfUsers = $group->getSfUsers();

    foreach ($sfGroups as $sfGroup)
    {
      $this->logSection(' - sfGroups #'.$sfGroup->getId(), $sfGroup->getName());
      //$document->hardDelete();
    }
    foreach ($sfUsers as $sfUser)
    {
      $this->logSection(' - sfUsers #'.$sfUser->getId(), $sfUser->getName());
      //$document->hardDelete();
    }
  }
}
