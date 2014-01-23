<?php

/**
 * ModelContact form base class.
 *
 * @method ModelContact getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseModelContactForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'model_name'  => new sfWidgetFormInputText(),
      'model_id'    => new sfWidgetFormInputText(),
      'sort'        => new sfWidgetFormInputText(),
      'first_name'  => new sfWidgetFormInputText(),
      'last_name'   => new sfWidgetFormInputText(),
      'middle_name' => new sfWidgetFormInputText(),
      'phone1'      => new sfWidgetFormInputText(),
      'phone2'      => new sfWidgetFormInputText(),
      'position'    => new sfWidgetFormInputText(),
      'email'       => new sfWidgetFormInputText(),
      'birthday'    => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'model_name'  => new sfValidatorString(array('max_length' => 255)),
      'model_id'    => new sfValidatorInteger(array('required' => false)),
      'sort'        => new sfValidatorInteger(array('required' => false)),
      'first_name'  => new sfValidatorString(array('max_length' => 255)),
      'last_name'   => new sfValidatorString(array('max_length' => 255)),
      'middle_name' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone1'      => new sfValidatorString(array('max_length' => 255)),
      'phone2'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'position'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'       => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'birthday'    => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('model_contact[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ModelContact';
  }

}
