<?php

/**
 * HandlingUser form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class HandlingUserForm extends BaseHandlingUserForm
{
  public function configure()
  {
    $this->setWidget('user_id' , new  sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'table_method' => 'getAllStuff', 'add_empty' => false)));
    $this->setValidator('user_id' , new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => true)));
  }

  public function save($con = null)
  {
    $object = parent::save();

    $i18n = sfContext::getInstance()->getI18N();

    $handling = Doctrine::getTable('Handling')->find($object->getHandlingId());

    if (!$handling)
    {

    }

    $organization = Doctrine::getTable('organization')->find($handling->getOrganizationId());
    $organizationName = $organization ? $organization->getName() : '';
    $params = array(
      '%organization' => $organizationName,
      '%part' => $object->getPart()
    );
    $subject = $i18n->__('You are appointed manager of the handling of organization %organization with %part%  part', $params);
    $text = $i18n->__('You are appointed manager of the handling of organization %organization with %part%  part', $params);

    MailFunctions::sendMessageToUserById($object->getUserId(), $subject, $text);
  }
}
