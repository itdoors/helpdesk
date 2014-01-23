<?php

/**
 * claim form base class.
 *
 * @method claim getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseclaimForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'mpk'                        => new sfWidgetFormInputText(),
      'claimtype_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'), 'add_empty' => false)),
      'departments_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Departments'), 'add_empty' => false)),
      'createdatetime'             => new sfWidgetFormDateTime(),
      'isclosedclient'             => new sfWidgetFormInputCheckbox(),
      'status_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'add_empty' => true)),
      'smeta_status_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SmetaStatus'), 'add_empty' => true)),
      'closedatetime'              => new sfWidgetFormDateTime(),
      'contract_importance_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ContractImportance'), 'add_empty' => true)),
      'organization_importance_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrganizationImportance'), 'add_empty' => false)),
      'description'                => new sfWidgetFormInputText(),
      'stuffdescription'           => new sfWidgetFormInputText(),
      'ourcosts'                   => new sfWidgetFormInputText(),
      'isclosedstuff'              => new sfWidgetFormInputCheckbox(),
      'bill_number'                => new sfWidgetFormInputText(),
      'bill_description'           => new sfWidgetFormInputText(),
      'bill_date'                  => new sfWidgetFormDateTime(),
      'akt_date'                   => new sfWidgetFormDateTime(),
      'smeta_costs'                => new sfWidgetFormInputText(),
      'smeta_number'               => new sfWidgetFormInputText(),
      'organization_type_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrganizationType'), 'add_empty' => true)),
      'documents_list'             => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Documents')),
      'works_list'                 => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'works')),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'mpk'                        => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'claimtype_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Claimtype'))),
      'departments_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Departments'))),
      'createdatetime'             => new sfValidatorDateTime(),
      'isclosedclient'             => new sfValidatorBoolean(array('required' => false)),
      'status_id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'required' => false)),
      'smeta_status_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SmetaStatus'), 'required' => false)),
      'closedatetime'              => new sfValidatorDateTime(array('required' => false)),
      'contract_importance_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ContractImportance'), 'required' => false)),
      'organization_importance_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('OrganizationImportance'), 'required' => false)),
      'description'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'stuffdescription'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ourcosts'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'isclosedstuff'              => new sfValidatorBoolean(array('required' => false)),
      'bill_number'                => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'bill_description'           => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'bill_date'                  => new sfValidatorDateTime(array('required' => false)),
      'akt_date'                   => new sfValidatorDateTime(array('required' => false)),
      'smeta_costs'                => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'smeta_number'               => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'organization_type_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('OrganizationType'), 'required' => false)),
      'documents_list'             => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Documents', 'required' => false)),
      'works_list'                 => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'works', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('claim[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'claim';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['documents_list']))
    {
      $this->setDefault('documents_list', $this->object->Documents->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['works_list']))
    {
      $this->setDefault('works_list', $this->object->works->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveDocumentsList($con);
    $this->saveworksList($con);

    parent::doSave($con);
  }

  public function saveDocumentsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['documents_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Documents->getPrimaryKeys();
    $values = $this->getValue('documents_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Documents', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Documents', array_values($link));
    }
  }

  public function saveworksList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['works_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->works->getPrimaryKeys();
    $values = $this->getValue('works_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('works', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('works', array_values($link));
    }
  }

}
