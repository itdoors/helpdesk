<?php

/**
 * Handling form.
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class HandlingForm extends BaseHandlingForm
{
  public function configure()
  {
    $this->setWidget('createdate', new sfWidgetFormJQueryDate(array(
      'config' => '{}',
      'culture' => 'ru',
      'date_widget' => new sfWidgetFormDate(array('format' => '%day%%month%%year%'), array('style'=>'min-width:70px;'))
    )));
    $this->setValidator('createdate',  new sfValidatorDate(array( 'max' => date("Y-m-d"), 'datetime_output'=>'Y-m-d')));

    $this->getWidget('budget') ->setLabel('Amount per month excluding VAT');

    $this->useFields(array(
      'createdate',
      'status_id',
      'type_id',
      'status_description',
      'service_offered',
      'budget',
      'budget_client',
      'square',
      'chance',
      'description',
      'result_id',
      'result_string'
    ));
  }

  public function updateObject($values = null)
  {
    if (null === $values)
    {
      $values = $this->values;
    }

    if ($this->isNew())
    {
      $values['createdatetime'] = date("Y-m-d H:i:s");
      $values['user_id'] = GlobalFunctions::getUserId();
      $values['organization_id'] = Handling::getSessionOrganizationId();
    }

    return parent::updateObject($values);
  }

  public function save($con = null)
  {
    $isNew = $this->isNew();

    $isStatusChange = false;

    $object = parent::save();

    $lastModified = $this->getObject()->getLastModified();

    if (isset($lastModified['status_id']))
    {
      $isStatusChange = true;
    }

    if ($isStatusChange)
    {
      $object->setStatusChangeDate(date("Y-m-d H:i:s"));
      $object->save();
    }

    if ($isNew)
    {
      $handlingUser = new HandlingUser();

      $handlingUser->setHandlingId($object->getId());
      $handlingUser->setUserId(GlobalFunctions::getUserId());
      $handlingUser->setPart(100);
      $handlingUser->save();

      //send email to $userId
      $i18n = sfContext::getInstance()->getI18N();

      $organization = Doctrine::getTable('organization')->find($object->getOrganizationId());
      $organizationName = $organization ? $organization->getName() : '';
      $params = array(
        '%organization' => $organizationName,
        '%part' => '100'
      );
      $subject = $i18n->__('You are appointed manager of the handling of organization %organization with %part%  part', $params);
      $text = $i18n->__('You are appointed manager of the handling of organization %organization with %part%  part', $params);

      MailFunctions::sendMessageToUserById(GlobalFunctions::getUserId(), $subject, $text);
    }

    return $object;
  }
}
