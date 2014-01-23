<?php

class CrmOrganizationForm extends BaseorganizationForm
{
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

    $this->setWidget('scope_id' , new sfWidgetFormDoctrineChoice(array('model' => 'lookup', 'table_method' => 'getOnlyScope', 'add_empty' => true)));
    //$this->setWidget('client_type_id' , new sfWidgetFormDoctrineChoice(array('model' => 'lookup', 'table_method' => 'getOnlyClientType', 'add_empty' => true)));

    $this->setWidget('city_id' , new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model'=>'city',
      'url'=>url_for('ajaxdata/auto_city'),
    )));

    $url = url_for('organization_duplicate');

    $this->getWidget('name')->setAttribute('data-url', $url);

    $this->useFields(array(
      //'mpk',
      'name',
      'address',
      'mailing_address',
      'organization_type_id',
      'rs',
      'edrpou',
      'inn',
      'certificate',
      'short_description',
      'site',
      'scope_id',
      //'client_type_id',
      'city_id'
    ));

    $this->widgetSchema->setNameFormat('crm_organization_form[%s]');
  }

  public function save($con = null)
  {
    $isNew = $this->isNew();

    $object = parent::save();

    $userId = GlobalFunctions::getUserId();

    if ($isNew)
    {
      $organizationUser = new OrganizationUser();
      $organizationUser->setOrganizationId($object->getId());
      $organizationUser->setUserId($userId);
      $organizationUser->save();
    }

    return $object;
  }
}