<?php

/**
 * TechnicalParamDepartments form base class.
 *
 * @method TechnicalParamDepartments getObject() Returns the current form's model object
 *
 * @package    helpdesk
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTechnicalParamDepartmentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'department_id' => new sfWidgetFormInputHidden(),
      'param_id'      => new sfWidgetFormInputHidden(),
      'value'         => new sfWidgetFormInputText(),
      'date'          => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'department_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('department_id')), 'empty_value' => $this->getObject()->get('department_id'), 'required' => false)),
      'param_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('param_id')), 'empty_value' => $this->getObject()->get('param_id'), 'required' => false)),
      'value'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date'          => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('technical_param_departments[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'TechnicalParamDepartments';
  }

}
