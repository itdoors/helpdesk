<?php

class handlingComponents extends sfComponents
{
  public function executeFilters()
  {
  }

  public function executeGeneral()
  {
  }

  public function executeMessages()
  {
  }

  public function executeHandling_messages()
  {
    $handlingId = $this->handlingId;

    $this->handling = Doctrine::getTable('Handling')->find($handlingId);

    $this->messages = Doctrine::getTable('HandlingMessage')
      ->createQuery('hm')
      ->leftJoin('hm.User users')
      ->leftJoin('hm.HandlingMessageType hmt')
      ->where('hm.handling_id =? ', $handlingId)
      ->execute();
  }

  public function executeManagers()
  {
    //$handlingId = $this->handlingId;
  }

  public function executeManagers_list()
  {
    $handlingId = $this->handling_id;

    $managers = Doctrine::getTable('HandlingUser')
      ->createQuery('hu')
      ->where('hu.handling_id = ?', $handlingId)
      ->leftJoin('hu.User users')
      ->leftJoin('users.Stuff stuff')
      ->execute();

    $this->managers = $managers;
  }

  public function executeClient_contacts()
  {

  }

  public function executeMore_info()
  {
    $typeId = HandlingResult::getIdBySlug($this->type);

    $this->types = HandlingMoreInfoType::getTypesByResultId($typeId);

    $this->moreInfo = HandlingMoreInfo::getFormattedData($this->handlingId);
  }
}

