<?php

/**
 * contract form base class.
 *
 * @method contract getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasecontractForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInputText(),
      'fileupload'      => new sfWidgetFormInputText(),
      'organization_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('organization'), 'add_empty' => false)),
      'createdate'      => new sfWidgetFormDate(),
      'closedate'       => new sfWidgetFormDate(),
      'importance_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'importance')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 255)),
      'fileupload'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'organization_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('organization'))),
      'createdate'      => new sfValidatorDate(array('required' => false)),
      'closedate'       => new sfValidatorDate(array('required' => false)),
      'importance_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'importance', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contract[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'contract';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['importance_list']))
    {
      $this->setDefault('importance_list', $this->object->Importance->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveImportanceList($con);

    parent::doSave($con);
  }

  public function saveImportanceList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['importance_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Importance->getPrimaryKeys();
    $values = $this->getValue('importance_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Importance', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Importance', array_values($link));
    }
  }

}
