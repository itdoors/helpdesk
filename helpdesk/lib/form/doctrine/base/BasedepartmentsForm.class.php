<?php

/**
 * departments form base class.
 *
 * @method departments getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasedepartmentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'mpk'                 => new sfWidgetFormInputText(),
      'name'                => new sfWidgetFormInputText(),
      'fullname'            => new sfWidgetFormInputText(),
      'city_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
      'address'             => new sfWidgetFormInputText(),
      'contract_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('contract'), 'add_empty' => true)),
      'organization_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)),
      'square'              => new sfWidgetFormInputText(),
      'isdeleted'           => new sfWidgetFormInputCheckbox(),
      'added_field'         => new sfWidgetFormInputText(),
      'status_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'add_empty' => true)),
      'status_date'         => new sfWidgetFormDate(),
      'departments_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DepartmentsType'), 'add_empty' => true)),
      'description'         => new sfWidgetFormTextarea(),
      'coordinates'         => new sfWidgetFormInputText(),
      'opermanager_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Opermanager'), 'add_empty' => true)),
      'client_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'client')),
      'stuff_list'          => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'stuff')),
      'groupclaim_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Groupclaim')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'mpk'                 => new sfValidatorString(array('max_length' => 20)),
      'name'                => new sfValidatorString(array('max_length' => 255)),
      'fullname'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'city_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'required' => false)),
      'address'             => new sfValidatorString(array('max_length' => 255)),
      'contract_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('contract'), 'required' => false)),
      'organization_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'required' => false)),
      'square'              => new sfValidatorNumber(array('required' => false)),
      'isdeleted'           => new sfValidatorBoolean(array('required' => false)),
      'added_field'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'status_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'required' => false)),
      'status_date'         => new sfValidatorDate(array('required' => false)),
      'departments_type_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DepartmentsType'), 'required' => false)),
      'description'         => new sfValidatorString(array('required' => false)),
      'coordinates'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'opermanager_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Opermanager'), 'required' => false)),
      'client_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'client', 'required' => false)),
      'stuff_list'          => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'stuff', 'required' => false)),
      'groupclaim_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Groupclaim', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('departments[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'departments';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['client_list']))
    {
      $this->setDefault('client_list', $this->object->Client->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['stuff_list']))
    {
      $this->setDefault('stuff_list', $this->object->Stuff->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['groupclaim_list']))
    {
      $this->setDefault('groupclaim_list', $this->object->Groupclaim->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveClientList($con);
    $this->saveStuffList($con);
    $this->saveGroupclaimList($con);

    parent::doSave($con);
  }

  public function saveClientList($con = null)
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

    $existing = $this->object->Client->getPrimaryKeys();
    $values = $this->getValue('client_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Client', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Client', array_values($link));
    }
  }

  public function saveStuffList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['stuff_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Stuff->getPrimaryKeys();
    $values = $this->getValue('stuff_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Stuff', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Stuff', array_values($link));
    }
  }

  public function saveGroupclaimList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['groupclaim_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Groupclaim->getPrimaryKeys();
    $values = $this->getValue('groupclaim_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Groupclaim', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Groupclaim', array_values($link));
    }
  }

}
