<?php

class organizationComponents extends sfComponents
{
  public function executeFilters()
  {
  }

  public function executeContacts()
  {

  }

  public function executeOrganization_contact_list()
  {
    $organization_id = $this->organization_id;

    $this->contacts = ModelContactTable::getInstance()
      ->createQuery('mc')
      ->where('mc.model_name = ?', ModelContact::MODEL_ORGANIZATION)
      ->addWhere('mc.model_id = ?', $organization_id)
      ->execute();

    $this->withDelete = isset($this->withDelete) ? $this->withDelete : true;
  }

  public function executeUsers()
  {
    $organizationId = $this->organization->getId();
  }

  public function executeUsers_list()
  {
    $organizationId = $this->organizationId;

    $organizationUsers = Doctrine::getTable('OrganizationUser')
      ->createQuery('ou')
      ->leftJoin('ou.User user')
      ->leftJoin('user.Stuff stuff')
      ->where('ou.organization_id = ?', $organizationId)
      ->execute();

    $this->organizationUsers = $organizationUsers;
  }

  public function executeEdit()
  {
    $this->form = new CrmOrganizationForm($this->organization);
  }
}

