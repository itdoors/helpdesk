<?php

/**
 * stuff_departments form base class.
 *
 * @method stuff_departments getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class Basestuff_departmentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputText(),
      'stuff_id'       => new sfWidgetFormInputHidden(),
      'departments_id' => new sfWidgetFormInputHidden(),
      'claimtype_id'   => new sfWidgetFormInputHidden(),
      'userkey'        => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorInteger(array('required' => false)),
      'stuff_id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('stuff_id')), 'empty_value' => $this->getObject()->get('stuff_id'), 'required' => false)),
      'departments_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('departments_id')), 'empty_value' => $this->getObject()->get('departments_id'), 'required' => false)),
      'claimtype_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('claimtype_id')), 'empty_value' => $this->getObject()->get('claimtype_id'), 'required' => false)),
      'userkey'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('userkey')), 'empty_value' => $this->getObject()->get('userkey'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('stuff_departments[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'stuff_departments';
  }

}
