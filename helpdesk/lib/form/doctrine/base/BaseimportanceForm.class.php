<?php

/**
 * importance form base class.
 *
 * @method importance getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseimportanceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInputText(),
      'color'         => new sfWidgetFormInputText(),
      'duration'      => new sfWidgetFormInputText(),
      'contract_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'contract')),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 100)),
      'color'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'duration'      => new sfValidatorInteger(array('required' => false)),
      'contract_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'contract', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('importance[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'importance';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['contract_list']))
    {
      $this->setDefault('contract_list', $this->object->Contract->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveContractList($con);

    parent::doSave($con);
  }

  public function saveContractList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['contract_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Contract->getPrimaryKeys();
    $values = $this->getValue('contract_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Contract', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Contract', array_values($link));
    }
  }

}
