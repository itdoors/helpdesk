<?php

class clientInfoForm extends BaseclientForm
{
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

    $organizationIds = array();
    $isDepartmentLoading = false;

    if ($this->getOption('organizationIds')) // if its ajax request in cinfo
    {
      $organizationIds = is_array($this->getOption('organizationIds')) ? $this->getOption('organizationIds') : array(0);
      $isDepartmentLoading = true;
    }
    else
    {
      $organizations = $this->getObject()->getOrganizations();

      if (sizeof($organizations))
      {
        $organizationIds = $organizations->getPrimaryKeys();
      }
    }


    $query = Doctrine::getTable('departments')
      ->createQuery('d')
      ->leftJoin('d.City as city')
      ->leftJoin('d.Organization as organization')
      ->whereIn('d.organization_id', $organizationIds)
      ->orderBy('organization.name ASC, city.name ASC');

    $this->setWidget('departments_list', new sfWidgetFormDoctrineChoice(array(
      'multiple' => true,
      'model' => 'departments',
      'method' => 'getWithOrganization',
      'query' => $query
    ),array(
      'style' => 'height: 500px;'
    )));

    /*$queryOrganization = Doctrine::getTable('organization')
      ->createQuery('o')
      ->*/

    $this->setWidget('organizations_list', new sfWidgetFormDoctrineChoice(array(
      'multiple' => true,
      'model' => 'organization',
      'order_by' => array('name', 'ASC')
      //'query' => $queryOrganization
    ),array(
      'style' => 'height: 200px;',
      'data-url' => url_for('ajax_departments_by_organization'),
      'data-client_id' => $this->getObject()->getId()
    )));

    unset(
      $this['user_id'],
      $this['mpk'],
      $this['mobilephone'],
      $this['position'],
      $this['phone'],
      $this['organization_id']
    );
    if ($isDepartmentLoading)
    {
      unset($this['organizations_list']);
    }
  }
}