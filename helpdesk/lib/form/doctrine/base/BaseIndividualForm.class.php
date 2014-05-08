<?php

/**
 * Individual form base class.
 *
 * @method Individual getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseIndividualForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'guid'        => new sfWidgetFormInputText(),
      'first_name'  => new sfWidgetFormInputText(),
      'middle_name' => new sfWidgetFormInputText(),
      'last_name'   => new sfWidgetFormInputText(),
      'birthday'    => new sfWidgetFormDate(),
      'tin'         => new sfWidgetFormInputText(),
      'passport'    => new sfWidgetFormInputText(),
      'phone'       => new sfWidgetFormInputText(),
      'address'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'guid'        => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'first_name'  => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'middle_name' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'last_name'   => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'birthday'    => new sfValidatorDate(array('required' => false)),
      'tin'         => new sfValidatorString(array('max_length' => 24, 'required' => false)),
      'passport'    => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'phone'       => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'address'     => new sfValidatorString(array('max_length' => 128, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('individual[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Individual';
  }

}
