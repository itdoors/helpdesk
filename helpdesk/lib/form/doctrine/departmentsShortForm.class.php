<?php

class departmentsShortForm extends BasedepartmentsForm
{
  public function configure()
  {
    parent::configure();

    unset($this['stuff_list'], $this['client_list'], $this['groupclaim_list']);

    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

    $this->setWidget('organization_name', new sfWidgetFormInputText(array(), array('disabled' => 'disabled')));
    $this->setWidget('city_name', new sfWidgetFormInputText(array(), array('disabled' => 'disabled')));
    $this->setWidget('organization_id', new sfWidgetFormInputHidden());
    $this->setWidget('city_id', new sfWidgetFormInputHidden());
    $this->setWidget('contract_id', new sfWidgetFormInputHidden());



    if ($this->getOption('action') == 'show')
    {
      $org_id = $this->getObject()->_data['organization_id'];
      $city_id = $this->getObject()->_data['city_id'];

      $contract_id = contractTable::getContractIdByOrganizationId($org_id);

      $this->setDefault('organization_id', $org_id);
      $this->setDefault('city_id', $city_id);
      $this->setDefault('contract_id', $contract_id);

      $org_name = organizationTable::getInstance()->find($org_id);
      $city_name = cityTable::getInstance()->find($city_id);

      $this->setDefault('organization_name', $org_name);
      $this->setDefault('city_name', $city_name);
    }


    $this->setValidator('organization_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'required' => false)));
    $this->setValidator('city_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'required' => false)));

    $this->useFields(array(
      'mpk',
      'address',
      'organization_name',
      'city_name',
      'organization_id',
      'contract_id',
      'city_id',
    ));
  }

  public function updateObject($values = null)
  {
    if (null === $values)
    {
      $values = $this->values;
    }

    $values['name'] = $values['address'];

    return parent::updateObject($values);
  }

  public function save($con = null)
  {
    $isNew = $this->isNew();

    $object = parent::save();

    if (GlobalFunctions::isSuperKurator() && $isNew)
    {
      $stuffId = GlobalFunctions::getStuffId();
      $stuffDepartments = Doctrine::getTable('stuff_departments')
        ->createQuery('sd')
        ->where('stuff_id = ?' , $stuffId)
        ->addWhere('departments_id = ? ' , $object->getId())
        ->addWhere('userkey = ?', stuff_departments::KURATOR)
        ->execute();

      if (!sizeof($stuffDepartments))
      {
        stuff_departments::setStuffOnAllClaimtype(
          $object->getId($object->getId()),
          $stuffId,
          stuff_departments::KURATOR
        );
      }

    };

    return $object;
  }
}