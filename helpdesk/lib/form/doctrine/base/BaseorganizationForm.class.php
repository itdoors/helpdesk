<?php

/**
 * organization form base class.
 *
 * @method organization getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseorganizationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'mpk'                  => new sfWidgetFormInputText(),
      'name'                 => new sfWidgetFormInputText(),
      'address'              => new sfWidgetFormInputText(),
      'contacts'             => new sfWidgetFormInputText(),
      'shortname'            => new sfWidgetFormInputText(),
      'is_smeta'             => new sfWidgetFormInputCheckbox(),
      'mailing_address'      => new sfWidgetFormInputText(),
      'organization_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrganizationType'), 'add_empty' => true)),
      'rs'                   => new sfWidgetFormInputText(),
      'edrpou'               => new sfWidgetFormInputText(),
      'inn'                  => new sfWidgetFormInputText(),
      'certificate'          => new sfWidgetFormInputText(),
      'short_description'    => new sfWidgetFormInputText(),
      'site'                 => new sfWidgetFormInputText(),
      'scope_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Scope'), 'add_empty' => true)),
      'client_type_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ClientType'), 'add_empty' => true)),
      'city_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
      'organization_sign_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrganizationSign'), 'add_empty' => true)),
      'client_list'          => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'client')),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'mpk'                  => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'name'                 => new sfValidatorString(array('max_length' => 255)),
      'address'              => new sfValidatorString(array('max_length' => 255)),
      'contacts'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'shortname'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'is_smeta'             => new sfValidatorBoolean(array('required' => false)),
      'mailing_address'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'organization_type_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('OrganizationType'), 'required' => false)),
      'rs'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'edrpou'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'inn'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'certificate'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'short_description'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'site'                 => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'scope_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Scope'), 'required' => false)),
      'client_type_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ClientType'), 'required' => false)),
      'city_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'required' => false)),
      'organization_sign_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('OrganizationSign'), 'required' => false)),
      'client_list'          => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'client', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('organization[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'organization';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['client_list']))
    {
      $this->setDefault('client_list', $this->object->client->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveclientList($con);

    parent::doSave($con);
  }

  public function saveclientList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['client_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->client->getPrimaryKeys();
    $values = $this->getValue('client_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('client', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('client', array_values($link));
    }
  }

}
