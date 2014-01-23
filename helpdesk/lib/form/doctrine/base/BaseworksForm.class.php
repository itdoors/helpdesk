<?php

/**
 * works form base class.
 *
 * @method works getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseworksForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'name'          => new sfWidgetFormInputText(),
      'income_nonnds' => new sfWidgetFormInputText(),
      'costs_n'       => new sfWidgetFormInputText(),
      'costs_nonnds'  => new sfWidgetFormInputText(),
      'status_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'add_empty' => true)),
      'workstypes_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('workstypes'), 'add_empty' => true)),
      'claim_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'claim')),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'          => new sfValidatorString(array('max_length' => 255)),
      'income_nonnds' => new sfValidatorNumber(array('required' => false)),
      'costs_n'       => new sfValidatorNumber(array('required' => false)),
      'costs_nonnds'  => new sfValidatorNumber(array('required' => false)),
      'status_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Status'), 'required' => false)),
      'workstypes_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('workstypes'), 'required' => false)),
      'claim_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'claim', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'works', 'column' => array('name')))
    );

    $this->widgetSchema->setNameFormat('works[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'works';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['claim_list']))
    {
      $this->setDefault('claim_list', $this->object->Claim->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveClaimList($con);

    parent::doSave($con);
  }

  public function saveClaimList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['claim_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Claim->getPrimaryKeys();
    $values = $this->getValue('claim_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Claim', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Claim', array_values($link));
    }
  }

}
