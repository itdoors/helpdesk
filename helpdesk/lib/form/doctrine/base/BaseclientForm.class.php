<?php

/**
 * client form base class.
 *
 * @method client getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseclientForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'phone'              => new sfWidgetFormInputText(),
      'mobilephone'        => new sfWidgetFormInputText(),
      'user_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => false)),
      'organization_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)),
      'show_added_field'   => new sfWidgetFormInputCheckbox(),
      'is_mailed'          => new sfWidgetFormInputCheckbox(),
      'organizations_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'organization')),
      'departments_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'departments')),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'phone'              => new sfValidatorString(array('max_length' => 12, 'required' => false)),
      'mobilephone'        => new sfValidatorString(array('max_length' => 12)),
      'user_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'))),
      'organization_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'required' => false)),
      'show_added_field'   => new sfValidatorBoolean(array('required' => false)),
      'is_mailed'          => new sfValidatorBoolean(array('required' => false)),
      'organizations_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'organization', 'required' => false)),
      'departments_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'departments', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'client', 'column' => array('user_id')))
    );

    $this->widgetSchema->setNameFormat('client[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'client';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['organizations_list']))
    {
      $this->setDefault('organizations_list', $this->object->Organizations->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['departments_list']))
    {
      $this->setDefault('departments_list', $this->object->Departments->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveOrganizationsList($con);
    $this->saveDepartmentsList($con);

    parent::doSave($con);
  }

  public function saveOrganizationsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['organizations_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Organizations->getPrimaryKeys();
    $values = $this->getValue('organizations_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Organizations', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Organizations', array_values($link));
    }
  }

  public function saveDepartmentsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['departments_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Departments->getPrimaryKeys();
    $values = $this->getValue('departments_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Departments', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Departments', array_values($link));
    }
  }

}
