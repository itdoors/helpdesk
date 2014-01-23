<?php

/**
 * Groupclaim form base class.
 *
 * @method Groupclaim getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseGroupclaimForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'name'                   => new sfWidgetFormInputText(),
      'claimtype_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'), 'add_empty' => false)),
      'groupclaimwork_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Groupclaimwork'), 'add_empty' => false)),
      'formula'                => new sfWidgetFormTextarea(),
      'client_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Client'), 'add_empty' => false)),
      'contract_importance_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ContractImportance'), 'add_empty' => false)),
      'message'                => new sfWidgetFormTextarea(),
      'is_deleted'             => new sfWidgetFormInputCheckbox(),
      'departments_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'departments')),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                   => new sfValidatorString(array('max_length' => 150)),
      'claimtype_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'))),
      'groupclaimwork_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Groupclaimwork'))),
      'formula'                => new sfValidatorString(array('required' => false)),
      'client_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Client'))),
      'contract_importance_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ContractImportance'))),
      'message'                => new sfValidatorString(array('required' => false)),
      'is_deleted'             => new sfValidatorBoolean(array('required' => false)),
      'departments_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'departments', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('groupclaim[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Groupclaim';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['departments_list']))
    {
      $this->setDefault('departments_list', $this->object->Departments->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveDepartmentsList($con);

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

}
