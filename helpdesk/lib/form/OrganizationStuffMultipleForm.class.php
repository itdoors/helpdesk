<?php

class OrganizationUserMultipleForm extends BaseOrganizationUserForm
{
  public function configure()
  {
    $this->setWidget('organization_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)));

    $this->setWidget('user_id' , new  sfWidgetFormDoctrineChoice(
      array(
        'model' => 'sfGuardUser',
        'table_method' => 'getAllStuff',
        'add_empty' => false,
        'multiple'=>true
      ),
      array(
        'style' => "height:400px"
      )
    ));
    $this->setValidator('user_id' , new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => true, 'multiple' => true)));

    $this->useFields(array(
      'organization_id',
      'user_id'
    ));
  }

  public function save($con = null)
  {
    $values = $this->getValues();

    $organizationId = $values['organization_id'];

    $users = $values['user_id'];

    //delete all users for organization
    $this->deleteAllUsers($organizationId);

    foreach ($users as $key => $userId)
    {
      $this->createNewRecord($organizationId,$userId);
    }

    return true;
  }

  protected function createNewRecord($organizationId, $userId)
  {
    $ou = new OrganizationUser();
    $ou->setOrganizationId($organizationId);
    $ou->setUserId($userId);
    $ou->save();

    //send email to $userId
    $i18n = sfContext::getInstance()->getI18N();

    $organization = Doctrine::getTable('organization')->find($organizationId);
    $organizationName = $organization ? $organization->getName() : '';
    $params = array(
      '%organization' => $organizationName
    );
    $subject = $i18n->__('You are appointed manager of the organization %organization', $params);
    $text = $i18n->__('You are appointed manager of the organization %organization', $params);

    MailFunctions::sendMessageToUserById($userId, $subject, $text);
  }

  protected function deleteAllUsers($organizationId)
  {
    if (!$organizationId)
    {
      return;
    }
    Doctrine::getTable('OrganizationUser')
      ->createQuery('ou')
      ->where('ou.organization_id = ?', $organizationId)
      ->execute()
      ->delete();
  }
}