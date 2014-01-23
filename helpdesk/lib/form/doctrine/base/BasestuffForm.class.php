<?php

/**
 * stuff form base class.
 *
 * @method stuff getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasestuffForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'companystructure_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Companystructure'), 'add_empty' => true)),
      'mobilephone'          => new sfWidgetFormInputText(),
      'mobilephone_personal' => new sfWidgetFormInputText(),
      'phone_inside'         => new sfWidgetFormInputText(),
      'birth_place'          => new sfWidgetFormInputText(),
      'hire_date'            => new sfWidgetFormDate(),
      'fire_date'            => new sfWidgetFormDate(),
      'education'            => new sfWidgetFormInputText(),
      'issues'               => new sfWidgetFormTextarea(),
      'description'          => new sfWidgetFormTextarea(),
      'user_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Users'), 'add_empty' => false)),
      'stuffclass'           => new sfWidgetFormChoice(array('choices' => array('dispatcher' => 'dispatcher', 'stuff' => 'stuff', 'kurator' => 'kurator', 'smeta' => 'smeta'))),
      'departments_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'departments')),
      'city_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'city')),
      'claimtype_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'claimtype')),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'companystructure_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Companystructure'), 'required' => false)),
      'mobilephone'          => new sfValidatorString(array('max_length' => 12)),
      'mobilephone_personal' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'phone_inside'         => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'birth_place'          => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'hire_date'            => new sfValidatorDate(array('required' => false)),
      'fire_date'            => new sfValidatorDate(array('required' => false)),
      'education'            => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'issues'               => new sfValidatorString(array('required' => false)),
      'description'          => new sfValidatorString(array('required' => false)),
      'user_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Users'))),
      'stuffclass'           => new sfValidatorChoice(array('choices' => array(0 => 'dispatcher', 1 => 'stuff', 2 => 'kurator', 3 => 'smeta'), 'required' => false)),
      'departments_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'departments', 'required' => false)),
      'city_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'city', 'required' => false)),
      'claimtype_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'claimtype', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'stuff', 'column' => array('user_id')))
    );

    $this->widgetSchema->setNameFormat('stuff[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'stuff';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['departments_list']))
    {
      $this->setDefault('departments_list', $this->object->Departments->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['city_list']))
    {
      $this->setDefault('city_list', $this->object->City->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['claimtype_list']))
    {
      $this->setDefault('claimtype_list', $this->object->Claimtype->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveDepartmentsList($con);
    $this->saveCityList($con);
    $this->saveClaimtypeList($con);

    parent::doSave($con);
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

  public function saveCityList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['city_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->City->getPrimaryKeys();
    $values = $this->getValue('city_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('City', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('City', array_values($link));
    }
  }

  public function saveClaimtypeList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['claimtype_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Claimtype->getPrimaryKeys();
    $values = $this->getValue('claimtype_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Claimtype', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Claimtype', array_values($link));
    }
  }

}
