<?php
class claimClientNewForm extends claimWithCommentsForm
{
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Url');

    $userId = GlobalFunctions::getUserId();

    $client = Doctrine::getTable('client')->findOneBy('user_id', $userId);

    $this->setWidget('city_list' , new  sfWidgetFormDoctrineChoice(array(
      'model' => 'City',
      'table_method' => 'getCityOrderName',
      'add_empty' => true,
    ),array(
      'data-url_departments' => url_for('ajax_load_client_departments'),
      'data-url_importance' => url_for('ajax_load_client_importance'),
      'data-client_id' => $client->getId(),
      'data-organization_ids' => json_encode($client->getOrganizationIds())
    )));
    $this->setValidator('city_list' , new sfValidatorDoctrineChoice(array('model' => 'City', 'required' => false)));

    $this->widgetSchema['departments_id']->setOption('table_method','NoInfo');
    $this->widgetSchema['departments_id']->setAttribute('class','NoInfo');

    $this->setWidget('organization_importance_id', new sfWidgetFormDoctrineChoice(array(
      'model' => $this->getRelatedModelName('OrganizationImportance'),
      'add_empty' => false,
      'table_method' => 'noInfo',
    )));

    //$this->widgetSchema['organization_importance_id']->setOption('table_method','getImportanceForThisContract');

    $this->useFields(
      array(
        'claimtype_id',
        'city_list',
        'departments_id',
        'organization_importance_id',
      ));
    parent::configure();

    $this->widgetSchema->setNameFormat('client_claim_form[%s]');

    $this->disableLocalCSRFProtection();
  }
  protected function doSave($con = null)
  {
    // дабавляем тип организации
    parent::doSave($con);

    $object = $this->getObject();

    $organization_id = $object->getDepartments()->getOrganizationId();

    $organization = organizationTable::getInstance()->find($organization_id);
    $organization_type_id = $organization ? $organization->getOrganizationTypeId() : null;

    $object->setOrganizationTypeId($organization_type_id);
    $object->save();

    // сохранение в историю end
    // todo 8: отправка сообщения о создании на почту
    $app = sfContext::getInstance()->getConfiguration()->getApplication();

    $subject = SDtexts::getClient_Claimopened_Create_Subject($this->claim);
    $text = SDtexts::getClient_Claimopened_Create_Text($this->claim);

    MailFunctions::sendSDEmail($this->claim->getId(), null, sfConfig::get('claimuserkey_client'), $subject, $text); // отправка клиенту
    //MailFunctions::sendSDEmail($this->claim->getId(), null, sfConfig::get('claimuserkey_dispatcher'), $subject, $text); // отправка диспетчеру

  }
}